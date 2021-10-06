<?php

namespace App\Notifications\Ticket;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Notifications\Channels\SmsChannel;
use Illuminate\Support\Facades\View;
use App\Mail\Ticket\ManagersReply as MailManagersReply;

class ManagersReplyEmail extends Notification
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
	 * @return MailManagersReply|null
	 */
    public function toMail($notifiable)
    {
    	$emails=$notifiable->department
    					   ->users()
    					   ->whereNotNull('email')
    					   ->whereNotNull('email_verified_at')
    					   ->pluck('email')
    					   ->toArray();

	   if(empty($emails)){return;}

		return (new MailManagersReply($notifiable))->to($emails);
    }

}
