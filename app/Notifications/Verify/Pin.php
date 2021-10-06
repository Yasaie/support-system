<?php

namespace App\Notifications\Verify;

use App\Notifications\Channels\SmsChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\View;

class Pin extends Notification
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
    	$number=$notifiable->mobile;
		$message=View::make('notifications.verify.pin', $notifiable)->render();
		return [
			'message'=>$message,
			'number'=>$number,
		];
    }
}
