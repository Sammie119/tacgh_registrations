<?php
/**
 * Created by PhpStorm.
 * User: mantey
 * Date: 09/11/2021
 * Time: 11:19 PM
 */

namespace App\Http\Traits;
use GuzzleHttp\Client as GuzzleHttpClient;

trait SMSNotify
{
    protected $url = null;
    protected $clientid = null;
    protected $clientsecret = null;
    protected $sendsms = null;

    function __construct() {
        $this->url = env('SMS_API','default');
        $this->clientid = env('SMS_CLIENT','default');
        $this->clientsecret = env('SMS_SECRET','default');
        $this->sendsms = env('SEND_SMS',1);
    }

    public function sendMessage($to,$message,$ref = "1234"){
        try{
//          print_r("we here");
            if(env('SEND_SMS',0) == 1){
              //dd("send sms");
                //if SEND_SMS is set to 0, message won't be sent
              //  $client = new GuzzleHttpClient();
               // $response = $client->get($this->buildURL(env('MNOTIFY_API_KEY','APOSA'),$this->formatPhone($to),$message,$ref));
               $this->sendSMSNotification($to,$message);
            }
            else{
//              dd('message won\'t be delivered sendsms_value'.$this->sendsms);
                return;
            }
        }
        catch(\Exception $e){
            return;
        }
//        dd($response);
        //Will work on the message saving to DB tonight
        //Write text message and sending status to database;
    }
    public function buildURL($from,$to,$message,$ref){
        $to = $this->myUrlEncode($to);
        $data = array('From'=>$from,'To'=>$to,'Content'=>$message,'ClientReference'=>$ref,'ClientId'=>env('SMS_CLIENT','default'),'ClientSecret'=>env('SMS_SECRET','default'),'RegisteredDelivery'=>'true');
        return (env('SMS_API','default').http_build_query($data));
//        return url($this->url, ['From' => $from, 'To' => $to]);
    }

    public function myUrlEncode($string) {
        $entities = array('%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%25', '%23', '%5B', '%5D');
        $replacements = array('!', '*', "'", "(", ")", ";", ":", "@", "&", "=", "+", "$", ",", "/", "?", "%", "#", "[", "]");
        return str_replace($entities, $replacements, urlencode($string));
    }
    public function formatPhone($phone){
        if(strlen($phone) > 10){
            $phone = "0".substr($phone, -9);
        }
        $ptn = "/^0/";  // Regex
        $rpltxt = "+233";  // Replacement string
        return preg_replace($ptn, $rpltxt, $phone);
    }

    public function sendSMSNotification($contact,$message)
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