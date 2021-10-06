<?php

namespace App\Http\Controllers\Ticket;

use App\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public static function countAll(){
		if(Auth::user()->owner() || Auth::user()->admin()){
			$count=Ticket::whereNull('ticket_id')
						 ->count();
		}elseif(Auth::user()->leader() || Auth::user()->staff()){
			//leader can see the staff's of his departments that is leader of them.
			$count=Ticket::whereNull('ticket_id')
						  ->whereHas('department',function($query){
								$departments=Auth::user()->departments()->pluck('department_id')->toArray();
								$query->whereIn('department_id',$departments);
						  })
						  ->count();
		}else{
			//simple user
			$count=Auth::user()->rootTickets()
							   ->count();
		}

    	return $count;
    }

    public static function countReaded(){
		if(Auth::user()->owner() || Auth::user()->admin()){
			$count=Ticket::whereNotNull('read_at')
						 ->whereNull('ticket_id')
						 ->where('status','=',TicketStatus::STATUS_OPENED)
						 ->count();
		}elseif(Auth::user()->leader() || Auth::user()->staff()){
			//leader can see the staff's of his departments that is leader of them.
			$count=Ticket::whereNotNull('read_at')
						 ->whereNull('ticket_id')
						 ->where('status','=',TicketStatus::STATUS_OPENED)
						 ->whereHas('department',function($query){
								$departments=Auth::user()->departments()->pluck('department_id')->toArray();
								$query->whereIn('department_id',$departments);
						 })
						 ->count();
		}else{
			//simple user
			$count=Auth::user()->rootTickets()
							   ->whereNotNull('read_at')
							   ->where('status','=',TicketStatus::STATUS_OPENED)
							   ->count();
		}

    	return $count;
    }

    public static function countNotReaded(){
		if(Auth::user()->owner() || Auth::user()->admin()){
			$count=Ticket::whereNull('read_at')
						 ->whereNull('ticket_id')
						 ->where('status','=',TicketStatus::STATUS_OPENED)
						 ->count();
		}elseif(Auth::user()->leader() || Auth::user()->staff()){
			//leader can see the staff's of his departments that is leader of them.
			$count=Ticket::whereNull('read_at')
						 ->whereNull('ticket_id')
						 ->where('status','=',TicketStatus::STATUS_OPENED)
						 ->whereHas('department',function($query){
								$departments=Auth::user()->departments()->pluck('department_id')->toArray();
								$query->whereIn('department_id',$departments);
						 })
						 ->count();
		}else{
			//simple user
			$count=Auth::user()->rootTickets()
							   ->whereNull('read_at')
							   ->where('status','=',TicketStatus::STATUS_OPENED)
							   ->count();
		}

    	return $count;
    }

    public static function countReplied(){
		if(Auth::user()->owner() || Auth::user()->admin()){
			$count=Ticket::whereNotNull('replied_at')
						 ->whereNull('ticket_id')
						 ->where('status','=',TicketStatus::STATUS_OPENED)
						 ->count();
		}elseif(Auth::user()->leader() || Auth::user()->staff()){
			//leader can see the staff's of his departments that is leader of them.
			$count=Ticket::whereNotNull('replied_at')
						 ->whereNull('ticket_id')
						 ->where('status','=',TicketStatus::STATUS_OPENED)
						 ->whereHas('department',function($query){
								$departments=Auth::user()->departments()->pluck('department_id')->toArray();
								$query->whereIn('department_id',$departments);
						 })
						 ->count();
		}else{
			//simple user
			$count=Auth::user()->rootTickets()
							   ->whereNotNull('replied_at')
						       ->where('status','=',TicketStatus::STATUS_OPENED)
							   ->count();
		}

    	return $count;
    }

    public static function countNotClosed(){
		if(Auth::user()->owner() || Auth::user()->admin()){
			$count=Ticket::where('status','=',TicketStatus::STATUS_OPENED)
							->whereNull('ticket_id')
							->whereNull('replied_at')
							->count();
		}elseif(Auth::user()->leader() || Auth::user()->staff()){
			//leader can see the staff's of his departments that is leader of them.
			$count=Ticket::where('status','=',TicketStatus::STATUS_OPENED)
							->whereNull('ticket_id')
							->whereNull('replied_at')
							->whereHas('department',function($query){
								$departments=Auth::user()->departments()->pluck('department_id')->toArray();
								$query->whereIn('department_id',$departments);
							})
							->count();
		}else{
			//simple user
			$count=Auth::user()->rootTickets()
							   ->where('status','=',TicketStatus::STATUS_OPENED)
							   ->whereNull('replied_at')
							   ->count();
		}

    	return $count;
    }

    public static function countClosed(){
		if(Auth::user()->owner() || Auth::user()->admin()){
			$count=Ticket::where('status','=',TicketStatus::STATUS_CLOSED)
							->whereNull('ticket_id')
							->count();
		}elseif(Auth::user()->leader() || Auth::user()->staff()){
			//leader can see the staff's of his departments that is leader of them.
			$count=Ticket::where('status','=',TicketStatus::STATUS_CLOSED)
							->whereNull('ticket_id')
							->whereHas('department',function($query){
								$departments=Auth::user()->departments()->pluck('department_id')->toArray();
								$query->whereIn('department_id',$departments);
							})
							->count();
		}else{
			//simple user
			$count=Auth::user()->rootTickets()
							   ->where('status','=',TicketStatus::STATUS_CLOSED)
							   ->count();
		}

    	return $count;
    }

    public static function todayCountNotClosed(){
		if(Auth::user()->owner() || Auth::user()->admin()){
			$count=Ticket::where('status','=',TicketStatus::STATUS_OPENED)
							->whereNull('ticket_id')
							->whereDate('created_at','>=',date('Y-m-d').' 00:00:00')
							->count();
		}elseif(Auth::user()->leader() || Auth::user()->staff()){
			//leader can see the staff's of his departments that is leader of them.
			$count=Ticket::where('status','=',TicketStatus::STATUS_OPENED)
							->whereNull('ticket_id')
							->whereHas('department',function($query){
								$departments=Auth::user()->departments()->pluck('department_id')->toArray();
								$query->whereIn('department_id',$departments);
						})
						->whereDate('created_at','>=',date('Y-m-d').' 00:00:00')
						->count();
		}else{
			//simple user
			$count=Auth::user()->rootTickets()
							   ->where('status','=',TicketStatus::STATUS_OPENED)
		    				   ->whereDate('created_at','>=',date('Y-m-d').' 00:00:00')
							   ->count();
		}

    	return $count;
	}

    public static function todayCountClosed(){
		if(Auth::user()->owner() || Auth::user()->admin()){
			$count=Ticket::where('status','=',TicketStatus::STATUS_CLOSED)
							->whereNull('ticket_id')
						    ->whereDate('created_at','>=',date('Y-m-d').' 00:00:00')
							->count();
		}elseif(Auth::user()->leader() || Auth::user()->staff()){
			//leader can see the staff's of his departments that is leader of them.
			$count=Ticket::where('status','=',TicketStatus::STATUS_CLOSED)
							->whereNull('ticket_id')
							->whereHas('department',function($query){
								$departments=Auth::user()->departments()->pluck('department_id')->toArray();
								$query->whereIn('department_id',$departments);
							})
						    ->whereDate('created_at','>=',date('Y-m-d').' 00:00:00')
							->count();
		}else{
			//simple user
			$count=Auth::user()->rootTickets()
							   ->where('status','=',TicketStatus::STATUS_CLOSED)
		    				   ->whereDate('created_at','>=',date('Y-m-d').' 00:00:00')
							   ->count();
		}

    	return $count;
    }

    public static function todayCountNotReaded(){
		if(Auth::user()->owner() || Auth::user()->admin()){
			$count=Ticket::whereNull('read_at')
						 ->whereNull('ticket_id')
						 ->where('status','=',TicketStatus::STATUS_OPENED)
						 ->whereDate('created_at','>=',date('Y-m-d').' 00:00:00')
						 ->count();
		}elseif(Auth::user()->leader() || Auth::user()->staff()){
			//leader can see the staff's of his departments that is leader of them.
			$count=Ticket::whereNull('read_at')
						 ->whereNull('ticket_id')
						 ->where('status','=',TicketStatus::STATUS_OPENED)
						 ->whereHas('department',function($query){
								$departments=Auth::user()->departments()->pluck('department_id')->toArray();
								$query->whereIn('department_id',$departments);
						 })
  					     ->whereDate('created_at','>=',date('Y-m-d').' 00:00:00')
						 ->count();
		}else{
			//simple user
			$count=Auth::user()->rootTickets()
							   ->whereNull('read_at')
						 	   ->where('status','=',TicketStatus::STATUS_OPENED)
		    				   ->whereDate('created_at','>=',date('Y-m-d').' 00:00:00')
							   ->count();
		}

    	return $count;
    }

    public static function todayCountReplied(){
		if(Auth::user()->owner() || Auth::user()->admin()){
			$count=Ticket::whereNotNull('replied_at')
						 ->whereNull('ticket_id')
						 ->where('status','=',TicketStatus::STATUS_OPENED)
						 ->whereDate('created_at','>=',date('Y-m-d').' 00:00:00')
						 ->count();
		}elseif(Auth::user()->leader() || Auth::user()->staff()){
			//leader can see the staff's of his departments that is leader of them.
			$count=Ticket::whereNotNull('replied_at')
						 ->whereNull('ticket_id')
						 ->where('status','=',TicketStatus::STATUS_OPENED)
						 ->whereHas('department',function($query){
								$departments=Auth::user()->departments()->pluck('department_id')->toArray();
								$query->whereIn('department_id',$departments);
						 })
						 ->whereDate('created_at','>=',date('Y-m-d').' 00:00:00')
						 ->count();
		}else{
			//simple user
			$count=Auth::user()->rootTickets()
							   ->whereNotNull('replied_at')
							   ->where('status','=',TicketStatus::STATUS_OPENED)
		    				   ->whereDate('created_at','>=',date('Y-m-d').' 00:00:00')
							   ->count();
		}

    	return $count;
    }

	public static function weeklyAnalysis(){

		if(Auth::user()->owner() || Auth::user()->admin()){

			$analysis=DB::select('
				SELECT (`day`) AS `dayDate`,
						DAYOFWEEK(`day`) AS `dayOfWeek`,
						DAYNAME(`day`) AS `dayName`,
						count(id) As `countAll`,
						SUM(IF(replied_at IS NOT NULL, 1, 0)) As `countAllReplied`,
						SUM(IF(replied_at IS NULL and status='.TicketStatus::STATUS_OPENED.', 1, 0)) As `countAllNotClosed`
				FROM (
					SELECT DATE(NOW() + INTERVAL ( 0 - DAYOFWEEK(NOW())) DAY) AS `day`
					UNION SELECT DATE(NOW() + INTERVAL ( 1 - DAYOFWEEK(NOW())) DAY)
					UNION SELECT DATE(NOW() + INTERVAL ( 2 - DAYOFWEEK(NOW())) DAY)
					UNION SELECT DATE(NOW() + INTERVAL ( 3 - DAYOFWEEK(NOW())) DAY)
					UNION SELECT DATE(NOW() + INTERVAL ( 4 - DAYOFWEEK(NOW())) DAY)
					UNION SELECT DATE(NOW() + INTERVAL ( 5 - DAYOFWEEK(NOW())) DAY)
					UNION SELECT DATE(NOW() + INTERVAL ( 6 - DAYOFWEEK(NOW())) DAY)
				) AS `week`
				LEFT JOIN `tickets` ON DATE(`created_at`) = (`day`)
				and ticket_id is null
				GROUP BY `dayDate`
				ORDER BY `dayDate` DESC
			');
		}elseif(Auth::user()->leader() || Auth::user()->staff()){
			//leader can see the staff's of his departments that is leader of them.
			$departments=Auth::user()->departments()->pluck('department_id')->toArray();

			$analysis=DB::select('
				SELECT (`day`) AS `dayDate`,
						DAYOFWEEK(`day`) AS `dayOfWeek`,
						DAYNAME(`day`) AS `dayName`,
						count(id) As `countAll`,
						SUM(IF(replied_at IS NOT NULL, 1, 0)) As `countAllReplied`,
						SUM(IF(replied_at IS NULL and status='.TicketStatus::STATUS_OPENED.', 1, 0)) As `countAllNotClosed`
				FROM (
					SELECT DATE(NOW() + INTERVAL ( 0 - DAYOFWEEK(NOW())) DAY) AS `day`
					UNION SELECT DATE(NOW() + INTERVAL ( 1 - DAYOFWEEK(NOW())) DAY)
					UNION SELECT DATE(NOW() + INTERVAL ( 2 - DAYOFWEEK(NOW())) DAY)
					UNION SELECT DATE(NOW() + INTERVAL ( 3 - DAYOFWEEK(NOW())) DAY)
					UNION SELECT DATE(NOW() + INTERVAL ( 4 - DAYOFWEEK(NOW())) DAY)
					UNION SELECT DATE(NOW() + INTERVAL ( 5 - DAYOFWEEK(NOW())) DAY)
					UNION SELECT DATE(NOW() + INTERVAL ( 6 - DAYOFWEEK(NOW())) DAY)
				) AS `week`
				LEFT JOIN `tickets` ON DATE(`created_at`) = (`day`)
				and ticket_id is null
				and department_id in ('.implode(',',$departments).')
				GROUP BY `dayDate`
				ORDER BY `dayDate` DESC
			');
		}else{
			//simple user

			$analysis=DB::select('
				SELECT (`day`) AS `dayDate`,
						DAYOFWEEK(`day`) AS `dayOfWeek`,
						DAYNAME(`day`) AS `dayName`,
						count(id) As `countAll`,
						SUM(IF(replied_at IS NOT NULL, 1, 0)) As `countAllReplied`,
						SUM(IF(replied_at IS NULL and status='.TicketStatus::STATUS_OPENED.', 1, 0)) As `countAllNotClosed`
				FROM (
					SELECT DATE(NOW() + INTERVAL ( 0 - DAYOFWEEK(NOW())) DAY) AS `day`
					UNION SELECT DATE(NOW() + INTERVAL ( 1 - DAYOFWEEK(NOW())) DAY)
					UNION SELECT DATE(NOW() + INTERVAL ( 2 - DAYOFWEEK(NOW())) DAY)
					UNION SELECT DATE(NOW() + INTERVAL ( 3 - DAYOFWEEK(NOW())) DAY)
					UNION SELECT DATE(NOW() + INTERVAL ( 4 - DAYOFWEEK(NOW())) DAY)
					UNION SELECT DATE(NOW() + INTERVAL ( 5 - DAYOFWEEK(NOW())) DAY)
					UNION SELECT DATE(NOW() + INTERVAL ( 6 - DAYOFWEEK(NOW())) DAY)
				) AS `week`
				LEFT JOIN `tickets` ON DATE(`created_at`) = (`day`)
				and ticket_id is null
				and user_id='.Auth::id().'
				GROUP BY `dayDate`
				ORDER BY `dayDate` DESC
			');
		}

		$analysisByWeekDays=[];

		foreach($analysis as $index=>$value){
			$dayName=trans('general.'.strtolower($value->dayName));
			$countAll=(int)$value->countAll;
			$countAllReplied=(int)$value->countAllReplied;
			$countAllNotClosed=(int)$value->countAllNotClosed;
			$analysisByWeekDays[$index]['y']=$dayName;
			//count all
			$analysisByWeekDays[$index]['a']=$countAll;
			//replied
			$analysisByWeekDays[$index]['b']=$countAllReplied;
			//not closed
			$analysisByWeekDays[$index]['c']=$countAllNotClosed;
		}

		return $analysisByWeekDays;
	}
}
