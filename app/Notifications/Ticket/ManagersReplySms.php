<?php

namespace App\Notifications\Ticket;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Notifications\Channels\SmsChannel;
use Illuminate\Support\Facades\View;
use App\Mail\Ticket\Reply as MailReply;

class ManagersReplySms extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
	 * @param $notifiable
	 * @return string
	 */
    public function via($notifiable)
    {
        return SmsChannel::class;
    }

	/**
	 * Get the SMS representation of the notification.
	 *
	 * @param $notifiable
	 * @return array
	 */
    public function toSms($notifiable){
    	$mobiles=$notifiable->department
    					   ->users()
    					   ->whereNotNull('mobile')
    					   ->whereNotNull('mobile_verified_at')
    					   ->pluck('mobile')
    					   ->toArray();

		if(empty($mobiles)){return;}
		$number=implode(',',$mobiles);

		$message=View::make('notifications.ticket.managersReplySms', ['url'=>route('ticket.show',$notifiable)])->render();
		return [
			'number'=>$number,
			'message'=>$message,
		];
    }
}
