<?php

namespace App\CoreRewrite\verify;

use App\Notifications\Verify\Pin;
use App\Notifications\Verify\Token;

trait CanVerify
{
	/**
     * Send the activation PIN notification.
	 *
	 * @param $pin
	 */
    public function sendPinNotification()
    {
        $this->notify(new Pin());
    }

	/**
	 * send the activation Token.
	 *
	 * @param $token
	 */
    public function sendTokenNotification(){
		$this->notify(new Token());
    }
}
