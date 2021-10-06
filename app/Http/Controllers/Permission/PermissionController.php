<?php

namespace App\Http\Controllers\Permission;

use App\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
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
		$this->authorize('index',Permission::class);

    	$search=$request->input('search');

		$permissions=Permission::where('name','like','%'.$search.'%');

        if($request->expectsJson()){
        	return response()->json($permissions->paginate(),200);
        }

        return view('permission.index')->with('permissions',$permissions->simplePaginate());
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
		$this->authorize('create',Permission::class);

        return view('permission.create');
    }

	/**
	 * validate request
	 *
	 * @param Request $request
	 * @return mixed
	 */
    public function validatePermission(Request $request){
    	return Validator::make($request->all(),[
			'name' => 'required|string|min:3|unique:permissions,name',
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
		$this->authorize('create',Permission::class);

        $validator=$this->validatePermission($request);
		if($validator->fails()){
			if($request->expectsJson()){
				return response()->json($validator->errors(),422);
			}
			return redirect()->back()
				->withInput($request->all())
				->withErrors($validator->errors());
		}

		$data=$request->only(['name']);
		$permission=Permission::create($data);

		$status=trans('general.store_success');

        if(request()->expectsJson()){
        	return response()->json([
        		'status'=>$status,
        		'permission'=>$permission,
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
    	$permission=Permission::findOrFail($id);

		//check policy
		$this->authorize('show',$permission);

        if(request()->expectsJson()){
        	return response()->json([
        		'permission'=>$permission,
			]);
        }

        return view('permission.show')->with('permission',$permission);
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
    	$permission=Permission::findOrFail($id);

    	//check policy
		$this->authorize('update',$permission);

        if(request()->expectsJson()){
        	return response()->json([
        		'permission'=>$permission,
			]);
        }

        return view('permission.edit')->with('permission',$permission);
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
        $validator=$this->validatePermission($request);
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

    	$permission=Permission::findOrFail($id);

		//check policy
		$this->authorize('update',$permission);

		//update data
		$permission->update($data);

		$status=trans('general.update_success');

        if(request()->expectsJson()){
        	return response()->json([
        		'status'=>$status,
        		'permission'=>$permission,
			]);
        }

        Session::flash('success',$status);

		return redirect()->route('permission.edit',$permission);
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
    	$permission=Permission::findOrFail($id);

		//check policy
		$this->authorize('delete',$permission);

    	$permission->delete();

		$status=trans('general.delete_success');

        if(request()->expectsJson()){
        	return response()->json([
        		'status'=>$status,
			]);
        }

        Session::flash('success',$status);

		return redirect()->route('permission.index');
    }
}
