<?php

namespace App\Http\Controllers\Department;

use App\Department;
use App\User;
use App\UserMeta;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class StaffController extends Controller
{

	/**
	 * Length for email confirmation token.
	 *
	 * @var int
	 */
	protected $emailTokenLength=64;

	/**
	 * Length for mobile confirmation token.
	 *
	 * @var int
	 */
	protected $mobileTokenLength=6;

	/**
	 * StaffController constructor.
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
     * Display a listing of the resource.
	 *
	 * @param Request $request
	 * @return $this|\Illuminate\Http\JsonResponse
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
    public function index(Request $request)
    {
		// Add policy
        $this->authorize('staffIndex',User::class);

    	$search=$request->input('search');

    	if(Auth::user()->owner() || Auth::user()->admin()){
    		//see all of staffs and leaders
			$staffs=User::where(function($query) use ($search){
							$query->where('email','like','%'.$search.'%')
								  ->has('departments');
						})
						->orWhere(function($query) use ($search){
							$query->where('mobile','like','%'.$search.'%')
								  ->has('departments');
						});
		}elseif(Auth::user()->leader()){
			//leader can see the staff's of his departments that is leader of them.
			$staffs=User::where(function($query) use ($search){
							$query->where('email','like','%'.$search.'%')
								  ->whereHas('staffInDepartments',function($query){
									  $departments=Auth::user()->leaderInDepartments()->pluck('department_id')->toArray();
									  $query->whereIn('departments_users.department_id',$departments);
								  });
						})
						->orWhere(function($query) use ($search){
							$query->where('mobile','like','%'.$search.'%')
								  ->whereHas('staffInDepartments',function($query){
								  	  $departments=Auth::user()->leaderInDepartments()->pluck('department_id')->toArray();
									  $query->whereIn('departments_users.department_id',$departments);
								  });
						});

		}

        if($request->expectsJson()){
        	return response()->json($staffs->paginate(),200);
        }

        return view('departmentStaff.index')->with('staffs',$staffs->simplePaginate());
    }

	/**
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
	public function garbage(Request $request){
    	$this->authorize('staffGarbage',User::class);
    	$search=$request->input('search');

    	if(Auth::user()->owner() || Auth::user()->admin()){
    		//see all of staffs and leaders
			$staffs=User::where(function($query) use ($search){
							$query->where('email','like','%'.$search.'%')
								  ->has('departments');
						})
						->onlyTrashed()
						->orWhere(function($query) use ($search){
							$query->where('mobile','like','%'.$search.'%')
								  ->has('departments');
						})
						->onlyTrashed();
		}elseif(Auth::user()->leader()){
			//leader can see the staff's of his departments that is leader of them.
			$staffs=User::where(function($query) use ($search){
							$query->where('email','like','%'.$search.'%')
								  ->whereHas('staffInDepartments',function($query){
									  $departments=Auth::user()->leaderInDepartments()->pluck('department_id')->toArray();
									  $query->whereIn('departments_users.department_id',$departments);
								  });
						})
						->onlyTrashed()
						->orWhere(function($query) use ($search){
							$query->where('mobile','like','%'.$search.'%')
								  ->whereHas('staffInDepartments',function($query){
								  	  $departments=Auth::user()->leaderInDepartments()->pluck('department_id')->toArray();
									  $query->whereIn('departments_users.department_id',$departments);
								  });
						})
						->onlyTrashed();

		}

        if($request->expectsJson()){
        	return response()->json($staffs->paginate(),200);
        }

		return view('departmentStaff.garbage')->with('staffs',$staffs->paginate());
	}

	/**
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
	public function recycle($id){
        $staff=User::onlyTrashed()->has('departments')->findOrFail($id);

    	$this->authorize('staffRecycle',$staff);

    	$staff->restore();

		$status=trans('general.update_success');

        if(request()->expectsJson()){
        	return response()->json([
        		'status'=>$status,
			]);
        }

        Session::flash('success',$status);

		return redirect()->route('staff.garbage');
	}

	/**
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
	public function permanentDestroy($id){
        $staff=User::onlyTrashed()->has('departments')->findOrFail($id);

    	$this->authorize('staffPermanentDelete',$staff);

    	$staff->forceDelete();

		$status=trans('general.delete_success');

        if(request()->expectsJson()){
        	return response()->json([
        		'status'=>$status,
			]);
        }

        Session::flash('success',$status);

		return redirect()->route('staff.garbage');
	}

	/**
	 * validates user's data
	 *
	 * @param Request $request
	 * @param $staff_id|null
	 * @return mixed
	 */
    public function validateUser(Request $request,$staff_id=null){
        return Validator::make($request->all(), [
        	'mobile'				=> 'bail|required_without_all:email|nullable|numeric|unique:users,mobile'.(empty($staff_id)? '' : ','.$staff_id ),
            'email'					=> 'required_without_all:mobile|nullable|string|email|max:255|unique:users,email'.(empty($staff_id)? '' : ','.$staff_id ),
            'password' 				=> (empty($staff_id) ? '' : 'nullable|').'string|min:6|confirmed',
        	'locked'	 			=> 'nullable|boolean',
        ]);
    }

	/**
	 * validates user's metaData
	 *
	 * @param Request $request
	 * @return mixed
	 */
    public function validateUserMeta(Request $request){
		return Validator::make($request->all(),[
        	'name'				=> 'bail|required|min:3',
        	'phone' 			=> 'nullable|numeric',
            'gender'			=> 'nullable|in:male,female',
        	'country' 			=> 'nullable|exists:countries,id',
            'province' 			=> 'nullable|exists:provinces,id',
            'city' 				=> 'nullable|exists:cities,id',
            'biography' 		=> 'nullable|string|min:6',
            'avatar' 			=> 'nullable|image|file',
        	'admin' 			=> 'nullable|boolean',
		]);
    }

	/**
	 * validates department
	 *
	 * @param Request $request
	 * @return mixed
	 */
    public function validateDepartment(Request $request){
		return Validator::make($request->all(),[
        	'departments'	=> 'required|array|exists:departments,id',
		]);
    }

    /**
     * Show the form for creating a new resource.
     *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
    public function create()
    {
		// Add policy
        $this->authorize('staffCreate',User::class);

        return view('departmentStaff.create');
    }

    /**
     * Store a newly created resource in storage.
     *
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
    public function store(Request $request)
    {
		// Add policy
        $this->authorize('staffCreate',User::class);

        //validate user's data
        $validator=$this->validateUser($request);
		if($validator->fails()){
			if($request->expectsJson()){
				return response()->json($validator->errors(),422);
			}
			return redirect()->back()
				->withInput($request->all())
				->withErrors($validator->errors());
		}

        //validate user's metaData
        $validator=$this->validateUserMeta($request);
		if($validator->fails()){
			if($request->expectsJson()){
				return response()->json($validator->errors(),422);
			}
			return redirect()->back()
				->withInput($request->all())
				->withErrors($validator->errors());
		}

		//validate department
        $validator=$this->validateDepartment($request);
		if($validator->fails()){
			if($request->expectsJson()){
				return response()->json($validator->errors(),422);
			}
			return redirect()->back()
				->withInput($request->all())
				->withErrors($validator->errors());
		}

		$email_need_verification=( !empty($request->input('email_verification')) && !empty($request->input('email')) );
		$mobile_need_verification=( !empty($request->input('mobile_verification')) && !empty($request->input('mobile')) );

		//only owner user can create new admin
		if(Auth::user()->owner()){
			$is_admin=(boolean)$request->input('admin');
		}else{
			$is_admin=false;
		}

		//owner and admin can lock other users
		if( (Auth::user()->owner() || Auth::user()->admin()) ){
			$locked_at=!($request->input('locked')) ? Carbon::now()->getTimestamp() : null;
		}else{
			$locked_at=null;
		}

		$staffData=[
			'email'					=> $request->input('email'),
			'mobile'				=> $request->input('mobile'),
			'is_admin'				=> ($is_admin),
			'locked_at'				=> ( $locked_at ),
			'email_verified_at'		=> ( !( $email_need_verification ) ? Carbon::now()->getTimestamp() : null ),
			'mobile_verified_at'	=> ( !( $mobile_need_verification ) ? Carbon::now()->getTimestamp() : null ),
            'email_token'			=> ( ( $email_need_verification ) ? $this->emailTokenLength : null ),
            'mobile_token'			=> ( ( $mobile_need_verification ) ? $this->mobileTokenLength : null ),
            'password'				=> ( $request->input('password') ),
		];

		//create user
		$staff=User::create($staffData);

		//create user's meta
		$staffMetaData=[
			'name'			=> $request->input('name'),
			'phone'			=> $request->input('phone'),
			'gender'		=> $request->input('gender'),
			'country_id'	=> $request->input('country'),
			'province_id'	=> $request->input('province'),
			'city_id'		=> $request->input('city'),
			'biography'		=> $request->input('biography'),
			'avatar'		=> $request->input('avatar'),
			'user_id'		=> $staff->id,
		];

		UserMeta::create($staffMetaData);

		//add user's departments

    	if(Auth::user()->owner() || Auth::user()->admin()){
			$departments=$request->input('departments');
		}elseif(Auth::user()->leader()){
			//leader can add staffs, only in his/her department
			$departments=$request->input('departments');
			$leaderDepartments=Auth::user()->leaderInDepartments()->pluck('department_id')->toArray();
			//remove the departments that user is not leader in them.
			$departments=array_intersect($departments,$leaderDepartments);
		}

		$staff->departments()->sync($departments);


		//send an sms to verify mobile number
		if($staff->mobile && $staff->mobileUnverified()){
			$staff->sendPinNotification();
		}

		//send as Email to verify E-mail address
		if($staff->email && $staff->emailUnverified()){
			$staff->sendTokenNotification();
		}

		$status=trans('general.store_success');

        if($request->expectsJson()){
        	return response()->json([
        		'status'=>$status,
        		'user'=>$staff,
			]);
        }

        Session::flash('success',$status);

		return redirect()->route('staff.index');
    }

    /**
     * Display the specified resource.
     *
	 * @param $id
	 * @return $this|\Illuminate\Http\JsonResponse
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
    public function show($id)
    {
        $staff=User::has('departments')->findOrFail($id);

		// Add policy
        $this->authorize('staffView',$staff);

        if(request()->expectsJson()){
        	return response()->json($staff,200);
        }
		return view('departmentStaff.show')->with('staff',$staff);
    }

    /**
     * Show the form for editing the specified resource.
     *
	 * @param $id
	 * @return $this|\Illuminate\Http\JsonResponse
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
    public function edit($id)
    {
        $staff=User::findOrFail($id);

		// Add policy
        $this->authorize('staffUpdate',$staff);

        if(request()->expectsJson()){
        	return response()->json($staff,200);
        }
        return view('departmentStaff.edit')->with('staff',$staff);
    }

    /**
     * Update the specified resource in storage.
     *
	 * @param Request $request
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
    public function update(Request $request, $id)
    {

        //validate user's data
        $validator=$this->validateUser($request,$id);
		if($validator->fails()){
			if($request->expectsJson()){
				return response()->json($validator->errors(),422);
			}
			return redirect()->back()
				->withInput($request->all())
				->withErrors($validator->errors());
		}

        //validate user's metaData
        $validator=$this->validateUserMeta($request);
		if($validator->fails()){
			if($request->expectsJson()){
				return response()->json($validator->errors(),422);
			}
			return redirect()->back()
				->withInput($request->all())
				->withErrors($validator->errors());
		}

		//validate department
        $validator=$this->validateDepartment($request);
		if($validator->fails()){
			if($request->expectsJson()){
				return response()->json($validator->errors(),422);
			}
			return redirect()->back()
				->withInput($request->all())
				->withErrors($validator->errors());
		}

        $staff=User::findOrFail($id);

		// Add policy
        $this->authorize('staffUpdate',$staff);

		//only owner user can create another admin user
		if(Auth::id()!=$staff->id && Auth::user()->owner()){
			$is_admin=(boolean)$request->input('admin');
		}else{
			$is_admin=$staff->admin();
		}

		//owner and admin can lock other users
		if( Auth::id()!=$staff->id && (Auth::user()->owner() || Auth::user()->admin()) ){
			$locked_at=!($request->input('locked')) ? Carbon::now()->getTimestamp() : null;
		}else{
			$locked_at=$staff->locked_at;
		}

		$staffData=[
			'email'					=> $request->input('email'),
			'mobile'				=> $request->input('mobile'),
			'is_admin'				=> ($is_admin),
			'locked_at'				=> ( $locked_at ),
		];

        //check if email going to be changed?
        //if user changes his/her E-Mail address, needs to verified it again
		if($staff->email!=$request->input('email')){
			$staffData['email_verified_at']=null;
		}
        //check if mobile going to be changed?
        //if user changes his/her mobile number, needs to verified it again
		if($staff->mobile!=$request->input('mobile')){
			$staffData['mobile_verified_at']=null;
		}

		//change password if it's not empty
		if(!empty($request->input('password'))){
			$staffData['password']=$request->input('password');
		}

		//set email token --> when email needs verification
		//if former email not verified or user want's to set new email
		if(($staff->email && $staff->emailUnverified()) || ($staff->email!=$request->input('email'))){
			$staffData['email_token']=( $this->emailTokenLength );
		}

		//set mobile pin --> when mobile needs verification:
		//if former mobile not verified or user want's to set new mobile
		if(($staff->mobile && $staff->mobileUnverified()) || ($staff->mobile!=$request->input('mobile'))){
            $staffData['mobile_token']=( $this->mobileTokenLength );
		}

		//update user
		$staff->update($staffData);

		//update user's meta
		$staffMetaData=[
			'name'			=> $request->input('name'),
			'phone'			=> $request->input('phone'),
			'gender'		=> $request->input('gender'),
			'country_id'	=> $request->input('country'),
			'province_id'	=> $request->input('province'),
			'city_id'		=> $request->input('city'),
			'biography'		=> $request->input('biography'),
			'avatar'		=> $request->input('avatar'),
			'user_id'		=> $staff->id,
		];

		if($staff->meta){ //if user meta exists:
			$staff->meta()->update($staffMetaData);
		}else{ // if user meta not exists create new one:
			UserMeta::create($staffMetaData);
		}

		//sync user's departments

    	if(Auth::user()->owner() || Auth::user()->admin()){
			$departments=$request->input('departments');
		}elseif(Auth::user()->leader()){
			//leader can add staffs, only in his/her department
			$departments=$request->input('departments');
			$leaderDepartments=Auth::user()->leaderInDepartments()->pluck('department_id')->toArray();
			//remove the departments that user is not leader in them.
			$departments=array_intersect($departments,$leaderDepartments);
		}

		$staff->departments()->sync($departments);

		//send an sms to verify mobile number
		if($staff->mobile && $staff->mobileUnverified()){
			$staff->sendPinNotification();
		}

		//send as Email to verify E-mail address
		if($staff->email && $staff->emailUnverified()){
			$staff->sendTokenNotification();
		}

		$status=trans('general.update_success');

        if($request->expectsJson()){
        	return response()->json([
        		'status'=>$status,
        		'user'=>$staff,
			]);
        }

        Session::flash('success',$status);

		return redirect()->route('staff.index');
    }

	/**
     * Remove the specified resource from storage.
     *
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
	 * @throws \Exception
	 */
    public function destroy($id)
    {
		$staff=User::findOrFail($id);

		// Add policy
        $this->authorize('staffDelete',$staff);

		$staff->delete();

		$status=trans('general.delete_success');

        if(request()->expectsJson()){
        	return response()->json([
        		'status'=>$status,
        		'user'=>$staff,
			]);
        }

        Session::flash('success',$status);

		return redirect()->back();
    }
}
