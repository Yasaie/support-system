<?php

namespace App\Http\Controllers\News;

use App\News;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
{

	/**
	 * NewsController constructor.
	 */
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
		// Add policy
    	$this->authorize('index',News::class);

    	$search=$request->input('search');

    	if(Auth::user()->owner() || Auth::user()->admin()){
    		//owners and admins can see all news
			$news=News::where('title','like','%'.$search.'%');
		}elseif(Auth::user()->leader()){
			//leader can see his/her news
			$news=Auth::user()->news()->where('title','like','%'.$search.'%');
		}

        if($request->expectsJson()){
        	return response()->json($news->paginate(),200);
        }

        return view('news.index')->with('news',$news->simplePaginate());
    }

    /**
     * Show the form for creating a new resource.
     *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
    public function create()
    {
    	$this->authorize('create',News::class);

        return view('news.create');
    }

	/**
	 * validate request
	 *
	 * @param Request $request
	 * @return mixed
	 */
    public function validateNews(Request $request){
    	return Validator::make($request->all(),[
			'title' => 'required|string|min:3',
			'content' => 'required|string|min:3',
			'departments' => 'required|array|exists:departments,id',
			'published' => 'nullable|boolean',
		]);
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
		// Add policy
    	$this->authorize('create',News::class);

        $validator=$this->validateNews($request);
		if($validator->fails()){
			if($request->expectsJson()){
				return response()->json($validator->errors(),422);
			}
			return redirect()->back()
				->withInput($request->all())
				->withErrors($validator->errors());
		}

		$data=[
			'user_id' => Auth::id(),
			'title' => $request->input('title'),
			'content' => $request->input('content'),
			'published_at' => ( !empty($request->input('published')) ? Carbon::now() : null ),
		];
		$news=News::create($data);

		//sync departments

		if(Auth::user()->owner() || Auth::user()->admin()){
			//owners and admins can add news to any department:
			$departments=$request->input('departments');
		}elseif(Auth::user()->leader()){
			//leader can add news, only to his/her departments:
			$departments=$request->input('departments');
			$leaderDepartments=Auth::user()->leaderInDepartments()->pluck('department_id')->toArray();
			//remove the departments that user is not leader in them.
			$departments=array_intersect($departments,$leaderDepartments);
		}

		$news->departments()->sync($departments);

		$status=trans('general.store_success');

        if(request()->expectsJson()){
        	return response()->json([
        		'status'=>$status,
        		'news'=>$news,
			]);
        }

        Session::flash('success',$status);

		return redirect()->route('news.index');
    }

    /**
     * Display the specified resource.
     *
	 * @param $id
	 * @return $this|\Illuminate\Http\JsonResponse
	 */
    public function show($id)
    {
    	$news=News::findOrFail($id);

		//check published
		if($news->unpublished() && !($news->user->id===Auth::id() || Auth::user()->owner() || Auth::user()->admin())){
			//not published yet (owner , admin and news' creator can see it)
			return abort(404);
		}

        if(request()->expectsJson()){
        	return response()->json([
        		'news'=>$news,
			]);
        }

        return view('news.show')->with('news',$news);
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
    	$news=News::findOrFail($id);

		// Add policy
    	$this->authorize('update',$news);

        if(request()->expectsJson()){
        	return response()->json([
        		'news'=>$news,
			]);
        }

        return view('news.edit')->with('news',$news);
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
        $validator=$this->validateNews($request);
		if($validator->fails()){
			if($request->expectsJson()){
				return response()->json($validator->errors(),422);
			}
			return redirect()->back()
				->withInput($request->all())
				->withErrors($validator->errors());
		}

		$data=[
			'title' => $request->input('title'),
			'content' => $request->input('content'),
			'published_at' => ( !empty($request->input('published')) ? Carbon::now() : null ),
		];

    	$news=News::findOrFail($id);

		// Add policy
    	$this->authorize('update',$news);

		//update data
		$news->update($data);

		//sync departments

		if(Auth::user()->owner() || Auth::user()->admin()){
			//owners and admins can add news to any department:
			$departments=$request->input('departments');
		}elseif(Auth::user()->leader()){
			//leader can add news, only to his/her departments:
			$departments=$request->input('departments');
			$leaderDepartments=Auth::user()->leaderInDepartments()->pluck('department_id')->toArray();
			//remove the departments that user is not leader in them.
			$departments=array_intersect($departments,$leaderDepartments);
		}

		$news->departments()->sync($departments);

		$status=trans('general.update_success');

        if(request()->expectsJson()){
        	return response()->json([
        		'status'=>$status,
        		'news'=>$news,
			]);
        }

        Session::flash('success',$status);

		return redirect()->route('news.edit',$news);
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
    	$news=News::findOrFail($id);

		// Add policy
    	$this->authorize('delete',$news);

    	$news->delete();

		$status=trans('general.delete_success');

        if(request()->expectsJson()){
        	return response()->json([
        		'status'=>$status,
			]);
        }

        Session::flash('success',$status);

		return redirect()->route('news.index');
    }

	/**
	 * @param Request $request
	 * @return $this|\Illuminate\Http\JsonResponse
	 */
    public function landing(Request $request){
    	$search=$request->input('search');
    	$news=News::where('title','like','%'.$search.'%')
    			  ->whereNotNull('published_at')
    			  ->orderByDesc('id');
        if($request->expectsJson()){
        	return response()->json($news->paginate(),200);
        }

        return view('news.landing')->with('news',$news->simplePaginate());
    }
}
