<?php

namespace App\Http\Controllers;

use App\Http\Traits\SMSNotify;
use App\Models\Centre;
use App\Models\CampersMeal;
use App\Models\CampVenue;
use App\Models\Residence;
use App\Models\OnlinePayment;
use App\Models\Registrant;
use App\Models\User;
use Illuminate\Http\Request;
use DB;
use App\Models\Assignroom;
use App\Models\Payment;
use Alert;


class HomeController extends Controller
{
    use SMSNotify;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware(['auth'])->except(['passwordreset']);
        $this->middleware(['auth']);
//        $this->middleware(['isAdmin'])->except(['passwordreset','changepassword']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     return view('home');
    // }
    // 
    

    public function index()
    {
        $males = 0;
        $females = 0;
        $males_rooms_left = 0;
        $females_rooms_left = 0;
        $beds_left = 0;
        $rooms_left = 0;
        $paid_applicants = 0;
        $total_registrants = 0;
        $male_percentage = 0;
        $female_percentage = 0;
        $non_residencial = 0;
        $special_accm = 0;
        $senior_paid = $regular_paid = $teen_paid = $child_paid = $non_residencial = $payments = $residences = 0;
        $senior = $regular = $teen = $child = $males_paid = $females_paid = $juniorteen = $senior_teen_paid = $junior_teen_paid = $child_paid = 0;
        $students_fee = $regular_fee = $teens_fee = $children_fee = $special_accm = $non_residencial = $non_fee_paying = $seniorteen = 0;

        //Get Residences based on Registrant Gender
        $camp_venue = CampVenue::where('current_camp','=', 1)->pluck('id')->first();

        $residence_ids = Residence::where('camp_venue_id','=', $camp_venue)
            ->where('status', 1)
            ->orderBy('id','asc')
            ->pluck('id')->toArray();

        // $rooms = Assignroom::whereColumn('assigned_to','<','total_occupants')->get();
        $rooms = Assignroom::whereColumn('assigned_to','<','total_occupants')
            ->whereIn('residence_id',$residence_ids)
            ->where('assign', '=', 1)->get();
//         dd($rooms->count());
        $registrants_paid = Registrant::participants(1)->get();
//        dd($registrants_paid);
        $registrants = Registrant::get();

        $residences = DB::table('assignrooms')
                    ->join('residences', 'assignrooms.residence_id', '=', 'residences.id')
                    ->select(DB::raw('residences.name as residence, sum(assignrooms.total_occupants) as total_beds, sum(assignrooms.assigned_to) as assigned_to'))
                    ->where('assign','=', 1)
                    ->where('camp_venue_id','=', $camp_venue)
                    ->groupBy('residences.name')->get();

        // dd($residences);exit();
        // dd($residences->where('id',30)->rooms->count());
//        $payments = Payment::sum('amount_paid');
        $onlinepayments = OnlinePayment::where(['approved'=>1,'payment_status'=>1])->sum('amount_paid');
        if($onlinepayments){
            $onlinepayments =  number_format($onlinepayments, 2, '.', '');
        }
//        dd($onlinepayments);
//        ($payments == null)?$payments = $onlinepayments:$payments = $payments + $onlinepayments;
//        if($payments == null){ $payments = 0;} else{$payments = $payments + $onlinepayments; dd($payments);}

        $beds_left = $rooms->sum('total_occupants');
        // $beds_left = $rooms->sum('total_occupants')->where('');
        $rooms_left = $rooms->count('room_id');
        $females_rooms_left = $rooms->where('gender', '=', 'F')->count('room_id');
        $males_rooms_left = $rooms->where('gender', '=', 'M')->count('room_id');
        // dd($females_rooms_left." ".$males_rooms_left);

        if($registrants->isNotEmpty()){ 
            $males = $registrants->where('gender_id',3)->count('id'); 
            $females = $registrants->where('gender_id',4)->count('id');
            $senior = Registrant::where('campercat_id',25)->count('id');
            $regular = Registrant::where('campercat_id',26)->count('id');
//            $juniorteen = Registrant::where('campercat_id',130)->count('id');
//            $seniorteen = Registrant::where('campercat_id',131)->count('id');
//            $child = Registrant::where('campercat_id',28)->count('id');
            // $special_accm = Registrant::where('campfee_id',43)->count('id');

            $total_registrants = count($registrants);

            $male_percentage = round(100*($males/$total_registrants)); 
            $female_percentage = round(100*($females/$total_registrants));  
        }
        // Paid Registrants
        if($registrants_paid->isNotEmpty()){ 

            // For Gender
            $males_paid = $registrants_paid->where('gender_id',3)->count('id'); 
            $females_paid = $registrants_paid->where('gender_id',4)->count('id');

            // For Camper Types
            $senior_paid = $registrants_paid->where('campercat_id',25)->count('id');
            $regular_paid = $registrants_paid->where('campercat_id',26)->count('id');
//            $junior_teen_paid = $registrants_paid->where('campercat_id',130)->count('id');
//            $senior_teen_paid = $registrants_paid->where('campercat_id',131)->count('id');
//            $child_paid = $registrants_paid->where('campercat_id',28)->count('id');

            // For capmer fee types
            $students_fee = $registrants_paid->where('campfee_id',37)->count('id'); 
            $regular_fee = $registrants_paid->where('campfee_id',38)->count('id');
//            $teens_fee = $registrants_paid->where('campfee_id',39)->count('id');
//            $children_fee = $registrants_paid->where('campfee_id',40)->count('id');
            $non_residencial = $registrants_paid->where('campfee_id',41)->count('id');
            $non_fee_paying = $registrants_paid->where('campfee_id',42)->count('id');
//            $special_accm = $registrants_paid->where('campfee_id',43)->count('id');

//            dd($teens_fee);

            $paid_applicants = count($registrants_paid);

            $male_percentage_paid = round(100*($males_paid/$paid_applicants)); 
            $female_percentage_paid = round(100*($females_paid/$paid_applicants));  
        }

        $centres_infos = DB::table('campers_meals')
            ->select(DB::raw('centres.name as centre, count(campers_meals.server_id) as distributed'))
            ->join('meals_servers','campers_meals.server_id','=','meals_servers.id')
            ->join('centres','meals_servers.centre_id','=','centres.id')
            ->groupBy('centres.name','campers_meals.server_id')
            ->get();

//        dd("we here");

        return view('admin.layout.backend.dashboard',compact('male_percentage','female_percentage','males',
            'females', 'beds_left','rooms_left','paid_applicants','total_registrants','senior', 'regular','juniorteen', 'seniorteen',
            'child', 'males_paid', 'females_paid', 'senior_paid', 'regular_paid', 'junior_teen_paid','senior_teen_paid','child_paid',
            'non_residencial','onlinepayments', 'residences','special_accm','students_fee','regular_fee','teens_fee',
            'children_fee','non_fee_paying', 'males_rooms_left', 'females_rooms_left', 'centres_infos'));
    }

    public function passwordreset(){

//        dd($_SERVER['REQUEST_METHOD']);
//        if ($_SERVER['REQUEST_METHOD']=='POST') {
        if(\Auth::user()->init_pwd_changed == 0)
        alert()->info("You are required to change your initial password","Notice!")->persistent();
        return view ('passwordreset');
//    }
//        else{
//            return view('passwordreset');
//        }
    }
    public function changepassword(Request $request){
//        dd($request);
        $rules=[
            'oldpassword'=>'required',
            'password'=>array('required','confirmed','regex:[^(?=.*[a-zA-Z]).+$]'),
//            'password_confirmation'=>array('required','same:password','regex:/^(?=.*[0-9])(?=.*[a-zA-Z])([a-zA-Z0-9]+)$/'),
        ];
        $messages = [
            'password.confirmed' => 'The :attribute must be confirmed.',
            'password.regex'  => 'The :attribute must contain at least 1 alphabet,number and special character.',
        ];
//        $validator = Validator::make($request, $rules, $messages);
        $this->validate($request,$rules,$messages);


        $user = User::find(Auth()->user()->id);
//        dd($user);
        $hasher = app('hash');
        if ($hasher->check($request['oldpassword'], $user->password)) {

            $user->password = \Hash::make($request['password']);
            $user->init_pwd_changed = 1;
            $user->save();
//            notify()->flash("Password reset successful");
            alert()->success("Password reset successful","Success!")->persistent();
//            return redirect()->back();

            $role = $user->role->name;
            if($role=="SuperAdmin" || $role=="Finance Officer"){
                return redirect()->route('home') ;
            }elseif($user->role->name=='Registration Assistant'){
                return redirect()->route('camper') ;
            }
            elseif($user->role->name=='Allocation Officer'){
                return redirect()->route('assign') ;
            }
//            return redirect()->intended();
        }
    }

//    public function  testSms(Request $request){
////        dd("we here");
//        $this->notifySMS("0245170772",
//            'Hello Bernard for your interest in Camp '.date("y").'. Registration is incomplete until full payment of camp fee is made. Reg. ID:  login token : ',
//            '1234');
//    }
}
