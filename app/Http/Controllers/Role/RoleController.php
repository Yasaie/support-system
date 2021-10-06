<?php

namespace App\Http\Controllers\Role;

use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
	/**
	 * NewsController constructor.
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
     * Display a listing of the resource.
     *
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
    public function index(Request $request)
    {
	   	//check policy
		$this->authorize('index',Role::class);

    	$search=$request->input('search');

		$roles=Role::where('name','like','%'.$search.'%');

        if($request->expectsJson()){
        	return response()->json($roles->paginate(),200);
        }

        return view('role.index')->with('roles',$roles->simplePaginate());
    }

    /**
     * Show the form for creating a new resource.
     *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
    public function create()
    {
    	//check policy
		$this->authorize('create',Role::class);

        return view('role.create');
    }

	/**
	 * validate request
	 *
	 * @param Request $request
	 * @param null $id
	 * @return mixed
	 */
    public function validateRole(Request $request,$id=null){
    	return Validator::make($request->all(),[
			'name' => 'required|string|min:3|unique:roles,name'.(empty($id)?'':','.$id),
			'permissions' =>'required|array|exists:permissions,id'
		]);
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
    	//check policy
		$this->authorize('create',Role::class);

        $validator=$this->validateRole($request);
		if($validator->fails()){
			if($request->expectsJson()){
				return response()->json($validator->errors(),422);
			}
			return redirect()->back()
				->withInput($request->all())
				->withErrors($validator->errors());
		}

		$data=$request->only(['name']);
		$role=Role::create($data);

		$role->permissions()->sync($request->input('permissions'));

		$status=trans('general.store_success');

        if(request()->expectsJson()){
        	return response()->json([
        		'status'=>$status,
        		'permission'=>$role,
			]);
        }

        Session::flash('success',$status);

		return redirect()->back()->with($request->all());
    }

    /**
     * Display the specified resource.
     *
	 * @param $id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
    public function show($id)
    {
    	$role=Role::findOrFail($id);

		//check policy
		$this->authorize('show',$role);

        if(request()->expectsJson()){
        	return response()->json([
        		'role'=>$role,
			]);
        }

        return view('role.show')->with('role',$role);
	}

    /**
     * Show the form for editing the specified resource.
     *
	 * @param $id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
    public function edit($id)
    {
    	$role=Role::findOrFail($id);

    	//check policy
		$this->authorize('update',$role);

        if(request()->expectsJson()){
        	return response()->json([
        		'role'=>$role,
			]);
        }

        return view('role.edit')->with('role',$role);
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
        $validator=$this->validateRole($request,$id);
		if($validator->fails()){
			if($request->expectsJson()){
				return response()->json($validator->errors(),422);
			}
			return redirect()->back()
				->withInput($request->all())
				->withErrors($validator->errors());
		}

		$data=[
			'name' => $request->input('name'),
		];

    	$role=Role::findOrFail($id);

		//check policy
		$this->authorize('update',$role);

		//update data
		$role->update($data);

		$role->permissions()->sync($request->input('permissions'));

		$status=trans('general.update_success');

        if(request()->expectsJson()){
        	return response()->json([
        		'status'=>$status,
        		'role'=>$role,
			]);
        }

        Session::flash('success',$status);

		return redirect()->route('role.edit',$role);
    }

    /**
     * Remove the specified resource from storage.
     *
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
    public function destroy($id)
    {
    	$role=Role::findOrFail($id);

		//check policy
		$this->authorize('delete',$role);

    	$role->delete();

		$status=trans('general.delete_success');

        if(request()->expectsJson()){
        	return response()->json([
        		'status'=>$status,
			]);
        }

        Session::flash('success',$status);

		return redirect()->route('role.index');
    }
}
