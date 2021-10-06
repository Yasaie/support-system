<?php

namespace App\Http\Controllers\Faq;

use App\Faq;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class FaqController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth')->except('show','landing');
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
		$this->authorize('index',Faq::class);

    	$search=$request->input('search');
    	$faqs=Faq::where('question','like','%'.$search.'%');
        if($request->expectsJson()){
        	return response()->json($faqs->paginate(),200);
        }

        return view('faq.index')->with('faqs',$faqs->paginate());
    }

	/**
	 * validate request
	 *
	 * @param Request $request
	 * @return mixed
	 */
    public function validateFaq(Request $request){
    	return Validator::make($request->all(),[
			'question'=>'required|string|min:3',
			'answer'=>'required|string|min:3',
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
    	// Check policy only for page
		$this->authorize('create',Faq::class);

        return view('faq.create');
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
    	// Check policy only for page
		$this->authorize('create',Faq::class);

        $validator=$this->validateFaq($request);
		if($validator->fails()){
			if($request->expectsJson()){
				return response()->json($validator->errors(),422);
			}
			return redirect()->back()
				->withInput($request->all())
				->withErrors($validator->errors());
		}

		$data=$request->only(['question','answer']);
		$faq=Faq::create($data);

		$status=trans('general.store_success');

        if(request()->expectsJson()){
        	return response()->json([
        		'status'=>$status,
        		'faq'=>$faq,
			]);
        }

        Session::flash('success',$status);

		return redirect()->route('faq.index');
    }

	/**
     * Display the specified resource.
	 *
	 * @param $id
	 * @return $this|\Illuminate\Http\JsonResponse
	 */
    public function show($id)
    {
    	$faq=Faq::findOrFail($id);

        if(request()->expectsJson()){
        	return response()->json([
        		'faq'=>$faq,
			]);
        }

        return view('faq.show')->with('faq',$faq);
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
    	$faq=Faq::findOrFail($id);

    	// Check policy
		$this->authorize('update',$faq);

        if(request()->expectsJson()){
        	return response()->json([
        		'faq'=>$faq,
			]);
        }

        return view('faq.edit')->with('faq',$faq);
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
        $validator=$this->validateFaq($request);
		if($validator->fails()){
			if($request->expectsJson()){
				return response()->json($validator->errors(),422);
			}
			return redirect()->back()
				->withInput($request->all())
				->withErrors($validator->errors());
		}

		$data=$request->only(['question','answer']);

    	$faq=Faq::findOrFail($id);

    	// Check policy
		$this->authorize('update',$faq);

		$faq->update($data);

		$status=trans('general.update_success');

        if(request()->expectsJson()){
        	return response()->json([
        		'status'=>$status,
        		'faq'=>$faq,
			]);
        }

        Session::flash('success',$status);

		return redirect()->route('faq.edit',$faq);
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
    	$faq=Faq::findOrFail($id);

    	// Check policy
		$this->authorize('delete',$faq);

    	$faq->delete();

		$status=trans('general.delete_success');

        if(request()->expectsJson()){
        	return response()->json([
        		'status'=>$status,
			]);
        }

        Session::flash('success',$status);

		return redirect()->route('faq.index');
    }

	/**
	 * Faq landing page
	 *
	 * @param Request $request
	 * @return $this|\Illuminate\Http\JsonResponse
	 */
    public function landing(Request $request){

    	$search=$request->input('search');
    	$faqs=Faq::where('question','like','%'.$search.'%');
        if($request->expectsJson()){
        	return response()->json($faqs->paginate(),200);
        }

        return view('faq.landing')->with('faqs',$faqs->simplePaginate());
    }
}
