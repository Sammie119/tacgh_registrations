<?php

namespace App\Http\Traits;

use GuzzleHttp\Client as GuzzleHttpClient;
use League\Flysystem\Exception;

trait SendSMS
{
    protected $url = null;
    protected $clientid = null;
    protected $clientsecret = null;

    function __construct() {
        $this->url = env('SMS_API','default');
        $this->clientid = env('SMS_CLIENT','default');
        $this->clientsecret = env('SMS_SECRET','default');
    }

    public function sendMessage($from,$to,$message,$ref){
        try{
            $client = new GuzzleHttpClient();
            $response = $client->get($this->buildURL($from,$this->formatPhone($to),$message,$ref));
        }
        catch(Exception $e){
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
//        if(substr($phone,1) == "0")
        if(strlen($phone) > 10){
            $phone = "0".substr($phone, -9);
        }
        $ptn = "/^0/";  // Regex
//        $phone //Your input, perhaps $_POST['textbox'] or whatever
        $rpltxt = "+233";  // Replacement string
        return preg_replace($ptn, $rpltxt, $phone);
    }
}