<?php

namespace App\Http\Controllers\Province;

use App\Province;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ProvinceController extends Controller
{

	/**
	 * ProvinceController constructor.
	 */
	public function __construct()
	{
		$this->middleware('auth')->except('getList');
	}

	/**
	 * list of provinces
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getList(Request $request){
    	$search=$request->input('search');
    	$country=$request->input('country');

    	$provinces=Province::where('name','like','%'.$search.'%');

    	if($country){
    		$provinces=$provinces->where('country_id','=',$country);
    	}

		return response()->json($provinces->paginate(),200);
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
		$this->authorize('index',Province::class);

    	$search=$request->input('search');
    	$country=$request->input('country');

    	$provinces=Province::where('name','like','%'.$search.'%');

    	if($country){
    		$provinces=$provinces->where('country_id','=',$country);
    	}

        if($request->expectsJson()){
        	return response()->json($provinces->paginate(),200);
        }

        return view('province.index')->with('provinces',$provinces->simplePaginate());
    }

	/**
	 * validate request
	 *
	 * @param Request $request
	 * @param null $province_id
	 * @return mixed
	 */
    public function validateProvince(Request $request,$province_id=null){
    	return Validator::make($request->all(),[
			'name'=>'required|string|min:3|unique:provinces,name'.( empty($province_id)?'':(','.$province_id) ),
			'country'=>'required|exists:countries,id',
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
    	// Check policy
		$this->authorize('create',Province::class);

        return view('province.create');
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
		$this->authorize('create',Province::class);

        $validator=$this->validateProvince($request);
		if($validator->fails()){
			if($request->expectsJson()){
				return response()->json($validator->errors(),422);
			}
			return redirect()->back()
				->withInput($request->all())
				->withErrors($validator->errors());
		}

		$data=[
			'name'=>$request->input('name'),
			'country_id'=>$request->input('country'),
		];

		$province=Province::create($data);

		$status=trans('general.store_success');

        if(request()->expectsJson()){
        	return response()->json([
        		'status'=>$status,
        		'province'=>$province,
			]);
        }

        Session::flash('success',$status);

		return redirect()->back()->with($request->all());
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
    	$province=Province::findOrFail($id);

    	// Check policy
		$this->authorize('view',Province::class);

        if(request()->expectsJson()){
        	return response()->json([
        		'province'=>$province,
			]);
        }

        return view('province.show')->with('province',$province);
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
    	$province=Province::findOrFail($id);

    	// Check policy
		$this->authorize('update',$province);

        if(request()->expectsJson()){
        	return response()->json([
        		'province'=>$province,
			]);
        }

        return view('province.edit')->with('province',$province);
    }

    /**
     * Update the specified resource in storage.
     *
	 * @param Request $request
	 * @param $id
	 * @return $this|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
    public function update(Request $request, $id)
    {
        $validator=$this->validateProvince($request,$id);
		if($validator->fails()){
			if($request->expectsJson()){
				return response()->json($validator->errors(),422);
			}
			return redirect()->back()
				->withInput($request->all())
				->withErrors($validator->errors());
		}

		$data=[
			'name'=>$request->input('name'),
			'country_id'=>$request->input('country'),
		];

    	$province=Province::findOrFail($id);

    	// Check policy
		$this->authorize('update',$province);

		$province->update($data);

		$status=trans('general.update_success');

        if(request()->expectsJson()){
        	return response()->json([
        		'status'=>$status,
        		'province'=>$province,
			]);
        }

        Session::flash('success',$status);

		return redirect()->route('province.edit',$province);
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
    	$province=Province::findOrFail($id);

    	// Check policy
		$this->authorize('delete',$province);

    	$province->delete();

		$status=trans('general.delete_success');

        if(request()->expectsJson()){
        	return response()->json([
        		'status'=>$status,
			]);
        }

        Session::flash('success',$status);

		return redirect()->route('province.index');
    }
}
