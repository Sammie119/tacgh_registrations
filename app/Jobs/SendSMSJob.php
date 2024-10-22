<?php

namespace App\Jobs;

use App\BL\SmsSender;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendSMSJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $sms;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($sms)
    {
        //
        $this->sms = $sms;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $res = SmsSender::sendSMSNotification($this->sms["phone_number"],$this->sms["message"]);
//        dd($res);
//        Log::info('Inside SendSMSJob: RES:' . $res);
    }
}
