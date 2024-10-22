<?php

namespace App\BL;

class SmsSender
{
    public static function sendSMSNotification($contact,$message)
    {
//      print_r("sendSMsNotification");
        try{
            $key=env('MNOTIFY_API_KEY','APOSA'); //your unique API key;

            $msg=urlencode($message); //encode url;

            $phone= $contact;
            $phone=urlencode($phone);

//          print_r("phone ".$phone);

            $sender_id=env('MNOTIFY_SENDER_ID','APOSA');
            $sender_id=urlencode($sender_id);

            /*******************API URL FOR SENDING MESSAGES********/
            $url="https://apps.mnotify.net/smsapi?key=$key&to=$phone&msg=$msg&sender_id=$sender_id";

            $result=file_get_contents($url); //call url and store result;

            //dd($result);
            $response = "";

            switch($result){
                case "1000":
                    $response = "Message sent";
                    break;
                case "1002":
                    $response = "Message not sent";
                    break;
                case "1003":
                    $response = "You don't have enough balance";
                    break;
                case "1004":
                    $response = "Invalid API Key";
                    break;
                case "1005":
                    $response = "Phone number not valid";
                    break;
                case "1006":
                    $response = "Invalid Sender ID";
                    break;
                case "1008":
                    $response = "Empty message";
                    break;
            }

            return response()->json(['response_code'=>$result,'response_message'=>$response]);
        }
        catch(\Exception $e){
//            dd($e);
        }
    }
}