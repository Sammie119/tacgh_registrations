<?php

namespace App\Http\Controllers;

use App\Jobs\SendSMSJob;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    protected function notifySMS($phone_number, $message,$irrelevant="")
    {
        $sms = [
            "phone_number" => $phone_number,
            "message" => $message
        ];

//        dd($sms);
        $this->dispatch(new SendSMSJob($sms));

    }
}
