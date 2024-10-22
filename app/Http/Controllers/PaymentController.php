<?php

namespace App\Http\Controllers;

use App\Models\BatchRegistration;
use App\Models\ErrorLog;
use App\Models\OnlinePayment;
use App\Models\Payment;
use Illuminate\Http\Request;
use Alert;
use Illuminate\Validation\ValidationException;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['auth','isAdmin'])->except('makepayment','onlinepaymentreceipt');
    }

    public function index()
    {
//        $payments = Payment::payments()->get();
//        $payments = Payment::where('registrant_id','93HTC-1514305763')->with('user','batch','individualcamper')->get();
        $payments = OnlinePayment::where('approved','=',1)->where('payment_status','=',1)->get();

        return view('admin.layout.backend.payment.index',compact('payments'));
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
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
//        dd($request);
//        alert()->success('Amount updated successfully!','success');
        //Validate request
        $this->validate($request,[
            'paymentid'=>'required',
            'amountinit'=>'required',
            'amountnew'=>'required|integer',
            'comment'=>'required|min:10'
        ]);
        $payment = Payment::find($request['paymentid']);
        $payment->amount_paid = $request['amountnew'];
        $payment->comment = $request['comment'];
        $payment->update_app_user_id = Auth()->user()->id;
        $payment->save();
//        dd($payment);
//        notify()->flash('Success','success');
////
        alert()->success('Amount updated successfully!','Success')->persistent('Close');
        return redirect('payment');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //
    }

    public function transferFromPayment($reg_id=null){

        if ($reg_id) {
            $payments = Payment::where('registrant_id','=',$reg_id)->get();
        }
        else {
            $payments = Payment::all();
        }

        try {
            foreach ($payments as $payment) {
                $online = OnlinePayment::create([
                    'reg_id'=>$payment->registrant_id,
                    'batch_no'=>$payment->registrant_id,
                    'payment_mode'=>'Manual',
                    'amount_paid'=>$payment->amount_paid,
                    'payment_status'=>1,
                    'transaction_no'=>$payment->payment_details,
                    'comment'=>$payment->comment,
                    'created_at'=>$payment->created_at,
                    'updated_at'=>$payment->updated_at,
                    'approved'=>1,
                ]);
                if ($online) {
                    Payment::destroy($payment->id);
                }
            }
            return true;
        }
        catch(\Exception $exception) {
            echo $exception->getMessage();
        }
    }

    public static function addpayment($registrant_id,$amount,$paymentdetails,$comment){
        if(Payment::firstOrCreate([
        'registrant_id' => $registrant_id,
        'amount_paid' => $amount,
        'payment_details' => $paymentdetails,
        'comment' => $comment,
        'create_app_user_id' => Auth()->user()->id,
        'update_app_user_id' => Auth()->user()->id
        ]))
            return 1;
        else
            return 0;
    }

    public function onlinepaymentrequest(){

        $amount = 0.01;
        $itemname = "APOSACAMP FEE";
        $clientref = "ACM00021-".BatchRegistration::token(4);
        $clientid = env('GTPAY_CLIENTID',0);
        $clientsecret = env('GTPAY_SECRET',0);
        $hashkey = env('GTPAY_HASH',0);

        $raw_string = $amount.'&'.$itemname.'&'.$clientref.'&'.$clientsecret.'&'.$clientid;

        $hash_string = hash_hmac('sha256', $raw_string, $hashkey);

//        dd($hash_string);


        $api_details = [
            'client_id' => $clientid,
            'client_secret' => $clientsecret,
            'client_hash' => $hashkey,
            'base_url' => env('GTPAY_BASEURL',0),
            'return_url' => env('GTPAY_RETURNURL',0),
            'hash_string' => $hash_string,
            'payment_amount' => $amount,
            'client_ref' => $clientref,
            'item_name' => $itemname,
        ];


        return view('admin.layout.backend.payment.paymentsite',compact('api_details'));

    }

    public function onlinepaymentreceipt(Request $request){

      try{
          if (session()->has('user')) {
              $camper_code = session('user');
          }

          if((count($request->all()) > 2) ){
//              dd($request);
              $client_ref = explode("-",$request['clientref'])[1];
              $status = $request['statusCode'];

              $payment = OnlinePayment::firstOrCreate([
                  'reg_id'=>$client_ref,
                  'batch_no'=>$client_ref,
                  'payment_mode'=>$request['paymentMode'],
                  'transaction_no'=>$request['clientref'],
                  'amount_paid'=>$request['amount'],
                  'payment_status'=>$status,
                  'approved'=>$status,
              ]);

              $message_success = (substr($client_ref,0,3) == "ACM")? "Payment of GHS ".$request['amount']." for Camper # ".$client_ref." was succesful!":
                  "Payment of GHS ".$request['amount']." for Batch #".$client_ref." was successful!";

              $message_failure = (substr($client_ref,0,3) == "ACM")? "Payment of GHS ".$request['amount']." for Camper # ".$client_ref." was NOT succesful!":
                  "Payment of GHS ".$request['amount']." for Batch #".$client_ref." was NOT successful!";
              if($status == 1){
//            $message = "Payment of GHS ".$request['amount']." for Batch #".$client_ref." was succesful!";
                  alert()->success('Succesful',$message_success )->persistent('Close');
              }
              elseif($status == 0){
//        $message = "Payment of GHS ".$request['amount']." for Batch #".$client_ref." was not succesful!";
                  alert()->info("Info",$message_failure)->persistent('Close');
              }

              if($this->checkClientType($client_ref) == "ACM"){
                  return redirect('camper-info-update/2');
              }
              elseif($this->checkClientType($client_ref) == "BACM"){

                  return redirect('chapter-info-update/'.$client_ref.'/1');
              }
          }
          else{

              alert()->info("Info","Request failed or was cancelled!")->persistent('Close');
              if(isset($camper_code)){
                  if($this->checkClientType($camper_code) == "ACM"){
                      return redirect('camper-info-update/2');
                  }
                  elseif($this->checkClientType($camper_code) == "BACM")
                  {
                      return redirect('chapter-info-update/'.$camper_code.'/1');
                  }
              }
              else{
                  alert()->info("Session might have timed out!", 'Info')->persistent('Close');
                  return redirect('/');
              }

          }
      }
      catch (\Exception $e){

          $error = ErrorLog::insertError("PaymentController -- onlinepaymentreceipt ",$e->getMessage()." request: ".$request->toArray());

          alert()->error("Sorry some error occured", 'Error')->persistent('Close');

          if(isset($camper_code)){
              if($this->checkClientType($camper_code) == "ACM"){
                  return redirect('camper-info-update/2');
              }
              elseif($this->checkClientType($camper_code) == "BACM"){
                  return redirect('chapter-info-update/'.$camper_code.'/2');
              }
          }
          else{
              return redirect('/');
          }
      }
    }

    public function makepayment(Request $request){
        try{


            $this->validate($request,[
               'amount'=>'required|numeric',
                'transaction_no'=>'required'
            ]);

            if (session()->has('user')) {
//                dd($request->all());
                $camper_code = session('user');

                $min_amount = (substr($camper_code,0,1) == "A")?0.1:0.1;
                $outstanding_fee = $request['amount_left'];

                $min_amount =($outstanding_fee >= $min_amount)? $min_amount:$outstanding_fee;

                if($request['amount'] < $min_amount){
                    alert()->info('Info',"Minimum amount you can pay is GHS ".$min_amount)->persistent('Close');
                    return back();
                }

                $amount = $request['amount'];
                $itemname = "APOSACAMP FEE";
                $clientref = $request['transaction_no'];//$request['batch_no']."-".BatchRegistration::token(12);
                $clientid = env('GTPAY_CLIENTID',0);
                $clientsecret = env('GTPAY_SECRET',0);
                $hashkey = env('GTPAY_HASH',0);

                $raw_string = $amount.'&'.$itemname.'&'.$clientref.'&'.$clientsecret.'&'.$clientid;

                $hash_string = hash_hmac('sha256', $raw_string, $hashkey);
                $baseurl = env('GTPAY_BASEURL',0);

//                $api_details = [
//                    'client_id' => $clientid,
//                    'client_secret' => $clientsecret,
//                    'client_hash' => $hashkey,
//                    'base_url' => env('GTPAY_BASEURL',0),
//                    'return_url' => env('GTPAY_RETURNURL',0),
//                    'hash_string' => $hash_string,
//                    'payment_amount' => $amount,
//                    'client_ref' => $clientref,
//                    'item_name' => $itemname,
//                ];

                $args         = array(
                    'amount' => $amount,
                    'itemname' => $itemname,
                    'clientref' => $clientref,
                    'clientsecret' => $clientsecret,
                    'clientid' => $clientid,
                    'returnurl' => env('GTPAY_RETURNURL',0),
                    'securehash' => $hash_string
                );

                //dd($args);

                $args_array = array();
                foreach ($args as $key => $value) {
                    $args_array[] = "<input type='hidden' name='$key' value='$value'/>";
                }

                return view('camper.onlinepayment',compact('args_array','baseurl'));
            }
            else{
                alert()->warning("Timeout","You mostly like have lost session. Kindly logout and login again");
                return back();
            }
        }
        catch (\Exception $e){
            if($e instanceof ValidationException){
                alert()->info("Sorry some mandatory fields are empty or incorrect. Kindly check red highlighted fields", 'Info')->persistent('Close');
                return back();
            }

            $error = ErrorLog::insertError("PaymentController -- makepayment: ",$e->getMessage());
            alert()->error("Sorry some error occured", 'Error')->persistent('Close');
            return back();
        }
    }

    public function checkClientType($client_code){

//        dd($client_code);
        $str = (substr($client_code,0,1) == "A")?  substr($client_code,0,3): substr($client_code,0,4);
        return $str;
//        if(substr($client_code,0,3) == "ACM"){
//            return substr($client_code,0,3);
//        }
//        elseif(substr($client_code,0,4) == "BACM"){
//            return substr($client_code,0,4);
//        }
    }
}
