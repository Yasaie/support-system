<?php

namespace App\Notifications\PasswordReset;

use App\Notifications\Channels\SmsChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\View;

class Pin extends Notification
{
    use Queueable;


	public $pin;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($pin)
    {
    	$this->pin=$pin;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
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
		$message=View::make('notifications.password_reset.pin', ['pin'=>$this->pin])->render();
		$number=$notifiable->mobile;
		return [
			'message'=>$message,
			'number'=>$number,
		];
    }
}
