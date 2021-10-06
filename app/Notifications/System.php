<?php

namespace App\Notifications;

use App\Notifications\Channels\DatabaseChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class System extends Notification
{
    use Queueable;

	public $subject;
	public $message;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($subject,$message)
    {
        $this->subject=$subject;
        $this->message=$message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return mixed
     */
    public function via($notifiable)
    {
        return DatabaseChannel::class;
    }

	/**
	 * Get the Database representation of the notification.
	 *
	 * @param $notifiable
	 * @return array
	 */
    public function toDatabase($notifiable){
		$recipient=$notifiable->id;
		return [
			'subject'	=> $this->subject,
			'message'	=> $this->message,
			'recipient'	=> $recipient,
		];
    }
}
