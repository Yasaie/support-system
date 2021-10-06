<?php

namespace App\Notifications\Ticket;

use App\Notifications\Channels\SmsChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\View;

class CreateSms extends Notification
{
    use Queueable;

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
		if($notifiable->user && $notifiable->user->mobile && $notifiable->user->mobileVerified()){
			$number=$notifiable->user->mobile;
			$message=View::make('notifications.ticket.createSms', ['url'=>route('ticket.show',$notifiable)])->render();
			return [
				'number'=>$number,
				'message'=>$message,
			];
		}
	}
}
