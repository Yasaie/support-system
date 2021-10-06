<?php

namespace App\Http\Controllers\Notification;

use App\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{

	/**
	 * NotificationController constructor.
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
    	$this->authorize('index',Notification::class);

    	$search=$request->input('search');

    	if(Auth::user()->owner() || Auth::user()->admin()){
    		//owner and admin can see all notifications
	    	$notifications=Notification::where('subject','like','%'.$search.'%');
    	}else{
    		//creator of a notification see it.
	    	$notifications=Auth::user()->sentNotifications()
	    							   ->where('subject','like','%'.$search.'%');
    	}

        if($request->expectsJson()){
        	return response()->json($notifications->paginate(),200);
        }

        return view('notification.index')->with('notifications',$notifications->simplePaginate());
    }

	public function garbage(Request $request){
    	$this->authorize('garbage',Notification::class);
    	$search=$request->input('search');

    	if(Auth::user()->owner() || Auth::user()->admin()){
    		//owner and admin can see all notifications
	    	$notifications=Notification::where('subject','like','%'.$search.'%')
	    								->onlyTrashed();
    	}else{
    		//creator of a notification see it.
	    	$notifications=Auth::user()->sentNotifications()
	    							   ->where('subject','like','%'.$search.'%')
									   ->onlyTrashed();
    	}

        if($request->expectsJson()){
        	return response()->json($notifications->paginate(),200);
        }

		return view('notification.garbage')->with('notifications',$notifications->paginate());
	}

	/**
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
	public function recycle($id){
    	$notification=Notification::onlyTrashed()->findOrFail($id);

    	$this->authorize('recycle',$notification);

    	$notification->restore();

		$status=trans('general.update_success');

        if(request()->expectsJson()){
        	return response()->json([
        		'status'=>$status,
			]);
        }

        Session::flash('success',$status);

		return redirect()->route('notification.garbage');
	}

	/**
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
	public function permanentDestroy($id){
    	$notification=Notification::onlyTrashed()->findOrFail($id);

    	$this->authorize('permanentDelete',$notification);

    	$notification->forceDelete();

		$status=trans('general.delete_success');

        if(request()->expectsJson()){
        	return response()->json([
        		'status'=>$status,
			]);
        }

        Session::flash('success',$status);

		return redirect()->route('notification.garbage');
	}

	/**
	 * validate request
	 *
	 * @param Request $request
	 * @return mixed
	 */
    public function validateNotification(Request $request){
    	return Validator::make($request->all(),[
			'subject'=>'required|string|min:3',
			'message'=>'required|string|min:3',
			'recipients'=>'nullable|exists:users,id',
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
    	$this->authorize('create',Notification::class);

        return view('notification.create');
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
    	$this->authorize('create',Notification::class);

        $validator=$this->validateNotification($request);
		if($validator->fails()){
			if($request->expectsJson()){
				return response()->json($validator->errors(),422);
			}
			return redirect()->back()
				->withInput($request->all())
				->withErrors($validator->errors());
		}

		$data=[
			'subject'=>$request->input('subject'),
			'message'=>$request->input('message'),
			'creator_id'=>$request->user()->id,
		];

		$recipients=$request->input('recipients');

		//create notification
		$notification=Notification::create($data);

		//add notification's recipients
		$notification->recipients()->sync($recipients);

		$status=trans('general.store_success');

        if(request()->expectsJson()){
        	return response()->json([
        		'status'=>$status,
        		'notification'=>$notification,
			]);
        }

        Session::flash('success',$status);

		return redirect()->route('notification.index');
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
    	$notification=Notification::findOrFail($id);

    	$this->authorize('view',$notification);

		$recipient=$notification->recipients()->where('recipient_id','=',Auth::id())->first();
		if($recipient){
			$recipient->pivot->forceFill(['read_at' => $recipient->freshTimestamp()])->save();
		}

        if(request()->expectsJson()){
        	return response()->json([
        		'notification'=>$notification,
			]);
        }

		if(Auth::user()->owner() || Auth::user()->admin() || Auth::user()->leader() || Auth::user()->staff()){
			//admin and owner and department's leader or staff
	        return view('notification.show')->with('notification',$notification);
		}

        return view('notification.userShow')->with('notification',$notification);
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
    	$notification=Notification::findOrFail($id);

    	$this->authorize('update',$notification);

        if(request()->expectsJson()){
        	return response()->json([
        		'notification'=>$notification,
			]);
        }

        return view('notification.edit')->with('notification',$notification);
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
        $validator=$this->validateNotification($request,$id);
		if($validator->fails()){
			if($request->expectsJson()){
				return response()->json($validator->errors(),422);
			}
			return redirect()->back()
				->withInput($request->all())
				->withErrors($validator->errors());
		}

		$data=[
			'subject'=>$request->input('subject'),
			'message'=>$request->input('message'),
		];

		$recipients=$request->input('recipients');

		//find and update notification
    	$notification=Notification::findOrFail($id);

    	$this->authorize('update',$notification);

		$notification->update($data);

		//add notification's recipients
		$notification->recipients()->sync($recipients);

		$status=trans('general.update_success');

        if(request()->expectsJson()){
        	return response()->json([
        		'status'=>$status,
        		'notification'=>$notification,
			]);
        }

        Session::flash('success',$status);

		return redirect()->route('notification.edit',$notification);
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
    	$notification=Notification::findOrFail($id);

    	$this->authorize('delete',$notification);

    	$notification->delete();

		$status=trans('general.delete_success');

        if(request()->expectsJson()){
        	return response()->json([
        		'status'=>$status,
			]);
        }

        Session::flash('success',$status);

		return redirect()->route('notification.index');
    }

	public function inbox(Request $request){

    	$this->authorize('inbox',Notification::class);

    	$search=$request->input('search');
    	$notifications=Auth::user()->receivedNotifications()
								   ->where('subject','like','%'.$search.'%')
								   ->paginate();
        if($request->expectsJson()){
        	return response()->json($notifications,200);
        }

		if(Auth::user()->owner() || Auth::user()->admin() || Auth::user()->leader() || Auth::user()->staff()){
			//admin and owner and department's leader or staff
	        return view('notification.inbox')->with('notifications',$notifications);
		}

        return view('notification.userInbox')->with('notifications',$notifications);

	}
}
