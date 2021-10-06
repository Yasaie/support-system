<?php

namespace App\Http\Controllers\Country;

use App\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CountryController extends Controller
{

	/**
	 * CountryController constructor.
	 */
	public function __construct()
	{
		$this->middleware('auth')->except('getList');
	}

	/**
	 * list of countries
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
    public function getList(Request $request)
    {
    	$search=$request->input('search');
    	$countries=Country::where('name','like','%'.$search.'%')
    						->orWhere('short_name','like','%'.$search.'%');

		return response()->json($countries->paginate(),200);
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
		$this->authorize('index',Country::class);

    	$search=$request->input('search');
    	$countries=Country::where('name','like','%'.$search.'%')
    						->orWhere('short_name','like','%'.$search.'%');
        if($request->expectsJson()){
        	return response()->json($countries->paginate(),200);
        }

        return view('country.index')->with('countries',$countries->simplePaginate());
    }
	/**
	 * validate request
	 *
	 * @param Request $request
	 * @param null $country_id
	 * @return mixed
	 */
    public function validateProvince(Request $request,$country_id=null){
    	return Validator::make($request->all(),[
			'name'=>'required|string|min:3|unique:countries,name'.( empty($country_id)?'':(','.$country_id) ),
			'short_name'=>'required|string|min:2|unique:countries,short_name'.( empty($country_id)?'':(','.$country_id) ),
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
		$this->authorize('create',Country::class);

        return view('country.create');
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
		$this->authorize('create',Country::class);

        $validator=$this->validateProvince($request);
		if($validator->fails()){
			if($request->expectsJson()){
				return response()->json($validator->errors(),422);
			}
			return redirect()->back()
				->withInput($request->all())
				->withErrors($validator->errors());
		}

		$data=$request->only(['name','short_name']);
		$country=Country::create($data);

		$status=trans('general.store_success');

        if(request()->expectsJson()){
        	return response()->json([
        		'status'=>$status,
        		'country'=>$country,
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
    	$country=Country::findOrFail($id);

    	// Check policy
		$this->authorize('view',$country);

        if(request()->expectsJson()){
        	return response()->json([
        		'country'=>$country,
			]);
        }

        return view('country.show')->with('country',$country);
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
    	$country=Country::findOrFail($id);

    	// Check policy
		$this->authorize('update',$country);

        if(request()->expectsJson()){
        	return response()->json([
        		'country'=>$country,
			]);
        }

        return view('country.edit')->with('country',$country);
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

		$data=$request->only(['name','short_name']);

    	$country=Country::findOrFail($id);

    	// Check policy
		$this->authorize('update',$country);

		$country->update($data);

		$status=trans('general.update_success');

        if(request()->expectsJson()){
        	return response()->json([
        		'status'=>$status,
        		'country'=>$country,
			]);
        }

        Session::flash('success',$status);

		return redirect()->route('country.edit',$country);
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
    	$country=Country::findOrFail($id);

    	// Check policy
		$this->authorize('delete',$country);

    	$country->delete();

		$status=trans('general.delete_success');

        if(request()->expectsJson()){
        	return response()->json([
        		'status'=>$status,
			]);
        }

        Session::flash('success',$status);

		return redirect()->route('country.index');
    }
}
