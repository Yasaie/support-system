<?php

namespace App\Notifications\Channels;

use App\Events\Log\Sms;
use App\Http\Controllers\SmsLog\SmsLogStatus;
use App\Notifications\Channels\Melipayamak\MelipayamakApi;
use Illuminate\Notifications\Notification;

class SmsChannel
{

	protected $message;
	protected $number;

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
		$sms=$notification->toSms($notifiable);

		if(empty($sms) || empty($sms['message']) || empty($sms['number'])){
			return;
		}

		$this->message=$sms['message'];
		$this->number=$sms['number'];

		//pre-set status
		$status=null;

		//send sms message using melliPayamak API
		try{
			$username = config('sms.username');
			$password = config('sms.password');
			$api = new MelipayamakApi($username,$password);
			$sms = $api->sms();
			$to = $this->number;
			$from = config('sms.number');
			$text = $this->message;
			$response = $sms->send($to,$from,$text);
			$json = json_decode($response);

			//successfully has been sent
			$status=SmsLogStatus::STATUS_SENT;

			//echo $json->Value; //RecId or Error Number
		}catch(Exception $e){
			//cant send sms
			$status=SmsLogStatus::STATUS_ERROR;

			//echo $e->getMessage();
		}finally{
			$subject=null;
			event(new Sms($subject,$text,$to,$status));
		}
    }
}