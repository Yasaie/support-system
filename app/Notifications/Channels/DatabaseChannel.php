<?php

namespace App\Notifications\Channels;

use Illuminate\Notifications\Notification;
use App\Notification as AppNotification;

class DatabaseChannel
{

	protected $subject;
	protected $message;
	protected $recipient;

	/**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
		$database=$notification->toDatabase($notifiable);

		$this->subject = $database['subject'];
		$this->message  = $database['message'];
		$this->recipient = $database['recipient'];

		$data=[
			'creator_id'	=>null,
			'subject'		=>$this->subject,
			'message'		=>$this->message,
		];

		//create notification
		$appNotification=AppNotification::create($data);

		//add notification's recipient
		$appNotification->recipients()->sync([$this->recipient]);
    }
}