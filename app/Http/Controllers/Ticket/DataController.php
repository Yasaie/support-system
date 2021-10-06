<?php
namespace App\Http\Controllers\Ticket;

use App\Ticket;
use Illuminate\Support\Facades\Auth;

class DataController {
	public static function tickets(){
    	$search=request()->input('search');

		if(Auth::user()->owner() || Auth::user()->admin()){
			$tickets=Ticket::where('subject','like','%'.$search.'%')
							->whereNull('ticket_id');
		}elseif(Auth::user()->leader() || Auth::user()->staff()){
			//leader can see the staff's of his departments that is leader of them.
			$tickets=Ticket::where('subject','like','%'.$search.'%')
							->whereNull('ticket_id')
							->whereHas('department',function($query){
								$departments=Auth::user()->departments()->pluck('department_id')->toArray();
								$query->whereIn('department_id',$departments);
							});
		}else{
			//simple user
			$tickets=Auth::user()->rootTickets()
								 ->where('subject','like','%'.$search.'%');
		}

		$tickets->orderByDesc('updated_at');

		return $tickets->paginate();
	}
}