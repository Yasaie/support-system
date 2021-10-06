<?php
namespace App\Http\Controllers\Ticket;
class TicketPriority{

	// ticket priority is low , the issue is not very important
	const PRIORITY_LOW=1;

	const PRIORITY_MEDIUM=2;

	const PRIORITY_HIGH=3;

	// ticket is at the blue condition!
	// the issue must be sold as fast as it can
	const PRIORITY_EMERGENCY=4;

	/**
	 * get priorities list
	 *
	 * @return array
	 */
	public static function getList(){
		return [
			self::PRIORITY_LOW			=>trans('ticket.priority_low'),
			self::PRIORITY_MEDIUM		=>trans('ticket.priority_medium'),
			self::PRIORITY_HIGH			=>trans('ticket.priority_high'),
			self::PRIORITY_EMERGENCY	=>trans('ticket.priority_emergency'),
		];
	}

}