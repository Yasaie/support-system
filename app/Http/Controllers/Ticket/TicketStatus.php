<?php
namespace App\Http\Controllers\Ticket;
class TicketStatus{

	//ticket has been closed
	const STATUS_CLOSED=1;

	//ticket is open yet!
	const STATUS_OPENED=2;

	//ticket has been sent to another department
	const STATUS_DEPARTMENT_CHANGED=3;

	// ticket problem has been resolved
	const STATUS_PROBLEM_RESOLVED=4;

	/**
	 * get status list
	 *
	 * @return array
	 */
	public static function getList(){
		return [
			self::STATUS_OPENED					=>lang('ticket.status_open'),
			self::STATUS_CLOSED					=>lang('ticket.status_closed'),
			self::STATUS_DEPARTMENT_CHANGED		=>lang('ticket.status_department_changed'),
			self::STATUS_PROBLEM_RESOLVED		=>lang('ticket.status_problem_resolved'),
		];
	}

}