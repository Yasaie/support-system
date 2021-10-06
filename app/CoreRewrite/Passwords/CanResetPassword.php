<?php

namespace App\CoreRewrite\Passwords;

use App\Notifications\PasswordReset\Pin as passwordResetPinNotification;
use App\Notifications\PasswordReset\Token as passwordResetTokenNotification;

trait CanResetPassword
{
    /**
     * Get the e-mail address where password reset links are sent.
     *
     * @return string
     */
    public function getEmailForPasswordReset()
    {
        return $this->email;
    }

	/**
	 * @param $token
	 */
	public function sendPasswordResetNotification($token){
		//nothing goes here
	}

	/**
     * Send the password reset notification.
	 *
	 * @param $data
	 */
	public function sendPasswordResetPinNotification($data){
		$pin=$data['pin'];
		if($this->mobile){
			$this->notify(new passwordResetPinNotification($pin));
		}
	}

    public function sendPasswordResetTokenNotification($data)
    {
    	$token=$data['token'];
    	if($this->email){
	        $this->notify(new passwordResetTokenNotification($token));
    	}
    }
}
