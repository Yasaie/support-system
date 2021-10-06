<?php

namespace App\Listeners\EventListener\Log;

use App\Events\Log\Sms as SmsEvent;
use App\SmsLog;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class Sms
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
	 * @param SmsEvent $event
	 */
    public function handle(SmsEvent $event)
    {
    	$data=[
    		'subject'	=> $event->subject,
    		'content'	=> $event->content,
    		'to'		=> $event->to,
    		'status'	=> $event->status,
		];
        SmsLog::create($data);
    }
}
