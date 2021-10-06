<?php

namespace App\Http\Controllers\City;

use App\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{

	/**
	 * CityController constructor.
	 */
	public function __construct()
	{
		$this->middleware('auth')->except('getList');
	}

	/**
	 * list of cities
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getList(Request $request){
    	$search=$request->input('search');
    	$province=$request->input('province');

    	$cities=City::where('name','like','%'.$search.'%');

    	if($province){
    		$cities=$cities->where('province_id','=',$province);
    	}

		//return json response:
		return response()->json($cities->paginate(),200);
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
    	// Check policy only for page
		$this->authorize('index',City::class);

    	$search=$request->input('search');
    	$province=$request->input('province');

    	$cities=City::where('name','like','%'.$search.'%');

    	if($province){
    		$cities=$cities->where('province_id','=',$province);
    	}

        if($request->expectsJson()){
        	return response()->json($cities->paginate(),200);
        }

        return view('city.index')->with('cities',$cities->simplePaginate());
    }

	/**
	 * validate request
	 *
	 * @param Request $request
	 * @param null $city_id
	 * @return mixed
	 */
    public function validateCity(Request $request,$city_id=null){
    	return Validator::make($request->all(),[
			'name'=>'required|string|min:3|unique:cities,name'.( empty($city_id)?'':(','.$city_id) ),
			'province'=>'required|exists:provinces,id',
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
		$this->authorize('create',City::class);

        return view('city.create');
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
		$this->authorize('create',City::class);

        $validator=$this->validateCity($request);
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
			'province_id'=>$request->input('province'),
		];

		$city=City::create($data);

		$status=trans('general.store_success');

        if(request()->expectsJson()){
        	return response()->json([
        		'status'=>$status,
        		'city'=>$city,
			]);
        }

        Session::flash('success',$status);

		return redirect()->route('city.index');
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
    	$city=City::findOrFail($id);

    	// Check policy
		$this->authorize('view',$city);

        if(request()->expectsJson()){
        	return response()->json([
        		'city'=>$city,
			]);
        }

        return view('city.show')->with('city',$city);
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
    	$city=City::findOrFail($id);

    	// Check policy
		$this->authorize('update',$city);

        if(request()->expectsJson()){
        	return response()->json([
        		'city'=>$city,
			]);
        }

        return view('city.edit')->with('city',$city);
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
        $validator=$this->validateCity($request,$id);
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
			'province_id'=>$request->input('province'),
		];

    	$city=City::findOrFail($id);

    	// Check policy
		$this->authorize('update',$city);

		$city->update($data);

		$status=trans('general.update_success');

        if(request()->expectsJson()){
        	return response()->json([
        		'status'=>$status,
        		'city'=>$city,
			]);
        }

        Session::flash('success',$status);

		return redirect()->route('city.edit',$city);
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
    	$city=City::findOrFail($id);

    	// Check policy
		$this->authorize('delete',$city);

    	$city->delete();

		$status=trans('general.delete_success');

        if(request()->expectsJson()){
        	return response()->json([
        		'status'=>$status,
			]);
        }

        Session::flash('success',$status);

		return redirect()->route('city.index');
    }
}
