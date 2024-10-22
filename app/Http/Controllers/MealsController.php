<?php

namespace App\Http\Controllers;

use App\Models\CamperMealEligibleList;
use App\Models\Centre;
use App\Models\Food;
use App\Models\WebAppUser;
use App\Models\WebMealsServer;
use App\Models\MealsServer;
use App\Models\MobAppUsers;
use App\Models\CampersMeal;
use App\Models\CurrentMealDistribution;
use App\Models\MealSchedule;
use Alert;
use App\Models\Qrcode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class MealsController extends Controller
{
    function __construct()
    {
        $this->middleware('auth')->except('serve_meals','check_serve_meals','server_login','server','server_logout');
    }

    public function settings()
    {
        $meal_schedules = MealSchedule::orderBy('day','asc')->get();
        $meal_officials = WebMealsServer::orderBy('name','asc')->get();
//        dd($meal_officials);
        $centres = Centre::orderBy('name','asc')->get();
        $foods = Food::orderBy('name','asc')->get();
//        dd($meal_schedules);
//        return $centres;
        return view('admin.layout.backend.meal.settings',compact('meal_schedules','foods','meal_officials','centres'));
    }

    //Delete Meal Official
    public function remove_official(Request $request)
    {
        $this->validate($request,[
            'id' => 'required|numeric|min:1'
        ]);
        \DB::table('meals_servers')->where('id', '=', $request->id)->delete();
        $meal_officials = WebMealsServer::orderBy('name','asc')->get();
        $theView = view('admin.layout.backend.meal.meal-official-lists', compact('meal_officials'))->render();
        return response()->json(['theList'=>$theView]);
    }

    //Delete Meal Official
    public function remove_meal(Request $request)
    {
        $this->validate($request,[
            'id' => 'required|numeric|min:1'
        ]);
        MealSchedule::destroy($request->id);
        $meal_schedules = MealSchedule::orderBy('day','asc')->get();
        $theView = view('admin.layout.backend.meal.meal-schedule-table', compact('meal_schedules'))->render();
        return response()->json(['theList'=>$theView]);
    }

    //Delete Meal Centre
    public function remove_centre(Request $request)
    {
        $this->validate($request,[
            'id' => 'required|numeric|min:1'
        ]);
        Centre::destroy($request->id);
        $centres = Centre::orderBy('name','asc')->get();
        $theView = view('admin.layout.backend.meal.meal-centres-list', compact('centres'))->render();
        return response()->json(['theList'=>$theView]);
    }

    //Delete Meal Food
    public function remove_food(Request $request)
    {
        $this->validate($request,[
            'id' => 'required|numeric|min:1'
        ]);
        Food::destroy($request->id);
        $foods = Food::orderBy('name','asc')->get();
        $theView = view('admin.layout.backend.meal.meal-foods-list', compact('foods'))->render();
        return response()->json(['theList'=>$theView]);
    }
    //Save Meal Official
    public function save_official(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|string|min:3',
            'centre' => 'required|numeric|min:1'
        ]);
        WebMealsServer::updateOrCreate(['name' => $request->name],
            ['name' => ucwords($request->name),'centre_id'=> $request->centre]
        );
//        \DB::table('meals_servers')->insert(['name' => $request->name,'location'=> $request->location]);
        $meal_officials = WebMealsServer::orderBy('name','asc')->get();
        $theView = view('admin.layout.backend.meal.meal-official-lists', compact('meal_officials'))->render();
        return response()->json(['theList'=>$theView]);
    }
    //Save Centre
    public function save_centre(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|string|min:3',
        ]);
        Centre::updateOrCreate(['name'=>$request->name],['name' => ucwords($request->name)]);
        $centres = \DB::table('centres')->orderBy('name','asc')->get();
        $theView = view('admin.layout.backend.meal.meal-centres-list', compact('centres'))->render();
        return response()->json(['theList'=>$theView]);
    }

    //Save Centre
    public function save_food(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|string|min:3',
        ]);
        Food::updateOrCreate(['name'=>$request->name],['name' => ucwords($request->name)]);
        $foods = Food::orderBy('name','asc')->get();
        $theView = view('admin.layout.backend.meal.meal-foods-list', compact('foods'))->render();
        return response()->json(['theList'=>$theView]);
    }

    //Save Meal Schedule
    public function save_mealSchedule(Request $request)
    {
        $this->validate($request,[
            'meal_day' => 'required|date_format:Y-m-d',
            'meals' => 'required|array|min:1|max:4',
            "meals.*"  => "alpha|distinct|min:3"
        ]);

        foreach ($request->meals as $meal){
            MealSchedule::firstOrCreate([
                'day'=>$request->meal_day,
                'meal_type'=>$meal
            ]);
        }
        $meal_schedules = MealSchedule::orderBy('day','asc')->get();
//
        $theView = view('admin.layout.backend.meal.meal-schedule-table', compact('meal_schedules'))->render();
        return response()->json(['theList'=>$theView, 'message'=> "Meal Schedule Added"]);
    }
    //Activation of Current day next meal time
    public function activeNextMeal()
    {
//        Set the next mail
        $prev_meal = MealSchedule::where('status', '=', 1)->first();
        if ($prev_meal){
            $prev_meal->status = 2;
            $prev_meal->save();
        }

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
            $color =  'green';
            $status =  true;
        }else{ //if no meal for the day
            $message =  "No Meal remains for today.";
            $color =  'red';
            $status =  false;
        }
        return response()->json(['message'=> $message,'status'=> $status,'color'=> $color]);
    }

//    Assign Qr-Code to Camper
    public function assign_qrcode(Request $request)
    {
        $qrcode = Crypt::decrypt($request->qr_code);

        return $qrcode;
    }

//    Random Code Generator for Qr-code
    public function codes($size)
    {
        $codes = array();
        for ($count = 1; $count<= $size; $count++){
            $string = str_random(40);
            if (in_array($string,$codes)){
                continue;
            }
            $codes[] = $string;
            \DB::table('qrcodes')->insert([
                'code' => $string,
                'qrcode' => Crypt::encrypt($string)
            ]);
        }

        return $codes;
    }

    public function server_login()
    {
        return view('admin.layout.backend.meal.login');
    }

    public function server(Request $request)
    {
        $this->validate($request,[
            'username' => 'required|string|min:2',
            'password' => 'required|string|min:5',
        ]);

        $check_user = WebAppUser::where('username', '=', $request['username'])
            ->where('password', '=', $request['password'])
            ->first();

        if ($check_user){
            session(['user' => $check_user->id]);
            return redirect()->route('meal.serve');
        }
        else{
            $message = "Invalid username or password.";
            Alert::error($message, 'Error')->persistent('Close');
            return back()->withInput();
        }
    }

    public function serve_meals()
    {
        if (session()->has('user')) {
            return view('admin.layout.backend.meal.serve-food');
        }
        else{
            return redirect()->route('meal.server.login');
        }
    }

    public function check_serve_meals(Request $request)
    {
        if (session()->has('user')) {
            if (isset($request)) {
                $code = $request->code;
                $message = "";
                try {

                    $checkcode = Qrcode::where(['code' => $code])->first();
                    $meal_schedule = MealSchedule::where('status','=', 1)->first();
                    //                dd($checkcode);
                    if ($checkcode != null) {
                        switch ($checkcode->active_flag) {
                            case 0:
                                //                            return response()->json(['results' => ['message' => 'QR Code must have been stolen', 'status' => -10]]);
                                $message = "Code is invalid or blocked!";
                                Alert::error($message, 'Error')->persistent('Close');
                                break;
                            case 1:
                                //check eligible list
                                $eligible = CamperMealEligibleList::where(['code' => $code])->first();
//                                dd($eligible);

                                //if $eligible
                                if ($eligible) {
                                    $served_meal = CurrentMealDistribution::where('camper_id','=', $eligible->reg_id)->first();
//                                    dd($eligible);
                                    if ($served_meal) {
                                        $message = $eligible->camper_name . ' has already taken food!';
                                        Alert::warning($message, 'Notice')->persistent('Close');
                                    }
                                    else {
                                        $serve_meal = CampersMeal::create([
                                            'camper_id' => $eligible->reg_id,
                                            'meal_schedule_id' => $meal_schedule->id,
                                            'meal_schedule_status' => $meal_schedule->status,
                                            'status' => 1,
                                            'server_id' => session()->get('user'),
                                        ]);
                                        if ($serve_meal) {
                                            $message = $eligible->camper_name . ' can take food!';
                                            Alert::success($message, 'Successful')->persistent('Close');
                                        } else {
                                            $message = 'Something occured but ' . $eligible->camper_name . ' might be eligible';
                                            Alert::info($message, 'Notice')->persistent('Close');
                                            //                                        return response()->json(['results'=>['message' =>'Some error occured but '.$eligible->camper_name.' might be eligible','status' => -1]]);
                                        }
                                    }
                                } else {
                                    $message = 'Not eligible!';
                                    Alert::error($message, 'Notice')->persistent('Close');
                                }
                                break;
                            case 10:
                                $message = 'Code has been blocked!';
                                Alert::error($message, 'Notice')->persistent('Close');
                                break;
                            default:
                                $message = 'Valid tag with no comment!';
                                Alert::error($message, 'Notice')->persistent('Close');
                        }
                    } else {
                        $message = "Code is invalid!";
                        Alert::error($message, 'Error')->persistent('Close');
                    }
                } catch (Exception $ex) {
                    $message = 'Sorry, please try again. If issue persist, contact supervisor or record Code and serve!';
                    Alert::error($message, 'Error')->persistent('Close');
                }

            }
            return back();
        }
        else {
            redirect()->route('meal.server.login');
        }
    }

    public function server_logout()
    {
        session()->flush();
        return redirect()->route('meal.server.login');
    }
}
