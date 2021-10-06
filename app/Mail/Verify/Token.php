<?php

namespace App\Mail\Verify;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Token extends Mailable
{
    use Queueable, SerializesModels;


	public $email_token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
		$this->email_token=$data->email_token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->view('notifications.verify.token')->with('email_token',$this->email_token);
    }
}
