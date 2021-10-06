<?php

namespace App\Notifications\Verify;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Mail\Verify\Token as MailToken;

class Token extends Notification
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
	 * @return $this
	 */
    public function toMail($notifiable)
    {
    	return (new MailToken($notifiable))->to($notifiable->email);
    }
}
