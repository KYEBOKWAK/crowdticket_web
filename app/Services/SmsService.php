<?php
/**
 * Created by PhpStorm.
 * User: mhd
 * Date: 2016-06-09
 * Time: 오후 8:15
 */

namespace App\Services;

use EmmaSMS;

include "class.EmmaSMS.php";

class SmsService
{
    const SMS_TYPE = 'L';

    public function send(array $recipients = [], $message, $date = 0)
    {
        foreach ($recipients as $recipient) {
            $sms = new EmmaSMS();
            $sms->login(env('SMS_ID'), env('SMS_PASSWORD'));
            $sms->send($recipient, env('SMS_SENDER'), '[크티] ' . $message, $date, self::SMS_TYPE);
        }
    }

}