<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Config\getConfig;
use App\User;
use App\UserMeta;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
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
	 * UserController constructor.
	 */
    public function __construct()
    {
        $this->middleware('auth');
    }

	/**
	 * list user
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
    public function getList(Request $request){
    	$this->authorize('getList',User::class);

    	$search=$request->input('search');
    	$users=User::where('email','like','%'.$search.'%')
    				->orWhere('mobile','like','%'.$search.'%')
					->orWhereHas('meta',function ($query) use ($search){
						$query->where('name','like','%'.$search.'%');
					});
		return response()->json($users->paginate(),200);
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
		$this->authorize('index',User::class);

    	$search=$request->input('search');
    	$users=User::where(function($query) use ($search){
    					$query->where('email','like','%'.$search.'%')
    						  ->where('users.id','<>',Auth::id())
    						  ->whereDoesntHave('departments');
					})
    				->orWhere(function($query) use ($search){
    					$query->where('mobile','like','%'.$search.'%')
    						  ->where('users.id','<>',Auth::id())
    						  ->whereDoesntHave('departments');
    				})
					->orWhereHas('meta',function ($query) use ($search){
						$query->where('name','like','%'.$search.'%')
							  ->where('users.id','<>',Auth::id());
					})->whereDoesntHave('departments');

        if($request->expectsJson()){
        	return response()->json($users->paginate(),200);
        }
        return view('user.index')->with('users',$users->paginate());
    }

	/**
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
	public function garbage(Request $request){
    	$this->authorize('garbage',User::class);
    	$search=$request->input('search');
    	$users=User::onlyTrashed()
					->where(function ($query) use ($search){
						$query->where(function($query) use ($search){
							$query->where('email','like','%'.$search.'%')
								  ->where('users.id','<>',Auth::id())
								  ->whereDoesntHave('departments');
						})
						->orWhere(function($query) use ($search){
							$query->where('mobile','like','%'.$search.'%')
								  ->where('users.id','<>',Auth::id())
								  ->whereDoesntHave('departments');
						})
						->orWhereHas('meta',function ($query) use ($search){
							$query->where('name','like','%'.$search.'%')
								  ->where('users.id','<>',Auth::id());
						})
						->whereDoesntHave('departments');
					});

        if($request->expectsJson()){
        	return response()->json($users->paginate(),200);
        }

		return view('user.garbage')->with('users',$users->paginate());
	}

	/**
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
	public function recycle($id){
    	$user=User::onlyTrashed()->findOrFail($id);

    	$this->authorize('recycle',$user);

    	$user->restore();

		$status=trans('general.update_success');

        if(request()->expectsJson()){
        	return response()->json([
        		'status'=>$status,
			]);
        }

        Session::flash('success',$status);

		return redirect()->route('user.garbage');
	}

	/**
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
	public function permanentDestroy($id){
    	$user=User::onlyTrashed()->findOrFail($id);

    	$this->authorize('permanentDelete',$user);

    	$user->forceDelete();

		$status=trans('general.delete_success');

        if(request()->expectsJson()){
        	return response()->json([
        		'status'=>$status,
			]);
        }

        Session::flash('success',$status);

		return redirect()->route('user.garbage');
	}

	/**
	 * validates user's data
	 *
	 * @param Request $request
	 * @param $user_id|null
	 * @return mixed
	 */
    public function validateUser(Request $request,$user_id=null){
        return Validator::make($request->all(), [
        	'mobile'				=> 'bail|required_without_all:email|nullable|numeric|unique:users,mobile'.(empty($user_id)? '' : ','.$user_id ),
            'email'					=> 'required_without_all:mobile|nullable|string|email|max:255|unique:users,email'.(empty($user_id)? '' : ','.$user_id ),
            'password' 				=> (empty($user_id) ? '' : 'nullable|').'string|min:6|confirmed',
        	'locked'	 			=> 'nullable|boolean',
        	'admin' 				=> 'nullable|boolean',
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
            'avatar' 			=> 'nullable|exists:medias,id',
		]);
    }

	/**
	 * validates selected roles
	 *
	 * @param Request $request
	 * @return mixed
	 */
    public function validateRole(Request $request){
		return Validator::make($request->all(),[
        	'roles'	=> 'nullable|array|exists:roles,id',
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
		$this->authorize('create',User::class);

       return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
	 * @param Request $request
	 * @return $this|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
    public function store(Request $request)
    {
		$this->authorize('create',User::class);

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

		$userData=[
			'email'					=> $request->input('email'),
			'mobile'				=> $request->input('mobile'),
			'is_admin'				=> ( $is_admin ),
			'locked_at'				=> ( $locked_at ),
			'email_verified_at'		=> ( !( $email_need_verification ) ? Carbon::now()->getTimestamp() : null ),
			'mobile_verified_at'	=> ( !( $mobile_need_verification ) ? Carbon::now()->getTimestamp() : null ),
            'email_token'			=> ( ( $email_need_verification ) ? $this->emailTokenLength : null ),
            'mobile_token'			=> ( ( $mobile_need_verification ) ? $this->mobileTokenLength : null ),
            'password'				=> ( $request->input('password') ),
		];

		//create user
		$user=User::create($userData);

		//create user's meta
		$userMetaData=[
			'name'			=> $request->input('name'),
			'phone'			=> $request->input('phone'),
			'gender'		=> $request->input('gender'),
			'country_id'	=> $request->input('country'),
			'province_id'	=> $request->input('province'),
			'city_id'		=> $request->input('city'),
			'biography'		=> $request->input('biography'),
			'avatar'		=> $request->input('avatar'),
			'user_id'		=> $user->id,
		];

		UserMeta::create($userMetaData);

		//send an sms to verify mobile number
		if($user->mobile && $user->mobileUnverified()){
			$user->sendPinNotification();
		}

		//send as Email to verify E-mail address
		if($user->email && $user->emailUnverified()){
			$user->sendTokenNotification();
		}

		$status=trans('general.store_success');

        if(request()->expectsJson()){
        	return response()->json([
        		'status'=>$status,
        		'user'=>$user,
			]);
        }

        Session::flash('success',$status);

		return redirect()->route('user.index');
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
        $user=User::findOrFail($id);

		$this->authorize('view',$user);

        if(request()->expectsJson()){
        	return response()->json($user,200);
        }

		if(Auth::user()->owner() || Auth::user()->admin()){
			//admin and owner
			return view('user.adminShow')->with('user',$user);
		}elseif(Auth::user()->leader() || Auth::user()->staff()){
			//staff and leader
			return view('user.adminShow')->with('user',$user);
		}else{
			//simple user
			return view('user.userShow')->with('user',$user);
		}
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
        $user=User::findOrFail($id);

		$this->authorize('update',$user);

        if(request()->expectsJson()){
        	return response()->json($user,200);
        }

		if(Auth::user()->owner() || Auth::user()->admin()){
			//admin and owner
			return view('user.adminEdit')->with('user',$user);
		}elseif(Auth::user()->leader() || Auth::user()->staff()){
			//staff and leader
			return view('user.adminEdit')->with('user',$user);
		}else{
			//simple user
			return view('user.userEdit')->with('user',$user);
		}
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

        //validate selected roles
        $validator=$this->validateRole($request);
		if($validator->fails()){
			if($request->expectsJson()){
				return response()->json($validator->errors(),422);
			}
			return redirect()->back()
				->withInput($request->all())
				->withErrors($validator->errors());
		}

        $user=User::findOrFail($id);

		$this->authorize('update',$user);

		//only owner user can create another admin user
		if(Auth::id()!=$user->id && Auth::user()->owner()){
			$is_admin=(boolean)$request->input('admin');
		}else{
			$is_admin=$user->admin();
		}

		//owner and admin can lock other users
		if( Auth::id()!=$user->id && (Auth::user()->owner() || Auth::user()->admin()) ){
			$locked_at=!($request->input('locked')) ? Carbon::now()->getTimestamp() : null;
		}else{
			$locked_at=$user->locked_at;
		}

		$userData=[
			'email'					=> $request->input('email'),
			'mobile'				=> $request->input('mobile'),
			'is_admin'				=> ( $is_admin ),
			'locked_at'				=> ( $locked_at ),
		];

        //check if email going to be changed?
        //if user changes his/her E-Mail address, needs to verified it again
        if($user->email!=$request->input('email') and getConfig::email_verification_status()){
			$userData['email_verified_at']=null;
		}
        //check if mobile going to be changed?
        //if user changes his/her mobile number, needs to verified it again
		if($user->mobile!=$request->input('mobile') and getConfig::mobile_verification_status()){
			$userData['mobile_verified_at']=null;
		}

		//change password if it's not empty
		if(!empty($request->input('password'))){
			$userData['password']=$request->input('password');
		}

		//set email token --> when email needs verification
		//if former email not verified or user want's to set new email
		if(($user->email && $user->emailUnverified()) || ($user->email!=$request->input('email'))){
			$userData['email_token']=( $this->emailTokenLength );
		}

		//set mobile pin --> when mobile needs verification:
		//if former mobile not verified or user want's to set new mobile
		if(($user->mobile && $user->mobileUnverified()) || ($user->mobile!=$request->input('mobile'))){
            $userData['mobile_token']=( $this->mobileTokenLength );
		}

		//update user
		$user->update($userData);

		//update user's meta
		$userMetaData=[
			'name'			=> $request->input('name'),
			'phone'			=> $request->input('phone'),
			'gender'		=> $request->input('gender'),
			'country_id'	=> $request->input('country'),
			'province_id'	=> $request->input('province'),
			'city_id'		=> $request->input('city'),
			'biography'		=> $request->input('biography'),
			'avatar'		=> $request->input('avatar'),
			'user_id'		=> $user->id,
		];

		if($user->meta){ //if user meta exists:
			$user->meta()->update($userMetaData);
		}else{ // if user meta not exists create new one:
			UserMeta::create($userMetaData);
		}

		//sync user roles
		$user->roles()->sync($request->input('roles'));

		//send as Email to verify E-mail address
		if($user->email && $user->emailUnverified()){
			$user->sendTokenNotification();
		}

		//send an sms to verify mobile number
		if($user->mobile && $user->mobileUnverified()){
			$user->sendPinNotification();
		}

		$status=trans('general.update_success');

        if($request->expectsJson()){
        	return response()->json([
        		'status'=>$status,
        		'user'=>$user,
			]);
        }

        Session::flash('success',$status);

		return redirect()->route('user.edit',$user);
    }

    /**
     * Remove the specified resource from storage.
	 *
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
	 * @throws \Exception
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
    public function destroy($id)
    {
		$user=User::findOrFail($id);

		$this->authorize('delete',$user);

		$user->delete();

		$status=trans('general.delete_success');

        if(request()->expectsJson()){
        	return response()->json([
        		'status'=>$status,
        		'user'=>$user,
			]);
        }

        Session::flash('success',$status);

		return redirect()->back();
    }
}
