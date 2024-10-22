<?php

namespace App\Http\Controllers;

use App\Models\CamperMealEligibleList;
use App\Models\Models\CampersMeal;
use App\Models\Models\CurrentMealDistribution;
use App\Models\Models\MealSchedule;
use App\Models\Qrcode;
use App\Models\Registrant;
use Illuminate\Http\Request;
use League\Flysystem\Exception;

class ApiController extends Controller
{

    public function  __construct()
    {
        $this->middleware('jwt.verify');
    }

    //Meal Serving API
    public function meal_eligible(Request $request)
    {
//        return $request->qr_code;
//        $code = Crypt::decrypt($request->qr_cod);
        $code = $request->qr_code;
        $camper = CurrentMealDistribution::where('qrcode', '=', $code)
            ->where('status', '=', 0)
            ->first();
        if ($camper){
            CampersMeal::where('camper_id', '=', $camper->camper_id)
                ->where('meal_schedule_status', '=', 1)
                ->update([
                    'status' => 1
                ]);
            $message = "Eligible";
            $status = true;
        }else{
            $message = "Not eligible";
            $status = false;
        }
        return response()->json(['message' => $message,'status' => $status]);
    }

    public function mealeligiblelist(){
        try{
//            return "hello";
            $camperlist = CamperMealEligibleList::all();
//            return response()->json([$camperlist->count()]);
            return response()->json(['results'=>['data'=>$camperlist,'status'=>1]]);
        }
        catch(Exception $ex){
            return response()->json(['results'=>['message'=>'Some error occured','status'=>-10]]);
        }
    }

    public function mealschedule(){
        try{
//            return "hello";
            $schedulelist = MealSchedule::all();
//            return response()->json([$camperlist->count()]);
            return response()->json(['results'=>['data'=>$schedulelist,'status'=>1]]);
        }
        catch(Exception $ex){
            return response()->json(['results'=>['message'=>'Some error occured','status'=>-10]]);
        }
    }

    //Meal Serving API
    public function campermeal($qr_code)
    {
    try{

        $checkcode =  Qrcode::where(['qrcode'=>$qr_code])->first();
        if($checkcode != null) {
            switch ($checkcode->active_flag) {
                case 0:
                    return response()->json(['results' => ['message' => 'QR Code must have been stolen', 'status' => -10]]);
                    break;
                case 1:
                    //check eligible list
                    $eligible = CamperMealEligibleList::where(['qrcode'=>$qr_code])->first();
                    //if $eligible
                    if($eligible){
                        $served_meal = CurrentMealDistribution::where(['camper_id'=>$eligible->reg_id])->first();
                        if($served_meal){
                            return response()->json(['results'=>['message' => $eligible->camper_name.' has already taken food!','status' => -9]]);
                        }
                        else{
                            $serve_meal = CampersMeal::create([
                                'camper_id'=>$eligible->reg_id,
                                'status'=>1,
                                'server_id'=>1,//replace with user ID
                            ]);
                            if($serve_meal){
                                return response()->json(['results'=>['message' =>$eligible->camper_name.' can take food!','status' => 1]]);
                            }
                            else{
                                return response()->json(['results'=>['message' =>'Some error occured but '.$eligible->camper_name.' might be eligible','status' => -1]]);
                            }
                        }
                    }
                    else{
                        return response()->json(['results'=>['message' => 'Not eligible!','status' => -8]]);
                    }
                    break;
                case 10:
                    return response()->json(['results' => ['message' => 'QR Code blocked!', 'status' => -10]]);
                    break;
                default:
                    return response()->json(['results' => ['message' => 'Valid tag with no comment!', 'status' => 1]]);
            }
        }
    }
    catch(Exception $ex){
        return response()->json(['results'=>['message' => 'Some error occured. Contact Admin!','status' => -10]]);
    }
    }

    //Activation of Current day next meal time
    public function activeNextMeal()
    {
//        Set the next mail
        $meal = MealSchedule::where('day', '=', date('Y-m-d'))
            ->where('status', '=', 0)
            ->first();

//        Has meal today?
        if ($meal){ // If true

            //Activate the Meal, set status to 1
            $meal->status = 1;
            $meal->save();

            CampersMeal::where('meal_schedule_status', '=', 1)
                ->update(['meal_schedule_status' => 0]);

            CampersMeal::where('meal_schedule_id', '=', $meal->id)
                ->update(['meal_schedule_status' => 1]);
            $message = "Meal Activated";
            $status =  true;
        }else{ //if no meal for the day
            $message =  "No Meal remains for today.";
            $status =  false;
        }
        return response()->json(['message'=> $message,'status'=> $status]);
    }

    public function checkmeal($qr_code){

//        return response()->json(['mealdata'=>['message' => "No record found",'status' => 0]]);

        $eligiblelist = \App\CamperMealEligibleList::where(['code'=>$qr_code])->get();
//        return response()->json($qr_code);

        if($eligiblelist->count()==1){

            $campermeal = $eligiblelist->first();
//        $camper = \App\Models\CurrentMealDistribution::where(['qrcode'=>$campermeal->code,'status'=> 0])->first();
            //Get active meal schedule ID and pass to meal_schedule_id
            //Check if camper has already taken meal
            $camper = \App\Models\CurrentMealDistribution::where(['camper_id'=>$campermeal->reg_id,'qrcode'=>$campermeal->code,'meal_schedule_id'=> 2])->first();

//        return response()->json(['apidata'=>$camper->qrcode]);
            $campermeal = array_except($campermeal, array('code'));
            //if camper exist, then meal has already been taken
            if (isset($camper)){

//        \App\Models\CampersMeal::where(['camper_id'=> $camper->camper_id,'meal_schedule_status'=> 1])->update(['status' => 1]);
                $campermeal['message']= 'Meal already taken';
                $campermeal['status']= 10;
                return response()->json(['mealdata'=>$campermeal]);
            }else{
//        return $campermeal;
                $meal = \App\Models\CampersMeal::firstOrCreate([
                    'camper_id'=>$campermeal->reg_id,
                    'meal_schedule_id'=>2,
                    'status'=>1,
                    'server_id'=>3,
                    'meal_schedule_status'=>1,
                ]);
//        return "Some problem occured";
                if(isset($meal)){
                    $camper['message']= 'Please give food';
                    $camper['status']= 1;
                    return response()->json(['mealdata'=>$camper]);
                }
                else{
                    $camper['message']= 'Error giving food';
                    $camper['status']= 9;
                    return response()->json(['mealdata'=>$camper]);
                }
            }
        }
        elseif($eligiblelist->count()<1){
            return response()->json(['mealdata'=>['message' => "No record found",'status' => 0]]);
        }
        else
        {
            return response()->json(['mealdata'=>['message' => "We got a problem with this code",'status' => 8]]);
        }
    }

    public function savecamperqrcode($qr_code,$camper_code){
        //check if Camper code is set or it's our type of camper ID
        if(!isset($camper_code) || substr($camper_code, 0, 3) != "ACM")
            return response()->json(['results'=>['message'=>'Camper code not set or incorrect!','status' =>-98]]);
        else
        {
            $authorizedcamper = Registrant::where(['reg_id'=>$camper_code,'confirmedpayment'=>1])->first();
            if($authorizedcamper != null){
                $checkcode =  Qrcode::where(['qrcode'=>$qr_code])->orWhere(['camper_id'=>$camper_code])->get();
//                if($checkcode->count()>1){
                    $code_res = $checkcode->filter(function($item){
                        return $item->camper_id !=null;
                    });

                    if($code_res->count()>0){
                       $blocked_codes_res = $code_res->filter(function($item){
                           return $item->active != 1;
                       });
                    }

                    return  response()->json(['results'=>$code_res->all()]);
//                }
//                else{
//                    $checkcode = $checkcode->first();
//                    return  response()->json(['results'=>$checkcode]);
//                }

                if($checkcode != null){
                    switch($checkcode->active_flag){
                        case 0:
                            $checkcode->camper_id = $camper_code;
                            $checkcode->active_flag = 1;
                            $checkcode->save();
                            return response()->json(['results'=>['message'=>$camper_code.' saved succesfully!','status' =>1]]);
                            break;
                        case 1:
                            return response()->json(['results'=>['message'=>'Camper already saved!','status' => 10]]);
                            break;
                        case 10:
                            return response()->json(['results'=>['message'=>'QR Code blocked!','status' => -10]]);
                            break;
                        default:
                            return response()->json(['results'=>['message'=>'Valid tag with no comment!','status' =>1]]);
                    }
                }
                else{
                    return response()->json(['results'=>['message'=>'Invalid Tag. Seize Tag and investigate!','status' => -99]]);
                }
            }
            else{
                return response()->json(['results'=>['message'=>'Camper hasn\'t been authorized yet or not registered at all.','status' => 9]]);
            }
        }
    }
}
