<?php

namespace App\Notifications\Ticket;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Notifications\Channels\SmsChannel;
use Illuminate\Support\Facades\View;
use App\Mail\Ticket\Reply as MailReply;

class ReplySms extends Notification
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
		if($notifiable->user && $notifiable->user->mobile && $notifiable->user->mobileVerified()){
			$number = $notifiable->user->mobile;
			$message = View::make('notifications.ticket.replySms', ['url' => route('ticket.show', $notifiable)])->render();

			return [
				'number'  => $number,
				'message' => $message,
			];
		}
    }
}
