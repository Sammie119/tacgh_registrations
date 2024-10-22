<?php

namespace App\Http\Controllers;

use App\Models\Batches;
use App\Models\BatchRegistration;
use App\Models\Message;
//use App\SendSMS;
use App\Http\Traits\SMSNotify;
use App\Models\Token;
use App\Models\ViewRecord;
use Illuminate\Http\Request;
use Alert;
use League\Flysystem\Exception;

class MessageController extends Controller
{
    use SMSNotify;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
//        $this->middleware(['auth','isAdmin']);
        $this->middleware(['auth','isAdmin']);
     // $this->middleware(['auth','initPwdChanged']);
    }

    public function index()
    {
 //      dd("Hello there");
        $tokens = Token::whereRaw('length(camper_code)=10')->select('camper_code')->get()->toArray();

       //dd($tokens);
        $batches = Batches::whereNotIn('batch_no',$tokens)->select('chapter','batch_no','ambassadorname','ambassadorphone')->groupBy('batch_no')->get();
      //dd($batches);
//        dd(ViewRecord::whereNotIn('batch_no',$tokens)->select('chapter','batch_no','ambassadorname','ambassadorphone')->groupBy('batch_no')->toSql());

        //dd($tokens);
        return view('admin.layout.backend.message.index',compact('batches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        //
    }

    public function batchtokensend(Request $request){
        try{
        if(!isset($request['batches'])){
            Alert::info('You have to select at least one chapter to generate and send token!', 'Info')->persistent('Close');
            return redirect()->back()->withInput();
        }

//        $records = ViewRecord::whereIn('batch_no', $request['batches'])->select('chapter','batch_no','ambassadorname','ambassadorphone')->groupBy('batch_no')->get();
        $records = Batches::whereIn('batch_no', $request['batches'])->select('chapter','batch_no','ambassadorname','ambassadorphone')->get();
//        dd($records);
        foreach ($records as $key => $value){
            $token =  BatchRegistration::token(6);
            $chapter = isset($value->chapter)?" from ".$value->chapter." chapter,":" chapter leader,";
            if(strlen($value->ambassadorphone) == 10){

                   Token::firstOrCreate([
                       'camper_code' => $value->batch_no,
                       'telephone' => $value->ambassadorphone,
                       'token' => $token
                   ]);

                   $this->sendMessage($value->ambassadorphone,
                       "Hi " . $value->ambassadorname. " ".$chapter. " Use Batch No: ".$value->batch_no ." and token ".$token." for APOSA Camp ".date('Y')." registration. Visit aposaghana.com", "1234");
            }
        }
            Alert::success('Tokens generated and sent succesfully!', 'Success')->persistent('Close');
            return redirect()->back();

    }
catch (Exception $ex){
    Alert::error('Sorry some error occured!', 'Error')->persistent('Close');
    return redirect()->back();
}
    }

    public function tokens(){
     // dd("we here");
        $tokens = Token::all();
      //dd($tokens);
        return view('admin.layout.backend.message.tokens',compact('tokens'));
    }

    public function testMessage(){
     // dd("we here");
        $this->sendMessage("233245170772","testing sms platform");
    }
}
