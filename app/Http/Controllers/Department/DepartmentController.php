<?php

namespace App\Http\Controllers\Department;

use App\Department;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{

	/**
	 * DepartmentController constructor.
	 */
	public function __construct()
	{
		$this->middleware('auth')->except('getList');
	}

	public function getList(Request $request){
    	$search=$request->input('search');

		$departments=Department::where('name','like','%'.$search.'%')
								->whereNull('hidden_at');

		if(Auth::check()){ //user is login
			if(Auth::user()->owner() || Auth::user()->admin() || Auth::user()->leader() || Auth::user()->staff()){
				$departments=Department::where('name','like','%'.$search.'%');
			}
		}

		return response()->json($departments->paginate(),200);
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
    	// Check policy
		$this->authorize('index',Department::class);

    	$search=$request->input('search');

		$departments=Auth::user()->leaderInDepartments()
						 ->where('name','like','%'.$search.'%');

    	if(Auth::user()->owner() || Auth::user()->admin()){
			$departments=Department::where('name','like','%'.$search.'%');
		}

		if($request->expectsJson()){
        	return response()->json($departments->paginate(),200);
        }

        return view('department.index')->with(['departments'=>$departments->simplePaginate(),'search'=>$search]);
    }

    /**
     * Show the form for creating a new resource.
     *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
    public function create()
    {
    	// Check policy
		$this->authorize('create',Department::class);

        return view('department.create');
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
    	// Check policy
		$this->authorize('index',Department::class);

		// validate request
		$validator=$this->validateRequest($request);
		if($validator->fails()){
			if($request->expectsJson()){
				return response()->json($validator->errors(),422);
			}
			return redirect()->back()
				->withInput($request->all())
				->withErrors($validator->errors());
		}

		$managers=array_values(($request->input('managers')?:[]));
		$leaders=array_values(($request->input('leaders')?:[]));
		$users=$this->getRequestManagers($managers,$leaders);

		$data=[
			'name'=>$request->input('name'),
			'hidden_at'=>( $request->input('name')==true ? Carbon::now()->getTimestamp() : null ),
		];

		$department=Department::create($data);
		$department->users()->sync($users);

		$status=trans('general.store_success');

        if(request()->expectsJson()){
        	return response()->json([
        		'status'=>$status,
        		'department'=>$department,
			]);
        }

        Session::flash('success',$status);

		return redirect()->route('department.index');
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
    	$department=Department::findorFail($id);

    	// Check policy
		$this->authorize('view',$department);

        if(request()->expectsJson()){
        	return response()->json([
        		'department'=>$department,
			]);
        }

		return view('department.show')->with('department',$department);
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
    	$department=Department::findorFail($id);

    	// Check policy
		$this->authorize('update',$department);

        if(request()->expectsJson()){
        	return response()->json([
        		'department'=>$department,
			]);
        }

		return view('department.edit')->with('department',$department);
    }

    /**
     * Update the specified resource in storage.
	 *
	 * Owner and admin can update all of department settings.
	 * Department's leader can update it's name , staffs and Visibility.
     *
	 * @param Request $request
	 * @param $id
	 * @return $this|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
    public function update(Request $request, $id)
    {
		// validate request
		$validator=$this->validateRequest($request,$id);
		if($validator->fails()){
			if($request->expectsJson()){
				return response()->json($validator->errors(),422);
			}
			return redirect()->back()
				->withInput($request->all())
				->withErrors($validator->errors());
		}

		$department=Department::findorFail($id);

    	// Check policy
		$this->authorize('update',$department);

		if(Auth::user()->owner() || Auth::user()->admin()){
			//owner and admin can add both leaders and managers
			$managers=array_values(($request->input('managers')?:[]));
			$leaders=array_values(($request->input('leaders')?:[]));
			$users=$this->getRequestManagers($managers,$leaders);
		}else{
			//leader can add only managers
			$managers=array_values(($request->input('managers')?:[]));
			//current leaders
			$leaders=$department->leaders()->pluck('user_id')->toArray();
			$users=$this->getRequestManagers($managers,$leaders);
		}

		$data=[
			'name'=>$request->input('name'),
			'hidden_at'=>( $request->input('hidden')==true ? Carbon::now()->getTimestamp() : null ),
		];

		$department->update($data);
		$department->users()->sync($users);

		$status=trans('general.update_success');

        if(request()->expectsJson()){
        	return response()->json([
        		'status'=>$status,
        		'department'=>$department,
			]);
        }

        Session::flash('success',$status);

		return redirect()->route('department.edit',$department);
    }

	/**
	 * remove the specified department from storage.
	 *
	 * @param $id
	 * @return \Illuminate\Http\RedirectResponse
	 * @throws \Exception
	 */
    public function destroy($id)
    {
        $department=Department::findorFail($id);

    	// Check policy
		$this->authorize('delete',$department);

		$department->delete();

		$status=trans('general.delete_success');

        if(request()->expectsJson()){
        	return response()->json([
        		'status'=>$status,
			]);
        }

        Session::flash('success',$status);

		return redirect()->route('department.index');
    }

    public function validateRequest(Request $request,$id=null){
    	return Validator::make($request->all(),[
    		'name' 		=> 'required|string|unique:departments,name'.($id ? (','.$id) : ''),
    		'managers' 	=> 'nullable|exists:users,id',
    		'leaders' 	=> 'nullable|exists:users,id',
    		'hidden' 	=> 'nullable|boolean',
		]);
    }

    public function getRequestManagers($managers,$leaders){
		$users=array_unique(array_merge($managers,$leaders), SORT_REGULAR);

		$managers=[];
		foreach($users as $key=>$user){
			if(in_array($user,$leaders)){
				$managers[$user]=['is_leader'=>true];
				continue;
			}
			$managers[$user]=['is_leader'=>false];
		}
		return $managers;
    }
}
