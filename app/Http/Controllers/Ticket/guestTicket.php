<?php

namespace App\Http\Controllers\Ticket;

use App\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

trait guestTicket{

    public function validateGuestTicket($request){
        return Validator::make($request->all(),[
            'subject'		=>'required|min:3',
            'department'	=>'required|exists:departments,id',
            'content'		=>'required|min:10',
            'priority'		=>['required',Rule::in(array_keys(TicketPriority::getList()))],
            'medias'		=>'nullable|array|exists:medias,id',
            'user'			=>'nullable|exists:users,id',
            'captcha' => 'required|captcha',
        ]);
    }

	public function storeGuest(Request $request){

		if(!config('app.guestTicket.status')){
			return abort(403);
		}

        $validator=$this->validateGuestTicket($request);
		if($validator->fails()){
			if($request->expectsJson()){
				return response()->json($validator->errors(),422);
			}
			return redirect()->back()
				->withInput($request->all())
				->withErrors($validator->errors());
		}

		$data=[
			'user_id'=>null,
			'access_key'=>self::accessTokenLength,
			'subject'=>$request->input('subject'),
			'department_id'=>$request->input('department'),
			'status'=>TicketStatus::STATUS_OPENED,
			'priority'=>$request->input('priority'),
			'content'=>$request->input('content'),
		];

		$ticket=Ticket::create($data);

		$status=trans('general.store_success');

        if(request()->expectsJson()){
        	return response()->json([
        		'status'=>$status,
        		'ticket'=>$ticket,
			]);
        }

        Session::flash('success',$status.' کد رهگیری تیکت شما :  '.$ticket->access_key);

		return redirect()->route('ticket.guest.show',$ticket->access_key);

	}

	public function replyGuest(Request $request,$access_key){

		$validator=$this->validateReply($request);

		if($validator->fails()){
			if($request->expectsJson()){
				return response()->json($validator->errors(),422);
			}
			return redirect()->back()
							 ->withInput($request->all())
							 ->withErrors($validator->errors());
		}

        $ticketParent=Ticket::where('access_key','=',$access_key)->get();

		if($ticketParent->isEmpty()){
			return abort(404);
		}

		$ticketParent=$ticketParent->first();

		$data=[
			'user_id'=>null,
			'ticket_id'=>$ticketParent->id, //parent ticket --> we wanna reply it.
			'content'=>$request->input('reply'),
		];

		//create reply:
		$ticketChild=Ticket::create($data);

		$ticketParent->markAsUnreaded()->markAsUnreplied();

		$status=trans('general.store_success');

        if(request()->expectsJson()){
        	return response()->json([
        		'status'=>$status,
        		'ticket'=>$ticketChild,
			]);
        }

        Session::flash('success',$status);

		//get root ticket
		$ticket=$ticketParent->root;

		return redirect()->route('ticket.guest.show',$ticket->access_key);
	}

	public function redirectGuest(Request $request){
		$access_key=$request->input('access_key');

		if(empty($access_key)){
			return $this->guestTicketNotFoundResponse();
		}

		return redirect()->route('ticket.guest.show',$access_key);
	}

	public function showGuest(Request $request,$access_key){
		$ticket=Ticket::where('access_key','=',$access_key)->get();

		if($ticket->isEmpty()){
			return $this->guestTicketNotFoundResponse();
		}

		$ticket=$ticket->first();

		//get root ticket
		$ticket=$ticket->root;

        if(request()->expectsJson()){
        	return response()->json([
        		'ticket'=>$ticket,
			]);
        }
		return view('ticket.guestShow')->with('ticket',$ticket);
	}

	public function guestTicketNotFoundResponse(){
		$errors=['ticket' => trans('general.not_found')];
        if(request()->expectsJson()){
        	return response()->json(['ticket'=>$errors],422);
        }
		return redirect()->back()->withErrors($errors);
	}

	public function closeGuest(Request $request,$access_key){
		$ticket=Ticket::where('access_key','=',$access_key)->get();

		if($ticket->isEmpty()){
			return abort(404);
		}

		$ticket=$ticket->first();

    	$ticket->markAsClosed();

		$status=trans('general.update_success');

        if(request()->expectsJson()){
        	return response()->json([
        		'status'=>$status,
			]);
        }

        Session::flash('success',$status);

		return redirect()->route('ticket.guest.show',$ticket->access_key);
	}
}