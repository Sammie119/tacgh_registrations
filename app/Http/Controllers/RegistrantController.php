<?php

namespace App\Http\Controllers;

use App\Models\Batches;
use App\Models\BatchRegistration;
use App\Models\ErrorLog;
use App\Http\Traits\SMSNotify;
use App\Models\Lookup;
use App\Models\LookupCode;
use App\Models\Block;
use App\Models\CampVenue;
use App\Models\RegistrantStaging;
use App\Models\RegistrationStatus;
use App\Models\Residence;
use App\Models\OnlinePayment;
use App\Models\Payment;
use App\Models\Qrcode;
use App\Models\Record;
use App\Models\Registrant;
use App\Models\Room;
//use App\SendSMS;
use App\Models\ViewRecord;
use App\Models\ViewRegistrant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Token;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use UxWeb\SweetAlert\SweetAlert;


class RegistrantController extends Controller
{
    use SMSNotify;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['auth','isAdmin'])->except('create','camper_update_page','store','registeredcamper',
            'verify_camper','verify_chapter','verify_token','camper_steps_save','camper_logout','viewMyProfile');
    }

    public function index()
    {

        try{
            //returns only individual registrants
            // $registrants = Registrant::participants(0)->whereRaw('LENGTH(batch_no) = 0 or batch_no is null')->get();

//            dd(Registrant::where(['reg_id'=>'ACM0021'])->get());
            $data['registrants'] = Registrant::with('gender','maritalstatus','campercat','campfee',"onlinepayments","onsitepayments")
//                ,"onlinepayments","onsitepayments"
//                ->with(["onlinepayments"])
                ->where(function($query){
                $query->whereRaw('LENGTH(batch_no) = 0 or batch_no is null');
            })->get();

//            dd($registrants->first()->toArray());

//            $registrant = $registrants->first();

//            dd($registrant->toArray());
//            dd($registrant->reg_id);

//            $total_online_payments = OnlinePayment::where(['reg_id'=>$registrant->reg_id,'approved'=>1,'payment_status'=>1])
//                ->sum('amount_paid');
//
//            dd($total_online_payments);

            $data['show_camper_details'] = 0;
            return view('admin.layout.backend.camper.index', $data);
        }
        catch (\Exception $e)
        {
//            dd($e->getMessage());
            $error = ErrorLog::insertError("RegistrantController -- index ",$e->getMessage());
            alert()->error("Sorry some error occured", 'Error')->persistent('Close');
            return back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        alert()->info('Enquiries?', 'Kindly contact 0555907610')->persistent("Okay");

        try {
        //Total Gender Rooms
        $camp_venue = CampVenue::where('current_camp','=', 1)->pluck('id')->first();
        $residence = Residence::where('camp_venue_id','=',$camp_venue)->pluck('id')->toArray();

        $total_male_beds = Room::where('gender','=','M')
            ->where('assign','=',true)
            ->whereIn('residence_id',$residence)
        ->sum('total_occupants');

        $total_female_beds = Room::where('gender','=','F')
            ->where('assign','=',true)
            ->whereIn('residence_id',$residence)
        ->sum('total_occupants');

        //Total Rooms assigned to each Gender
        $total_male_assigned_beds = Registrant::where('gender_id','=',3)
            ->where('room_id','>',0)
            ->count('id');
        $total_female_assigned_beds = Registrant::where('gender_id','=',4)
            ->where('room_id','>',0)
            ->count('id');

        $data['total_male_beds_left'] = $total_male_beds - $total_male_assigned_beds;
        $data['total_female_beds_left'] = $total_female_beds - $total_female_assigned_beds;

//        return $this->closedcamp();
            $data['gender'] = LookupCode::RetrieveLookups(2);
            $data['yesno'] = LookupCode::RetrieveLookups(1);
            $data['maritalstatus'] = LookupCode::RetrieveLookups(3);
            $data['region'] = LookupCode::RetrieveLookups(4);
            $data['OfficeHeldInChurch'] = LookupCode::RetrieveLookups(5);
            $data['Camper'] = LookupCode::RetrieveLookups(6);
            $data['AGDLanguage'] = LookupCode::RetrieveLookups(7);
            $data['CampApplicableFee'] = collect();//LookupCode::RetrieveLookups(8);
            $data['SpecialAccomodation'] = LookupCode::RetrieveLookups(9);
            $data['area'] = LookupCode::RetrieveLookups(11);
            $data['areaOfCounseling'] = LookupCode::RetrieveLookups(17);

            $data['profession'] = array_values(LookupCode::RetrieveLookups(10)->toArray());

            return view('camper.campregister', $data);
        }
        catch (\Exception $e)
        {
//            Log::error($e->getMessage());
//            dd($e->getMessage());
            alert()->info("Error","Sorry some error occured ")->persistent('Close');
//            dd("we here");
            ErrorLog::insertError("RegistrantController -- create ",$e->getMessage());

//            dd($error);
//            alert()->error("Sorry some error occured", 'Error')->persistent('Close');
            return back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws ValidationException
     */
    public function store(Request $request)
    {
            $validatedData = $this->validate($request, [
                'surname' => 'required|min:3',
                'firstname' => 'required|min:3',
                'gender' => 'required',
                'dob' => 'required',
                'nationality' => 'required_without:othernationality',//required if othernationality is not selected
                'othernationality' => 'required_without:nationality',//required if nationality is not selected
                'foreigndel' => 'required',
                'maritalstatus' => 'required',
                'localassembly' => 'required',
                'telephone' => 'required',
               // 'officechurch' => 'required',
                'campercat' => 'required',
                'agdlang' => 'required',
                'campfee' => 'required',
//                'specialaccom' => 'required_if:campfee,43',
                'needCounseling'=>'required',
                'areaOfCounseling'=>'required_if:needCounseling,1',
                'disclaimer' => 'required',
            ]);

//                dd($validatedData);

            try {
            if (Registrant::where(['firstname' => $request['firstname'], 'dob' => $request['dob'], 'telephone' => $request['telephone']])->first()) {
                alert()->info('It looks like you\'re already registered. Please contact the numbers on the registration page!', 'Hello')->persistent('Close');
                return redirect()->back();
            }

            if ($regmember = RegistrantStaging::firstOrCreate([
                'surname' => $request['surname'],
                'firstname' => $request['firstname'],
                'gender_id' => $request['gender'],
                'dob' => $request['dob'],
                'telephone' => str_replace('+233','0',$request['telephone'])
            ],
                [
                'email' => $request['email'],
                'nationality' => (isset($request['nationality']) && !is_numeric($request['nationality'])) ? $request['nationality'] : $request['othernationality'],
                'foreigndel_id' => $request['foreigndel'],
                'maritalstatus_id' => $request['maritalstatus'],
                'chapter' => $request['chapter'],
                'localassembly' => $request['localassembly'],
                'denomination' => (isset($request['denomination']) && !is_numeric($request['denomination'])) ? $request['denomination'] : $request['otherdenomination'],
                'area_id' => $request['area'],
                'region_id' => $request['region'],
                'permaddress' => $request['permaddress'],
                'officeaposa' => $request['officeaposa'],
                  
                'officechurch_id' => $request->has('officechurch')?$request['officechurch']:null,
                'profession' => $request['profession'],
                'businessaddress' => $request['businessaddress'],
                'studentaddress' => $request['studentaddress'],
                'campercat_id' => $request['campercat'],
                'agdlang_id' => $request['agdlang'],
                'need_counseling' => $request['needCounseling'],
                'area_of_counseling' => $request['areaOfCounseling'],
//                'ambassadorphone' => $request['ambassadorphone'],
                'campfee_id' => $request['campfee'],
//                'need_counseling' => $request['specialaccom'],
                'disclaimer_id' => $request['disclaimer'] ? 1 : 0,
            ])
            ) {

                $registrant = RegistrantStaging::find($regmember->id);

                //Save registration status
                $reg_status = new RegistrationStatus();
                $reg_status->camper_code = $registrant->reg_id;
                $reg_status->rmodel = "App\\Models\\Record";
                $reg_status->status = 0;
                $reg_status->save();

                //Generate Token to be able to add payment details
                $token = BatchRegistration::token(6);

                //store token
                Token::firstOrCreate([
                    'camper_code' => $registrant->reg_id,
                    'telephone' => $registrant->telephone,
                    'token' => $token
                ]);


//                $reg = Registrant::create(collect($registrant)->except(['id', 'attending'])->toArray());

                $camper = Record::create(collect($registrant)->except(['id', 'attending'])->toArray());
                //dd($camper);
//            $camper = Record::where('id',$registrant['id'])->first(['reg_id']);
                $this->notifySMS($camper->telephone,
                    'Congrats ' . $request['firstname'] . ' for your interest in Camp '.date("y").'. Registration is incomplete until full payment of camp fee is made. Reg. ID: ' . $camper->reg_id . ' login token : ' . $token,
                    '1234');
                alert()->success('Thank you!. Reg_ID: ' . $camper->reg_id . '. A token will be sent to your phone shortly. Use the token to complete registration and make payment.', 'Success')->persistent('Close');
                if ($request['existing']) {
                    return redirect('registeredcamper');
                }
                return redirect()->route('registrant.registeredcamper');
            } else {
                alert()->error('Sorry we had trouble here!', 'Error')->persistent('Close');
                if ($request['existing']) {
                    return redirect('registeredcamper');
                }
                return redirect()->back();
            }
        }
        catch (\Exception $e)
        {
            if($e instanceof ValidationException){
                alert()->info("Sorry some mandatory fields are empty or incorrect. Kindly check red highlighted fields", 'Info')->persistent('Close');
                return back()->withInput();
            }
            $error = ErrorLog::insertError("RegistrantController -- store ",$e->getMessage());
            alert()->error("Sorry some error occured. ".$e->getMessage(), 'Error')->persistent('Close');
            return back();
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Registrant  $registrant
     * @return \Illuminate\Http\Response
     */
    public function show(Registrant $registrant)
    {
        return view('admin.layout.backend.camper.show',compact('registrant'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Registrant  $registrant
     * @return \Illuminate\Http\Response
     */
    public function edit(Registrant $registrant)
    {
//        dd($registrant);
        try {
            $gender = LookupCode::RetrieveLookups(2);
            $yesno = LookupCode::RetrieveLookups(1);
            $maritalstatus = LookupCode::RetrieveLookups(3);
            $region = LookupCode::RetrieveLookups(4);
            $OfficeHeldInChurch = LookupCode::RetrieveLookups(5);
            $Camper = LookupCode::RetrieveLookups(6);
            $AGDLanguage = LookupCode::RetrieveLookups(7);
            $CampApplicableFee = collect();//LookupCode::RetrieveLookups(8);
            $SpecialAccomodation = LookupCode::RetrieveLookups(9);
            $area = LookupCode::RetrieveLookups(11);

            $areaOfCounseling = LookupCode::RetrieveLookups(17);

            $profession = array_values(LookupCode::RetrieveLookups(10)->toArray());

            return view('admin.layout.backend.camper.edit', compact('registrant', 'gender',
                'yesno', 'maritalstatus', 'region', 'OfficeHeldInChurch', 'Camper', 'AGDLanguage', 'CampApplicableFee',
                'SpecialAccomodation', 'area', 'profession','areaOfCounseling'));
        }
        catch (\Exception $e)
        {
            $error = ErrorLog::insertError("RegistrantController -- edit ",$e->getMessage());
            alert()->error("Sorry some error occured", 'Error')->persistent('Close');
            return back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Registrant|null $registrant
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request,Registrant $registrant = null)
    {
        try {
            if (isset($request) && $registrant != null) {

                $this->validate($request, [
                    'surname' => 'required|min:3',
                    'firstname' => 'required|min:3',
                    'gender_id' => 'required',
                    'dob' => 'required',
                    'nationality' => 'required_without:othernationality',//required if othernationality is not selected
                    'othernationality' => 'required_without:nationality',//required if nationality is not selected
                    'foreigndel_id' => 'required',
                    'maritalstatus_id' => 'required',
                    'localassembly' => 'required',
                    'denomination' => 'required_without:otherdenomination',
                    'otherdenomination' => 'required_without:denomination|required_if:denomination,2',
                    'telephone' => 'required',
                    'officechurch_id' => 'required',
                    'campercat_id' => 'required',
                    'agdlang_id' => 'required',
                    'campfee_id' => 'required',
                    'specialaccom_id' => 'required_if:campfee_id,43',
                ]);

                $registrant->surname = $request['surname'];
                $registrant->firstname = $request['firstname'];
                $registrant->gender_id = $request['gender_id'];
                $registrant->dob = $request['dob'];
                $registrant->nationality = (isset($request['nationality']) && !is_numeric($request['nationality'])) ? $request['nationality'] : $request['othernationality'];
                $registrant->foreigndel_id = $request['foreigndel_id'];
                $registrant->maritalstatus_id = $request['maritalstatus_id'];
                $registrant->chapter = $request['chapter'];
                $registrant->localassembly = $request['localassembly'];
                $registrant->denomination = (isset($request['denomination']) && !is_numeric($request['denomination'])) ? $request['denomination'] : $request['otherdenomination'];
                $registrant->area_id = $request['area_id'];
                $registrant->region_id = $request['region_id'];
                $registrant->permaddress = $request['permaddress'];
                $registrant->telephone = str_replace('+233','0',$request['telephone']);
                $registrant->email = $request['email'];
                $registrant->officeaposa = $request['officeaposa'];
                $registrant->officechurch_id = $request['officechurch_id'];
                $registrant->profession = $request['profession'];
                $registrant->businessaddress = $request['businessaddress'];
                $registrant->studentaddress = $request['studentaddress'];
                $registrant->campercat_id = $request['campercat_id'];
                $registrant->agdlang_id = $request['agdlang_id'];
                $registrant->agdleader_id = $request['agdleader_id'];
                $registrant->ambassadorname = $request['ambassadorname'];
                $registrant->ambassadorphone = $request['ambassadorphone'];
                $registrant->campfee_id = $request['campfee_id'];

                $registrant->need_counseling = $request['needCounseling'];
                $registrant->area_of_counseling = $request['areaOfCounseling'];

                $registrant->specialaccom_id = $request['specialaccom_id'];
                $registrant->update_app_userid = Auth()->user()->id;

                $registrant->save();

//            dd($registrant);
                $rec = Record::where(['reg_id'=>$registrant->reg_id])->first();
                $rec->surname = $request['surname'];
                $rec->firstname = $request['firstname'];
                $rec->gender_id = $request['gender_id'];
                $rec->dob = $request['dob'];
                $rec->nationality = (isset($request['nationality']) && !is_numeric($request['nationality'])) ? $request['nationality'] : $request['othernationality'];
                $rec->foreigndel_id = $request['foreigndel_id'];
                $rec->maritalstatus_id = $request['maritalstatus_id'];
                $rec->chapter = $request['chapter'];
                $rec->localassembly = $request['localassembly'];
                $rec->denomination = (isset($request['denomination']) && !is_numeric($request['denomination'])) ? $request['denomination'] : $request['otherdenomination'];
                $rec->area_id = $request['area_id'];
                $rec->region_id = $request['region_id'];
                $rec->permaddress = $request['permaddress'];
                $rec->telephone = str_replace('+233','0',$request['telephone']);
                $rec->email = $request['email'];
                $rec->officeaposa = $request['officeaposa'];
                $rec->officechurch_id = $request['officechurch_id'];
                $rec->profession = $request['profession'];
                $rec->businessaddress = $request['businessaddress'];
                $rec->studentaddress = $request['studentaddress'];
                $rec->campercat_id = $request['campercat_id'];
                $rec->agdlang_id = $request['agdlang_id'];
                $rec->agdleader_id = $request['agdleader_id'];
                $rec->ambassadorname = $request['ambassadorname'];
                $rec->ambassadorphone = $request['ambassadorphone'];
                $rec->campfee_id = $request['campfee_id'];

                $rec->need_counseling = $request['needCounseling'];
                $rec->area_of_counseling = $request['areaOfCounseling'];

                $rec->specialaccom_id = $request['specialaccom_id'];
                $rec->update_app_userid = Auth()->user()->id;
                $rec->save();

                alert()->success('Camper succesfully updated!', 'Success')->persistent('Close');
                return redirect()->route('registrant.camperdetails');
            }
        }
        catch (\Exception $e)
        {
            $error = ErrorLog::insertError("RegistrantController -- update ",$e->getMessage());
            alert()->error("Sorry some error occured.". $e->getMessage(), 'Error')->persistent('Close');
        }
        return back();
    }

    public function camperauthorize(Request $request){

        try {
            //Validate inputs
            $this->validate($request, [
                'id' => 'required',
                'amount_paid' => 'required',
                'total_payments' => 'required',
                'description' => 'required|min:3',
                'comment' => 'required'
            ]);
            $registrant = Registrant::find($request['id']);

            if($registrant){
//                dd($registrant->specialaccom->FullName);
//                dd($registrant->campfee->FullName);
                $camp_fee = $this->getCamperFee((strtolower($registrant->campfee->FullName) == "special accomodation")?$registrant->specialaccom->FullName:$registrant->campfee->FullName);

                $total_payments = $request['amount_paid'] + $request['total_payments'];
                if($camp_fee > $total_payments){
                    alert()->info("Total payments of GHS $total_payments is less than camp fees GHS $camp_fee","Info")->persistent("Close");
                    return back()->withInput();
                }

                //Set camper confirmed payment to 1
                $registrant->confirmedpayment = 1;

                if (!isset($registrant->payment->registrant_id)) {
                    $payment = Payment::firstOrNew(['registrant_id' => $registrant->reg_id]);
                    $payment->amount_paid = $request['amount_paid'] + $request['total_payments'];
                    $payment->payment_details = $request['description'];
                    $payment->comment = $request['comment'];
                    $payment->create_app_user_id = Auth()->user()->id;
                    $payment->update_app_user_id = Auth()->user()->id;
                    $payment->save();

                    $registrant->save();

                    $fullname = $registrant->firstname . " " . $registrant->surname;
                    $migratePayment = new PaymentController();
                    $migratePayment->transferFromPayment($registrant->reg_id);
                    alert()->success($fullname . ' successfully authorized!', 'Success')->persistent('Close');
                }
                else {
                    alert()->info('Camper already authorized!', 'Info')->persistent('Close');
                }
                return redirect()->route('registrant.index');
            }
            else{
                alert()->info("Sorry we couldn't find camper!", 'Info')->persistent('Close');
                return redirect()->back()->withInput();
            }

        }
        catch (\Exception $e)
        {
            if($e instanceof ValidationException){
                alert()->info("Sorry some mandatory fields are empty or incorrect. Kindly check red highlighted fields", 'Info')->persistent('Close');
                return back()->withInput();
            }

            $error = ErrorLog::insertError("RegistrantController -- camperauthorize ",$e->getMessage());
            alert()->error("Sorry some error occured", 'Error')->persistent('Close');
            return back();
        }
    }

    public function camperonlineauthorize(Request $request){
        try {

            $this->validate($request, [
                'id' => 'required',
                'amountpaid' => 'required',
                'paymentdetails' => 'required|min:5',
                'comment' => 'required',
                'hidTransNo' => 'required'
            ]);

            $online_payment = OnlinePayment::where(['reg_id' => $request['id'], 'camper_type' => 1, 'transaction_no' => $request['hidTransNo']])->first();


            $registrant = Registrant::where(['reg_id' => $request['reg_id']])->first();

            if (!isset($registrant->payment->registrant_id)) {
                $payment = Payment::firstOrNew(['registrant_id' => $registrant->id]);

                $payment->amount_paid = $request['amountpaid'];
//            $payment->payment_details = $online_payment->payment_mode." ".$online_payment->transaction_no;
                $payment->payment_details = $request['paymentdetails'];
                $payment->comment = $request['comment'];
                $registrant->confirmedpayment = 1;
                $payment->create_app_user_id = Auth()->user()->id;
                $payment->update_app_user_id = Auth()->user()->id;
                $payment->save();

                $registrant->save();
                $online_payment->approved = 1;
                $online_payment->save();

                $fullname = $registrant->firstname . " " . $registrant->surname;
                alert()->success($fullname . ' online payment authorized succesfully!', 'Success')->persistent('Close');
            } else {
                $online_payment->approved = 1;
                $online_payment->save();
                alert()->info('Camper already authorized!', 'Info')->persistent('Close');
            }
            return redirect()->back();
        }
        catch (\Exception $e)
        {
            $error = ErrorLog::insertError("RegistrantController -- camperonlineauthorize ",$e->getMessage());
            alert()->error("Sorry some error occured", 'Error')->persistent('Close');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Registrant  $registrant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Registrant $registrant)
    {
        //
    }

    public function camper(){
        try {

            $gender = LookupCode::RetrieveLookups(2);
            $yesno = LookupCode::RetrieveLookups(1);
            $maritalstatus = LookupCode::RetrieveLookups(3);
            $region = LookupCode::RetrieveLookups(4);
            $OfficeHeldInChurch = LookupCode::RetrieveLookups(5);
            $Camper = LookupCode::RetrieveLookups(6);
            $AGDLanguage = LookupCode::RetrieveLookups(7);
            $CampApplicableFee = LookupCode::RetrieveLookups(8);
            $SpecialAccomodation = LookupCode::RetrieveLookups(9);

            //Retrieve professions to use in autocomplete profession field
            $profession = array_values(LookupCode::RetrieveLookups(5)->toArray());

            return view('admin.layout.backend.camper.camper', compact('gender', 'yesno', 'maritalstatus', 'region', 'OfficeHeldInChurch', 'Camper', 'AGDLanguage', 'CampApplicableFee', 'SpecialAccomodation', 'profession'));
        }
        catch (\Exception $e)
        {
            $error = ErrorLog::insertError("RegistrantController -- camper",$e->getMessage());
            alert()->error("Sorry some error occured", 'Error')->persistent('Close');
            return back();
        }
    }

    public function general()
    {

        return 'Upcoming Report';
//        return view('admin.layout.backend.report.search_rawdata',compact('applicants','rooms'));
    }

    public function rawdata(Request $request)
    {
        try{
            $search_val = $request->searchdata;
            if(substr($search_val,0,1) == "B")
                $applicants = Registrant::where(['confirmedpayment'=>1,'batch_no'=>$search_val])->get();
            else
                $applicants = Registrant::where(['confirmedpayment'=>1,'reg_id'=>$search_val])->get();

            $rooms = Room::get();
            return view('admin.layout.backend.report.general_paid',compact('applicants','rooms'));
        }
        catch (\Exception $e)
        {
            $error = ErrorLog::insertError("RegistrantController -- rawdata ",$e->getMessage());
            alert()->error("Sorry some error occured", 'Error')->persistent('Close');
            return back();
        }

    }

    public function camperdetails(){
        try{
            $registrants = Registrant::all();
            return view('admin.layout.backend.camper.reviewcamper',compact('registrants'));
        }
        catch (\Exception $e)
        {
            $error = ErrorLog::insertError("RegistrantController -- camperdetails ",$e->getMessage());
            alert()->error("Sorry some error occured", 'Error')->persistent('Close');
            return back();
        }

    }

    public function profile($encrypt)
    {
        try{
        $decrypted = Crypt::decrypt($encrypt);

        $applicant = Registrant::findOrFail($decrypted);
        // dd($applicant->room->residence->name);
        $rooms = Room::get();
        return view('admin.layout.backend.camper.profile',compact('applicant','rooms'));
        }
        catch (\Exception $e)
        {
            $error = ErrorLog::insertError("RegistrantController -- profile ",$e->getMessage());
            alert()->error("Sorry some error occured", 'Error')->persistent('Close');
            return back();
        }
    }

    public function registeredcamper(){

//        return $this->closedcamp();

        $regions = LookupCode::RetrieveLookups(4);
        $area = LookupCode::RetrieveLookups(11);
//        dd($areas);
//        return $regions;
        return view('camper.camper-login', compact('regions','area'));
//        return view('camper.camperretrieveregistered', compact('regions','area'));
    }

    public function campertag_old(){

        $camper_cats = LookupCode::RetrieveLookups(16);
        return view('admin.layout.backend.camper.campertag',compact('camper_cats'));
    }

    public function campertag(){
//        dd('hello');
        $camper_cats = LookupCode::RetrieveLookups(6);
//        dd($camper_cats);
//        $codes = Qrcode::where(['active_flag'=>0])->get();
        $codes = null;

        return view('admin.layout.backend.camper.registranttag',compact('codes','camper_cats'));
    }

    public function campertaggenerate(Request $request){

        $this->validate($request,[
            'campercat'=>'required'
        ]);

        $camper_cats = LookupCode::RetrieveLookups(6);
        $codes = Qrcode::where(['active_flag'=>0,'camper_cat'=>$request['campercat']])->get();

//        dd($codes);

        if($codes->count()<1){
            alert()->info('There are no QRCodes for the selected category or codes have already been assigned!', 'Info')->persistent('Close');
        }
        if($codes->count()>0){
            $total_codes = $codes->count();
            $no_of_pages = $codes->count()/10;
        }
        else{
            $total_codes =0;
            $no_of_pages =0;
        }

        return view('admin.layout.backend.camper.registranttag',compact('codes','camper_cats','total_codes','no_of_pages'));
    }

    /**
     * Requesting for token
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verify_camper(Request $request){
        try {
            $this->validate($request, [
                'gender' => 'required|numeric|digits:1',
                'surname' => 'required|string|min:3',
                'phone' => 'required|numeric|digits_between:9,12',
            ]);
            if (isset($request['firstname'])) {
//            dd($request->all());
                $recs = Registrant::where([
                    'surname' => $request['surname'],
                    'telephone' => $request['phone'],
                    'gender_id' => $request['gender']
                ])->where('firstname', 'like', '%' . $request['firstname'] . '%')->get();

            } else {
//            dd('hello');
                $recs = Registrant::where([
                    'surname' => $request['surname'],
                    'telephone' => $request['phone'],
                    'gender_id' => $request['gender']
                ])->get();
            }

            if ($recs->count() > 1) {
                alert()->info("Sorry we couldn't find your unique data. Kindly give us your firstname", 'Info')->persistent('Close');
                return redirect()->back()->withErrors(['surname' => $request['surname'], 'phone' => $request['phone'], 'gender' => $request['gender']]);
            }
            $registrant = $recs->first();
            if ($registrant) {
                $camper = $registrant;
                $checktoken = Token::where('camper_code', $camper->reg_id)->first();

                if (isset($checktoken)) {
                    alert()->info("A token has already been sent to the phone number used for registration last year. Please refer!", 'Info')->persistent('Close');
                    return back()->withInput();
                } else {
                    $token = BatchRegistration::token(6);

                    //store token
                    $saveToken = Token::firstOrCreate([
                        'camper_code' => $camper->reg_id,
                        'telephone' => $camper->telephone,
                        'token' => $token
                    ]);

                    //Initiate Camper registration status. Sets status to 0
                    $reg_status = new RegistrationStatus();
                    $reg_status->camper_code = $camper->reg_id;
                    $reg_status->rmodel = "App\\Record";
                    $reg_status->status = 0;
                    $reg_status->save();

                    //Save data into registrants table
                    $reg = Registrant::create(collect($registrant)->except(['id', 'attending'])->toArray());

                    $this->notifySMS($request->phone,
                        "Hello " . $request->firstname . ", kindly use this token to continue your registration " . $token,
                        "1234");
                    alert()->success("Thank you. A login token will be sent to your phone number to continue registration.", 'Success')->persistent('Close');
                    return back();
                }
            } else {
                $message = "No corresponding information was found. Please verify the details or register as a new camper.";
                alert()->info($message, 'Info')->persistent('Close');
                return back()->withInput();
            }
        }
        catch (\Exception $e)
        {
            if($e instanceof ValidationException){
                alert()->info("Sorry some mandatory fields are empty or incorrect. Kindly check red highlighted fields", 'Info')->persistent('Close');
                return back()->withInput();
            }

            $error = ErrorLog::insertError("RegistrantController -- verify_camper ",$e->getMessage());
            alert()->error("Sorry some error occured", 'Error')->persistent('Close');
            return back();
        }
    }

    /**
     * Verifying the token and returning to the camping information page for updates
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verify_token(Request $request){
    try {
        $this->validate($request, [
            'tphone' => 'required|numeric|digits_between:9,15',
            'token' => 'required|string|min:5',
        ]);

        $check_token = Token::where('token', '=', $request['token'])
            ->where('telephone', '=', $request['tphone'])
            ->first();
        if ($check_token) {
            session(['user' => $check_token->camper_code]);
            return redirect()->route('registrant.camper_info_update');
        } else {
            $message = "No corresponding information was found. Please verify the details or register as a new camper.";
            alert()->info($message, 'Info')->persistent('Close');
            return back()->withInput();
        }
    }
    catch (\Exception $e)
    {
        if($e instanceof ValidationException){
            alert()->info("Sorry some mandatory fields are empty or incorrect. Kindly check red highlighted fields", 'Info')->persistent('Close');
            return back()->withInput();
        }

        $error = ErrorLog::insertError("RegistrantController -- verify_token ",$e->getMessage());
        alert()->error("Sorry some error occured", 'Error')->persistent('Close');
        return back();
    }
    }

    /**
     * camping information page for updates
     * @param int $status
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function camper_update_page($status=0)
    {
        try{
            if (session()->has('user')){

                $notify = $status;
                $camper_confirmed = "";
                $camper_code = session('user');
                $registration = RegistrationStatus::where('camper_code', '=', $camper_code)->first();

                ($registration != null) ? $reg_status = $registration->status : $reg_status = 0;
                if ($reg_status <= $status){
                    $status = $reg_status;
                }

                $camper_confirmed = "";
                if($registration){
                    $camper_confirmed = Registrant::where('reg_id', '=', $camper_code)->first();
                }

                    $registrant = RegistrantStaging::where('reg_id', '=', $camper_code)->first();


//                dd($registrant);
                $gender = LookupCode::RetrieveLookups(2);
                $yesno = LookupCode::RetrieveLookups(1);
                $maritalstatus = LookupCode::RetrieveLookups(3);
                $region = LookupCode::RetrieveLookups(4);
                $area = LookupCode::RetrieveLookups(11);
                $OfficeHeldInChurch = LookupCode::RetrieveLookups(5);
                $Camper = LookupCode::RetrieveLookups(6);
                $AGDLanguage = LookupCode::RetrieveLookups(7);
                $CampApplicableFee = getCamperApplicableFees($registrant->campercat_id)->pluck("name","id");//LookupCode::RetrieveLookups(8);
                $SpecialAccomodation = LookupCode::RetrieveLookups(9);

                $payments = OnlinePayment::where(['reg_id'=> $camper_code])->whereNotNull('amount_paid')->orderBy('date_paid','asc')->get();

                $total_paid = OnlinePayment::where('reg_id','=', $camper_code)->where('approved','=',1)
                    ->where('payment_status','=',1)->sum('amount_paid');

                $amount_to_pay = camper_amount($registrant->campfee_id);

                $amount_left = (double)$amount_to_pay - (double)$total_paid;


                if($amount_left <= 0 && $camper_confirmed){
                    $camper_confirmed->confirmedpayment = 1;
                    $camper_confirmed->save();

                    $registration->status = 3;
                    $registration->save();

                    $applicant = Registrant::where('reg_id','=',$registrant->reg_id)->first();

//                    if ($registrant->campfee_id == 38 && $applicant->room_id == null) {
//                        $assignroom = new AssignRoomController;
//                        $assignroom->assignCamperRoomAuto($applicant);
//                    }

                    if (
                        in_array($registrant->campfee_id,[2,3,4,5,6,7,9,12,13,14],true)
                        && $applicant->room_id == null)
                    {
                        $assignroom = new AssignRoomController;
                        $assignroom->assignCamperRoomAuto($applicant);
                    }

                    if(Str::contains(url()->previous(),"paymentreceipt")){
                        alert()->success("Congratulations, you have been authorized!","Success")->persistent("Close");
                    }
                }

                $payment_ref = 'ACF-'.$registrant->reg_id.'-'.BatchRegistration::batchnumber(10);

                $profession = array_values(LookupCode::RetrieveLookups(10)->toArray());
                return view('camper.camperretrieveregistered', compact('registrant', 'gender', 'amount_to_pay', 'amount_left',
                    'yesno', 'maritalstatus', 'region', 'area', 'OfficeHeldInChurch', 'Camper','reg_status','total_paid',
                    'AGDLanguage', 'CampApplicableFee', 'SpecialAccomodation', 'profession', 'payments','status','registration','payment_ref'));
            }
            else{
                $message = "Please verify the details or register as a new camper.";
                alert()->info($message, 'Info')->persistent('Close');
                return redirect()->route('registrant.registeredcamper');
            }
        }
        catch (\Exception $e){

            if($e instanceof ValidationException){
                alert()->info("Sorry some mandatory fields are empty or incorrect. 
                Kindly check red highlighted fields ", 'Info')->persistent('Close');
                return back()->withInput();
            }

            $error = ErrorLog::insertError("RegistrantController -- camper_update_page ",$e->getMessage());
            alert()->error("Sorry some error occured", 'Error')->persistent('Close');
            return back();
        }

    }

    /**
     * Saving the data or information for the camping information page
     * @param Request $request
     * @param $step
     * @return \Illuminate\Http\RedirectResponse
     */
    public function camper_steps_save(Request $request,$step)
    {
        try{

        if ($step == 0) {
            $this->validate($request, [
                'surname' => 'required|string|min:3',
                'firstname' => 'required|string|min:3',
                'gender' => 'required|integer',
                'dob' => 'required|string',
                'nationality' => 'required_without:othernationality',//required if othernationality is not selected
                'othernationality' => 'required_without:nationality',//required if nationality is not selected
                'maritalstatus' => 'required',
                'permaddress' => 'nullable|string',
                'businessadress' => 'nullable|string',
                'studentaddress' => 'nullable|string',
                'telephone' => 'required|numeric',
                'email' => 'nullable|email',
                'profession' => 'nullable|string',
            ]);
            $camper_code = session('user');

            $camper_info = Record::where('reg_id', '=', $camper_code)->update([
                'surname' => $request['surname'],
                'firstname' => $request['firstname'],
                'gender_id' => $request['gender'],
                'dob' => $request['dob'],
                'nationality' => (isset($request['nationality']) && !is_numeric($request['nationality'])) ? $request['nationality'] : $request['othernationality'],
                'foreigndel_id' => $request['foreigndel'],
                'maritalstatus_id' => $request['maritalstatus'],
                'permaddress' => $request['permaddress'],
                'telephone' => str_replace('+233','0',$request['telephone']),
                'email' => $request['email'],
                'profession' => $request['profession'],
                'businessaddress' => $request['businessaddress'],
                'studentaddress' => $request['studentaddress'],
            ]);
            if ($camper_info) {

                $status = RegistrationStatus::updateOrCreate(['camper_code' => $camper_code], [
                    'status' => 0,
                    'camper_code' => $camper_code,
                    'rmodel' => "App\\Record"
                ]);
//                $status = RegistrationStatus::where('camper_code','=', $camper_code)->first();
                if ($status->status == 0) {
                    $status->status = 1;
                    $status->save();
                }
                $message = "Information updated";
                alert()->success($message, 'Success')->persistent('Close');
                if (isset($request->save_continue)) {
                    return redirect()->route('registrant.camper_info_update', [1]);
                } else {
                    return back();
                }
            } else {
                $message = "Sorry, please information provided.";
                alert()->error($message, 'Error')->persistent('Close');
                return back();
            }
        }
        elseif ($step == 1) {
            $this->validate($request, [
//                'chapter' => 'nullable|string',
                'foreigndel' => 'required|numeric',
                'localassembly' => 'required',
                'denomination' => 'required_without:otherdenomination',
                'otherdenomination' => 'required_without:denomination|required_if:denomination,2',
//                'area' => 'nullable|numeric',
//                'region' => 'required|numeric',
//                'officechurch' => 'required|numeric',
//                'officeaposa' => 'nullable|string',
                'campercat' => 'required',
                'agdlang' => 'required',
//                'agdleader' => 'nullable|numeric',
                'campfee' => 'required',
                'disclaimer' => 'required',
            ]);

            $camper_code = session('user');
//            $CampApplicableFee = LookupCode::RetrieveLookups(8);

            $camper_info = Record::where('reg_id', '=', $camper_code)->update([
                'chapter' => $request['chapter'],
                'foreigndel_id' => $request['foreigndel'],
                'localassembly' => $request['localassembly'],
                'denomination' => (isset($request['denomination']) && !is_numeric($request['denomination'])) ? $request['denomination'] : $request['otherdenomination'],
                'area_id' => $request['area'],
                'region_id' => $request['region'],
                'officeaposa' => $request['officeaposa'],
                'officechurch_id' => $request['officechurch'],
                'campercat_id' => $request['campercat'],
                'agdlang_id' => $request['agdlang'],
                'agdleader_id' => $request['agdleader'],
                'ambassadorname' => $request['ambassadorname'],
                'ambassadorphone' => $request['ambassadorphone'],
                'campfee_id' => $request['campfee'],
                'specialaccom_id' => $request['specialaccom'],
                'disclaimer_id' => $request['disclaimer'] ? 1 : 0,
            ]);
            $into_registrants = $fee_id = "";
            if ($request->campfee == 43) {
                $fee_id = $request->specialaccom;
            } else {
                $fee_id = $request->campfee;
            }
            $select_camper = Record::where('reg_id', '=', $camper_code)->first();

//            dd($select_camper);
            if ($select_camper) {
                $into_registrants = Registrant::updateOrCreate(['reg_id' => $camper_code], [
                    'surname' => $select_camper->surname,
                    'firstname' => $select_camper->firstname,
                    'gender_id' => $select_camper->gender_id,
                    'dob' => $select_camper->dob,
                    'nationality' => $select_camper->nationality,
//                    'foreigndel_id' => $select_camper->foreigndel_id,
                    'maritalstatus_id' => $select_camper->maritalstatus_id,
                    'permaddress' => $select_camper->permaddress,
                    'telephone' => $select_camper->telephone,
                    'email' => $select_camper->email,
                    'profession' => $select_camper->profession,
                    'businessaddress' => $select_camper->businessaddress,
                    'studentaddress' => $select_camper->studentaddress,

                    'chapter' => $request['chapter'],
                    'foreigndel_id' => $request['foreigndel'],
                    'localassembly' => $request['localassembly'],
                    'denomination' => (isset($request['denomination']) && !is_numeric($request['denomination'])) ? $request['denomination'] : $request['otherdenomination'],
                    'area_id' => $request['area'],
                    'region_id' => $request['region'],
                    'officeaposa' => $request['officeaposa'],
                    'officechurch_id' => $request['officechurch'],
                    'campercat_id' => $request['campercat'],
                    'agdlang_id' => $request['agdlang'],
                    'agdleader_id' => $request['agdleader'],
                    'ambassadorname' => $request['ambassadorname'],
                    'ambassadorphone' => $request['ambassadorphone'],
                    'campfee_id' => $request->campfee,
                    'specialaccom_id' => $request['specialaccom'],
                    'disclaimer_id' => $request['disclaimer'] ? 1 : 0,
                ]);
                $into_registrants_staging = RegistrantStaging::updateOrCreate(['reg_id' => $camper_code], [
                    'surname' => $select_camper->surname,
                    'firstname' => $select_camper->firstname,
                    'gender_id' => $select_camper->gender_id,
                    'dob' => $select_camper->dob,
                    'nationality' => $select_camper->nationality,
//                    'foreigndel_id' => $select_camper->foreigndel_id,
                    'maritalstatus_id' => $select_camper->maritalstatus_id,
                    'permaddress' => $select_camper->permaddress,
                    'telephone' => $select_camper->telephone,
                    'email' => $select_camper->email,
                    'profession' => $select_camper->profession,
                    'businessaddress' => $select_camper->businessaddress,
                    'studentaddress' => $select_camper->studentaddress,

                    'chapter' => $request['chapter'],
                    'foreigndel_id' => $request['foreigndel'],
                    'localassembly' => $request['localassembly'],
                    'denomination' => (isset($request['denomination']) && !is_numeric($request['denomination'])) ? $request['denomination'] : $request['otherdenomination'],
                    'area_id' => $request['area'],
                    'region_id' => $request['region'],
                    'officeaposa' => $request['officeaposa'],
                    'officechurch_id' => $request['officechurch'],
                    'campercat_id' => $request['campercat'],
                    'agdlang_id' => $request['agdlang'],
                    'agdleader_id' => $request['agdleader'],
                    'ambassadorname' => $request['ambassadorname'],
                    'ambassadorphone' => $request['ambassadorphone'],
                    'campfee_id' => $request->campfee,
                    'specialaccom_id' => $request['specialaccom'],
                    'disclaimer_id' => $request['disclaimer'] ? 1 : 0,
                ]);
            }
            if ($camper_info) {
                $current = RegistrationStatus::where('camper_code', '=', $camper_code)->first();
                if ($current->status == 1) {
                    $current->status = 2;
                    $current->save();
                }
                $message = "Information updated";
                alert()->success($message, 'Success')->persistent('Close');
                if (isset($request->save_continue)) {
                    return redirect()->route('registrant.camper_info_update', [2]);
                } else {
                    return back();
                }
            } else {
                $message = "Sorry, please information provided.";
                alert()->error($message, 'Error')->persistent('Close');
                return back();
            }
        }
        elseif ($step == 2) {
            $this->validate($request, [
                'payment_mode' => 'required|string',
                'transaction_no' => 'required|string',
                'date_paid' => 'required|string',
                'amount_paid' => 'required|numeric|min:0',
                'comment' => 'required|string',
            ]);
            $camper_code = session('user');

            $amount_to_pay = OnlinePayment::where('reg_id', '=', $camper_code)->pluck('amount_to_pay')->first();

            $amountConfirmedPaid = OnlinePayment::where('reg_id', '=', $camper_code)
                ->where('approved', '=', 1)
                ->sum('amount_paid');
            $extra = $amount_to_pay - $amountConfirmedPaid;

            $firstTime = OnlinePayment::where('reg_id', '=', $camper_code)
                ->where('amount_paid', '<=', 0)
                ->where('approved', '=', 0)
                ->first();
            $camper_info = $firstTime;
            if ($firstTime) {
                $firstTime->payment_mode = $request['payment_mode'];
                $firstTime->transaction_no = $request['transaction_no'];
                $firstTime->date_paid = $request['date_paid'];
                $firstTime->amount_paid = $request['amount_paid'];
                $firstTime->comment = $request['comment'];
                $firstTime->save();
            } else {
                $camper_info = OnlinePayment::updateOrCreate([
                    'reg_id' => $camper_code,
                    'approved' => 0,
                    'camper_type' => 1,
                    'payment_mode' => $request['payment_mode'],
                    'transaction_no' => $request['transaction_no'],
                ], [
                    'date_paid' => $request['date_paid'],
                    'amount_paid' => $request['amount_paid'],
                    'comment' => $request['comment'],
                    'amount_to_pay' => $extra,
                ]);
            }

            if ($camper_info) {
                $current = RegistrationStatus::where('camper_code', '=', $camper_code)->first();
                if ($extra < 1) {
                    $step = 3;
                    $current->status = 3;
                    $current->save();
                }
                $message = "Payment Saved! The Account team will respond to you shortly.";
                alert()->success($message, 'Success')->persistent('Close');
                return redirect()->route('registrant.camper_info_update', [$step]);
            } else {
                $message = "Sorry, please information provided.";
                alert()->error($message, 'Error')->persistent('Close');
                return back();
            }
        }
    }
    catch (\Exception $e)
    {
        if($e instanceof ValidationException){
            alert()->info("Sorry some mandatory fields are empty or incorrect. Kindly check red highlighted fields ",
                'Info')->persistent('Close');
            return back()->withInput();
        }

        $error = ErrorLog::insertError("RegistrantController -- camper_steps_save ",$e->getMessage());
        alert()->error("Sorry some error occured", 'Error')->persistent('Close');
        return back();
     }
    }

    /**
     * Profile view page for the registrant
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function viewMyProfile(){

        try {
            if (session()->has('user')) {
                $camperType = LookupCode::RetrieveLookups(6);
//            return $camperType[25];
                $camper_code = session('user');
//            dd($camper_code);
                $camper = Registrant::where('reg_id', '=', $camper_code)->first();
                if ($camper == null) {
                    alert()->info('Sorry, we\'re now building your profile!', 'Info')->persistent('Close');
                    return back();
                };
                if ($camper->confirmedpayment != 1) {
                    alert()->warning('Sorry! you have not been verified yet.', 'Ooops')
                        ->persistent('Close');
                    return back();
                } else {

                    $blockName = $block = $roomName = $resName = null;

                    if ($camper->room_id) {
                        $room = Room::findOrFail($camper->room_id);

                        $residence = Residence::findOrFail($room->residence_id);

                        $block = Block::findOrFail($room->block_id);
                        $roomName = $room->prefix."".$room->room_no."".$room->suffix;
                        $resName = $residence->name;
                        $blockName = $block->name;
                    }

                    return view('camper.my-profile', compact('camper_code', 'camper', 'camperType',
                        'roomName','blockName','resName'));
                }
            } else {
                return redirect()->route('registrant.registeredcamper');
            }
        }
        catch (\Exception $e)
        {
            $error = ErrorLog::insertError("RegistrantController -- viewMyProfile ",$e->getMessage());
            alert()->error("Sorry some error occured", 'Error')->persistent('Close');
            return back();
        }
    }

    public function chapter_progress(Request $request,$status)
    {
        try {

            $registrants = ViewRegistrant::where(['batch_no' => $request->batch_no])->get();

            if ($registrants->count() < 1) {
                alert()->info("It looks like your data isn't pushed into the system at all! Contact the Camp Coordinators", "Sorry")->persistent('Close');
                return redirect()->back();
            }

            $chapter_details = $registrants->first();

            $online_payments = OnlinePayment::where('batch_no', '=', $request->batch_no)->pluck('reg_id')->toArray();

            $nonpaidmembers = $registrants->whereNotIn('id', $online_payments)->all();

            $paidmembers = $registrants->whereIn('id', $online_payments)->all();

            return view('camper.chapterretrieve-new', compact('registrants', 'chapter_details', 'online_payments', 'nonpaidmembers', 'paidmembers'));
        }
        catch (\Exception $e)
        {
            $error = ErrorLog::insertError("RegistrantController -- chapter_progress ",$e->getMessage());
            alert()->error("Sorry some error occured", 'Error')->persistent('Close');
            return back();
        }
}

    public function onlinepaidcampers()
    {
        $registrants = Registrant::where(['confirmedpayment'=>1])
            ->with("campfee")
            ->whereNull("room_id")
            ->get();
//        dd($registrants);
        return view('admin.layout.backend.camper.confirmedindividuals',compact('registrants'));
    }

    public function paidcampers()
    {
//        $registrants = Registrant::where(['confirmedpayment'=>1])
//            ->where(function($query){
//            $query->whereRaw('LENGTH(batch_no) = 0')->orWhere(['batch_no'=>null]);
//        })->whereRaw('room_id is null')->get();
        $registrants = Registrant::where('confirmedpayment','=', 1)->get();
//        dd($registrants);
        return view('admin.layout.backend.camper.confirmedindividuals',compact('registrants'));
    }

    public function nonpaidindividual(Request $request){

        $total_online_payments = OnlinePayment::where(['reg_id'=>$request['reg_id'],'approved'=>1,'payment_status'=>1])->sum('amount_paid');
        $total_onsite_payments = Payment::where(['registrant_id'=>$request['reg_id']])->sum('amount_paid');
        $camper = Registrant::where(['reg_id'=>$request['reg_id']])->first();
        $show_camper_details = 1;

        return view('admin.layout.backend.camper.index',compact('camper','total_online_payments','total_onsite_payments','show_camper_details'));
    }

    public function paidchapters()
    {
        $registrants = Batches::whereIn('batch_no',function ($query){
            $query->select('batch_no')->from(with(new Registrant)->getTable())->where('confirmedpayment',1);
        })->get();
        return view('admin.layout.backend.camper.confirmedchaptermembers',compact('registrants'));
    }

    public function revokeauthorization(){

    }

    public function getCamperFee($fee){
        preg_match_all('!\d+!', $fee, $matches);

        $amount_to_pay = !empty($matches[0])?$matches[0][0]:0;

        return $amount_to_pay;
    }

    public function camper_logout()
    {
        session()->flush();
        return redirect('/');
    }

    public function closedcamp(){
//        alert()->info("It was great having you for Camp 2018. Registration is closed. See you at the next camp!", 'Info')->persistent('Close');
        alert()->info("It was great having you for Camp ".date('Y').". Registration for next year is opening soon!", 'Info')->persistent('Close');
    }
}