<?php

namespace App\Notifications\Ticket;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Notifications\Channels\SmsChannel;
use Illuminate\Support\Facades\View;
use App\Mail\Ticket\Reply as MailReply;

class ReplyEmail extends Notification
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
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
	 * @param $notifiable
	 * @return MailReply|null
	 */
    public function toMail($notifiable)
    {
		if($notifiable->user && $notifiable->user->email && $notifiable->user->emailVerified()){
			return (new MailReply($notifiable))->to($notifiable->email);
		}
    }

}
