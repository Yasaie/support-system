<?php

namespace App\Notifications\PasswordReset;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Mail\PasswordReset\Token as MailToken;
class Token extends Notification
{
    use Queueable;

	public $token;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token=$token;
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
    	return (new MailToken($this->token))->to($notifiable->email);
    }
}
