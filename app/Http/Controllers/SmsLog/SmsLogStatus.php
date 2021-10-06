<?php
namespace App\Http\Controllers\SmsLog
;
class SmsLogStatus{

	//has been sent
	const STATUS_SENT = 1;

	//there is an error (not sent)
	const STATUS_ERROR = 2;

}