<?php

namespace App\Http\Controllers\Ticket;

use App\Events\Ticket\Created;
use App\Events\Ticket\Replied;
use App\Ticket;
use Date\Jalali;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TicketController extends Controller
{

	const accessTokenLength=8;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('storeGuest','replyGuest','redirectGuest','showGuest','closeGuest');
    }

	//add some methods to handle guest's tickets
	use guestTicket;

	public function search(Request $request){
    	$search=$request->input('search');
    	$priority=$request->input('priority');
    	$users=$request->input('users');
    	$fromDate=$request->input('fromDate');
    	$toDate=$request->input('toDate');
    	$departments=$request->input('departments');
    	$subject=$request->input('subject');
    	$content=$request->input('content');

		if(Auth::user()->owner() || Auth::user()->admin()){
			if($search){
				$tickets=Ticket::where('subject','like','%'.$search.'%');
			}else{
				$tickets=new Ticket;
			}
		}elseif(Auth::user()->leader() || Auth::user()->staff()){
			//leader can see the staff's of his departments that is leader of them.
			if($search){
				$tickets=Ticket::where('subject','like','%'.$search.'%')
								->whereHas('department',function($query){
									$departments=Auth::user()->departments()->pluck('department_id')->toArray();
									$query->whereIn('department_id',$departments);
								});
			}else{
				$tickets=Ticket::whereHas('department',function($query){
									$departments=Auth::user()->departments()->pluck('department_id')->toArray();
									$query->whereIn('department_id',$departments);
								});
			}
		}else{
			//simple user
			if($search){
				$tickets = Auth::user()->tickets()
					->where('subject', 'like', '%' . $search . '%');
			}else{
				$tickets = Auth::user()->tickets();
			}
		}
		if($priority){
			$tickets=$tickets->where('priority','=',$priority);
		}
		if($users){
			$tickets=$tickets->whereIn('user_id',$users);
		}
		if($fromDate){
			$fromDate=Jalali::make($fromDate)->toGregorian();
			$tickets=$tickets->whereDate('created_at','>=',$fromDate);
		}
		if($toDate){
			$toDate=Jalali::make($toDate)->toGregorian();
			$tickets=$tickets->whereDate('created_at','<=',$toDate);
		}
		if($departments){
			$tickets=$tickets->whereIn('department_id',$departments);
		}
		if($subject){
			$tickets=$tickets->where('subject','like','%'.$subject.'%');
		}
		if($content){
			$tickets=$tickets->where('content','like','%'.$content.'%');
		}

		return $tickets->orderByDesc('updated_at');
	}

	/**
     * Display a listing of the resource.
     *
	 * @param Request $request
	 * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
    public function index(Request $request)
    {
    	$this->authorize('index',Ticket::class);

		$tickets=$this->search($request)->whereNull('ticket_id');

        if($request->expectsJson()){
        	return response()->json($tickets->paginate(),200);
        }

		if(Auth::user()->owner() || Auth::user()->admin() || Auth::user()->leader() || Auth::user()->staff()){
			//admin and owner and department's leader of staff
	        return view('ticket.index')->with('tickets',$tickets->paginate());
		}
		//simple user
		return view('userHome');
	}

	public function garbage(Request $request){
    	$this->authorize('garbage',Ticket::class);

		$tickets=$this->search($request)->onlyTrashed();

        if($request->expectsJson()){
        	return response()->json($tickets->paginate(),200);
        }

		if(Auth::user()->owner() || Auth::user()->admin() || Auth::user()->leader() || Auth::user()->staff()){
			//admin and owner and department's leader of staff
	        return view('ticket.garbage')->with('tickets',$tickets->paginate());
		}
		//simple user
		return view('userHome');
	}

	public function recycle($id){
    	$ticket=Ticket::onlyTrashed()->findOrFail($id);

    	$this->authorize('recycle',$ticket);

    	$ticket->restore();

		$status=trans('general.update_success');

        if(request()->expectsJson()){
        	return response()->json([
        		'status'=>$status,
			]);
        }

        Session::flash('success',$status);

		return redirect()->route('ticket.garbage');
	}

	public function permanentDestroy($id){
    	$ticket=Ticket::onlyTrashed()->findOrFail($id);

    	$this->authorize('permanentDelete',$ticket);

    	$ticket->forceDelete();

		$status=trans('general.delete_success');

        if(request()->expectsJson()){
        	return response()->json([
        		'status'=>$status,
			]);
        }

        Session::flash('success',$status);

		return redirect()->route('ticket.garbage');
	}

    /**
     * Show the form for creating a new resource.
     *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 * @throws \Illuminate\Auth\Access\AuthorizationException
	 */
    public function create()
    {
    	$this->authorize('create',Ticket::class);

		if(Auth::user()->owner() || Auth::user()->admin() || Auth::user()->leader() || Auth::user()->staff()){
			//admin and owner and department's leader of staff
	        return view('ticket.adminCreate');

		}
		return view('ticket.userCreate');
    }

	/**
	 * validate ticket request
	 *
	 * @param $request
	 * @return mixed
	 */
    public function validateTicket($request){
    	return Validator::make($request->all(),[
    		'subject'		=>'required|min:3',
    		'department'	=>'required|exists:departments,id',
			'content'		=>'required|min:10',
			'priority'		=>['required',Rule::in(array_keys(TicketPriority::getList()))],
			'medias'		=>'nullable|array|exists:medias,id',
			'user'			=>'nullable|exists:users,id',
		]);
    }

	/**
	 * validate department
	 *
	 * @param $request
	 * @return mixed
	 */
    public function validateDepartment($request){
    	return Validator::make($request->all(),[
    		'department'	=>'required|exists:departments,id',
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
    	$this->authorize('create',Ticket::class);

        $validator=$this->validateTicket($request);
		if($validator->fails()){
			if($request->expectsJson()){
				return response()->json($validator->errors(),422);
			}
			return redirect()->back()
				->withInput($request->all())
				->withErrors($validator->errors());
		}

		if(Auth::user()->owner() || Auth::user()->admin() || Auth::user()->leader() || Auth::user()->staff()){
			$user_id = (!empty($request->input('user')) ? $request->input('user') : Auth::id());
		}else{
			$user_id = (Auth::id());
		}

		$data=[
			'user_id'=>$user_id,
			'subject'=>$request->input('subject'),
			'department_id'=>$request->input('department'),
			'status'=>TicketStatus::STATUS_OPENED,
			'priority'=>$request->input('priority'),
			'content'=>$request->input('content'),
		];

		$ticket=Ticket::create($data);

		//add attachments
		$attachments=$request->input('medias');
		$ticket->attachments()->sync($attachments);

		event(new Created($ticket));

		$status=trans('general.store_success');

        if(request()->expectsJson()){
        	return response()->json([
        		'status'=>$status,
        		'ticket'=>$ticket,
			]);
        }

        Session::flash('success',$status);

		return redirect()->route('ticket.index');
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
        $ticket=Ticket::findOrFail($id);

    	$this->authorize('view',$ticket);

		//get root ticket
		$ticket=$ticket->root;

		//set ticket as readed
		if(Auth::user()->owner() || Auth::user()->admin() || Auth::user()->leader() || Auth::user()->staff()){
			$ticket->markAsReaded();
		}

        if(request()->expectsJson()){
        	return response()->json([
        		'ticket'=>$ticket,
			]);
        }

		if(Auth::user()->owner() || Auth::user()->admin() || Auth::user()->leader() || Auth::user()->staff()){
			//admin and owner and department's leader or staff
	        return view('ticket.adminShow')->with('ticket',$ticket);
		}
		//simple user
		return view('ticket.userShow')->with('ticket',$ticket);
	}

	public function validateReply(Request $request){
		return Validator::make($request->all(),[
			'reply'=>'required|min:5',
			'medias'=>'nullable|array|exists:medias,id',
		]);
	}

	/**
	 * store a newly reply to a ticket
	 *
	 * @param Request $request
	 * @param $id
	 * @return $this|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
	 */
    public function reply(Request $request, $id){
		$validator=$this->validateReply($request);

		if($validator->fails()){
			if($request->expectsJson()){
				return response()->json($validator->errors(),422);
			}
			return redirect()->back()
				->withInput($request->all())
				->withErrors($validator->errors());
		}

        $ticketParent=Ticket::findOrFail($id);

		$data=[
			'user_id'=>Auth::id(),
			'ticket_id'=>$id, //parent ticket --> we wanna reply it.
			'content'=>$request->input('reply'),
		];

		//create reply:
		$ticketChild=Ticket::create($data);

		//add attachments
		$attachments=$request->input('medias');
		$ticketChild->attachments()->sync($attachments);

		event(new Replied($ticketChild));

		//set ticket as replied
		if(Auth::user()->owner() || Auth::user()->admin() || Auth::user()->leader() || Auth::user()->staff()){
			if($ticketParent->unreplied()){
				//mark ticket is replied
				$ticketParent->markAsReplied();
			}
		}else{
			$ticketParent->markAsUnreaded()->markAsUnreplied();
		}

		$status=trans('general.store_success');

        if(request()->expectsJson()){
        	return response()->json([
        		'status'=>$status,
        		'ticket'=>$ticketChild,
			]);
        }

        Session::flash('success',$status);

        return redirect()->route('ticket.show',$ticketParent);
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
        $ticket=Ticket::findOrFail($id);

    	$this->authorize('update',$ticket);

        if(request()->expectsJson()){
        	return response()->json([
        		'ticket'=>$ticket,
			]);
        }

        return view('ticket.edit')->with('ticket',$ticket);
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
        $ticket=Ticket::findOrFail($id);

    	$this->authorize('update',$ticket);

		if($ticket->isRoot()){
			$validator=$this->validateTicket($request);
		}else{
			$validator=$this->validateReply($request);
		}

		if($validator->fails()){
			if($request->expectsJson()){
				return response()->json($validator->errors(),422);
			}
			return redirect()->back()
				->withInput($request->all())
				->withErrors($validator->errors());
		}


		if($ticket->isRoot()){
			$data=[
				'subject'=>$request->input('subject'),
				'department_id'=>$request->input('department'),
				'status'=>TicketStatus::STATUS_OPENED,
				'priority'=>$request->input('priority'),
				'content'=>$request->input('content'),
			];
		}else{
			$data=[
				'content'=>$request->input('reply'),
			];
		}

		$ticket->update($data);

		$status=trans('general.update_success');

        if(request()->expectsJson()){
        	return response()->json([
        		'status'=>$status,
        		'ticket'=>$ticket,
			]);
        }

        Session::flash('success',$status);

		return redirect()->route('ticket.show',$ticket);
    }

    public function close($id){
    	$ticket=Ticket::findOrFail($id);

    	$this->authorize('close',$ticket);

    	$ticket->markAsClosed();

		$status=trans('general.update_success');

        if(request()->expectsJson()){
        	return response()->json([
        		'status'=>$status,
			]);
        }

        Session::flash('success',$status);

		return redirect()->route('ticket.index');
    }

    public function departmentUpdate(Request $request, $id){
        $ticket=Ticket::findOrFail($id);

		//get root ticket
		$ticket=$ticket->root;

    	$this->authorize('departmentUpdate',$ticket);

		$validator=$this->validateDepartment($request);

		if($validator->fails()){
			if($request->expectsJson()){
				return response()->json($validator->errors(),422);
			}
			return redirect()->back()
				->withInput($request->all())
				->withErrors($validator->errors());
		}

		$department_id=$request->input('department');

		//update ticket if department has changed
		if($ticket->department->id!=$department_id){
			$data=[
				'department_id'=>$department_id,
				'status'	   =>TicketStatus::STATUS_DEPARTMENT_CHANGED,
			];
			$ticket->update($data);
		}

		$status=trans('general.update_success');

        if(request()->expectsJson()){
        	return response()->json([
        		'status'=>$status,
        		'ticket'=>$ticket,
			]);
        }

        Session::flash('success',$status);

		return redirect()->route('ticket.show',$ticket);
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
    	$ticket=Ticket::findOrFail($id);

    	$this->authorize('delete',$ticket);

    	$ticket->delete();

		$status=trans('general.delete_success');

        if(request()->expectsJson()){
        	return response()->json([
        		'status'=>$status,
			]);
        }

        Session::flash('success',$status);

		return redirect()->route('ticket.index');
    }
}
