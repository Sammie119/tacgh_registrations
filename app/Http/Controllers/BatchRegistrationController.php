<?php

namespace App\Http\Controllers;

use App\Imports\RegistrantImport;
use App\Models\Batches;
use App\Models\BatchRegistration;
use App\Models\CampFee;
use App\Models\ChapterOnlinePaidMembers;
use App\Models\ErrorLog;
use App\Http\Traits\SMSNotify;
use App\Models\Lookup;
use App\Models\LookupCode;
use App\Models\Room;
use App\Models\OnlinePayment;
use App\Models\Payment;
use App\Models\Record;
use App\Models\Registrant;
use App\Models\RegistrantStaging;
use App\Models\RegistrationStatus;
use App\Models\Token;
use App\Models\ViewRecord;
use App\Models\ViewRegistrant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Excel;
use Alert;
use Illuminate\Validation\ValidationException;


//use Symfony\Component\Console\Input\Input;
//use UxWeb\SweetAlert\SweetAlert;

//use Illuminate\Support\Facades\Redirect;
//use Mockery\Exception;
//use PHPExcel_Shared_Date;

class BatchRegistrationController extends Controller
{
    use SMSNotify;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['auth'])->only('store','update','chapteronlineauthorize',
            'mergechapters','nonpaidchapters','onlinepaidchapters','authorizedpaidchaptermembers','authorizechapterlist');
    }

    public function index()
    {
        //
        return $this->create();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.layout.backend.batchupload');
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
     * @param  \App\BatchRegistration  $batchRegistration
     * @return \Illuminate\Http\Response
     */
    public function show(BatchRegistration $batchRegistration)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BatchRegistration  $batchRegistration
     * @return \Illuminate\Http\Response
     */
    public function edit(BatchRegistration $batchRegistration)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BatchRegistration  $batchRegistration
     * @return \Illuminate\Http\Response
     */
//    public function update(Request $request, BatchRegistration $batchRegistration)
    public function update(Request $request)
    {

        $this->validate($request,[
            'amountpaid'=>'required',
            'description'=>'required',
            'comment'=>'required'
        ]);
        $batchno = substr($request['batchno'], 1);
        $batches = Registrant::where('batch_no', '=', $batchno)->get();

        foreach ($batches as $camper) {
            $camper->confirmedpayment = 1;
            $camper->save();
        }
        $payment = new Payment();
        $payment->registrant_id = $batchno;
        $payment->amount_paid = $request['amountpaid'];
        $payment->payment_details = $batchno."-".$request['description'];
        $payment->comment = $request['comment'];
        $payment->create_app_user_id = Auth()->user()->id;
        $payment->update_app_user_id = Auth()->user()->id;
        $payment->save();



        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BatchRegistration  $batchRegistration
     * @return \Illuminate\Http\Response
     */
    public function destroy(BatchRegistration $batchRegistration)
    {
        //
    }

    //Download Batch List
    public function downloadExcel(Request $request)
    {

        $data = ViewRecord::
        exclude(['id','reg_id','chapter','carea','region','ambassadorname','ambassadorphone','batch_no'])
            ->where(['batch_no'=>$request['hidBatch']])
            ->get();

        $chap = isset($request['hidChapter']) && ($request['hidChapter'] != null)?$request['hidChapter']:"CampBatch";

        $chapter =  trim(preg_replace('/\s+/', ' ',$chap));
        return Excel::create($chapter, function($excel) use ($data,$chapter) {

            $excel->sheet($chapter, function($sheet) use ($data)
            {
//                $sheet->setColumnFormat(array(
//                    'D' => 'yyyy-mm-dd',
//                    'A:B' => '0000'
//                ));
//                $sheet->fromArray($data);
                $sheet->fromArray($data);
            });
        })->download('xlsx');

//        Redirect::to('../downloadfiles/aposa_camp_list_upload.xlsm');
//         redirect()->back();
    }

    public function importExcel(Request $request)
    {
        if(key_exists('import_file',$request->all())){
            $filename = $_FILES['import_file']['name'];
            $ext = pathinfo($filename, PATHINFO_EXTENSION);

            if($ext != "xlsx"){
                alert()->warning("Warning","Kindly check and upload valid excel using the given template");
//                notify()->flash('Ooops', 'error', ['timer' => 3000,'text' => 'It looks like your file isn\'t excel!',]);
                return redirect()->back();
            }

            $data = (Excel::toCollection(new RegistrantImport,$request->file("import_file")));

            //pick the first sheet
            $data = $data->first();

            $region = LookupCode::RetrieveLookups(4);
            if(!empty($data) && $data->count() > 1){

                foreach ($data as $value) {


                    $batches[] = [
                        'surname' => $value["surname"],
                        'firstname' => $value["firstname"],
                        'gender_id' => $value["gender"],
                        'dob' => \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value["dob"])),
                        'nationality' => $value["nationality"],
                        'maritalstatus_id' => $value["marital_status"],
                        'localassembly' => $value["local_assembly"],
                        'permaddress' => $value["permanent_address"],
                        'telephone' => $value["telephone"],
                        'email' => $value["email"],
                        'officechurch_id' => $value["office_in_church"],
                        'profession' => $value["profession"],
                        'businessaddress' => $value["business_address"],
                        'campercat_id' => $value["camper"],
                        'agdlang_id' => $value["agd_language"],
                        'agdleader_id' => $value["agd_leader"],
                        'campfee_id' => $value["applicable_camp_fee"],
                        'apngrouping' => $value["apngrouping"]
                    ];
                }
//                dd($batches);
                if(!empty($batches) && (count($batches)>1)){
                    // Store the excel data in session...
                    session(['uploaddata' => $batches]);
//                    session()->forget('uploaddata');//remove from session
                    $area = LookupCode::RetrieveLookups(11);
                    if($request['type']==1){
//                        dd($batches);
                        return view('admin.layout.backend.batchupload',compact('batches','region','area'));
                    }
                    else{
                        $registrants = ViewRecord::where('batch_no',$request['hidBatch'])->get();
                        $chapter_details = $registrants->first();

                        return view('camper.reviewchaptermembers',compact('registrants','chapter_details','batches','region','area'));
                    }

                }
                else{
                    alert()->info('Info','Batch accepts group entries only! Kindly register as an individual!')
                        ->persistent('Close');
                }
            }
        }
        else{
            alert()->info('Info','Kindly upload the excel file with member list using the given template')->persistent('Close');
        }
        return redirect()->back();
    }

    public function verify_chapter(Request $request){
        try{
            $this->validate($request,
                [
                    'batch_no' => 'required|string|min:8',
                    'btoken' => 'required|string|min:6',
                ]
            );


            $check_token = Token::where(['token'=> $request['btoken'],'camper_code'=>$request['batch_no']])->first();

            if($check_token){
                session(['user' => $check_token->camper_code]);
                return redirect()->route('batchregistration.chapter_info_update',[$request['batch_no'],0]);
            }
            else{
                $message = "No corresponding chapter was found. If you're sure of your details, kindly contact the camp registration team!";
                alert()->info("Sorry",$message)->persistent('Close');
                return back()->withInput();
            }
        }
        catch (\Exception $e){
            alert()->error('Error',"Sorry some error occured ".$e->getMessage() )->persistent('Close');
            return back()->withInput();
        }
    }

    public function batchregisternew(Request $request){
        try{

            $batchlist = Record::where(['batch_no'=>$request['hidBatch'],'attending'=>1])->get();

            if($batchlist->count() < 1){
                alert()->info('It looks like you deleted all your members from the list. Contact the camp registration team!','Sorry')->persistent('Close');
                return redirect()->route('registrant.camper_logout');
            }

            $batchlist->transform(function($i) {
                unset($i->id);
                unset($i->created_at);
                unset($i->updated_at);
                unset($i->attending);
                $i->confirmedpayment = 0;
                return $i;
            });

//        $reg_check_list = Registrant::where(['batch_no'=>$request['hidBatch']])->get()->pluck('reg_id')->toArray();
            $reg_check_list = Registrant::where(['batch_no'=>$request['hidBatch']])->whereIn('reg_id', $batchlist->pluck('reg_id')->toArray())->get()->pluck('reg_id')->toArray();

            $filtered_batch = $batchlist->reject(function ($value, $key) use($reg_check_list){
                return in_array($value['reg_id'],$reg_check_list);
            });


            if($filtered_batch->count()>0){
                Registrant::insert($filtered_batch->toArray());

                //Save the Registration Stage of the batch
                $reg_status = RegistrationStatus::firstOrNew(['camper_code'=>$request['hidBatch']]);
                $reg_status->camper_code = $request['hidBatch'];
                $reg_status->rmodel = "App\\Models\\Record";
                $reg_status->status = 1;
                $reg_status->save();
            }

            alert()->success('Success','Batches saving successful! Batch #: '.$request['hidBatch'])->persistent('Close');

            return redirect()->route('batchregistration.chapter_info_update',[$request['hidBatch'],1]);
        }
        catch (\Exception $e){
            $error = ErrorLog::insertError("BatchRegistrationController -- batchregisternew ",$e->getMessage());

            alert()->error('Error',"Sorry some error occured" )->persistent('Close');

            return redirect()->back();

        }
    }

    public function chapter_update_page($batch_no = 0,$status=0){
        try{


            $registration = RegistrationStatus::where('camper_code',$batch_no)->first();

            if(!$registration){
                $reg_status = new RegistrationStatus();
                $reg_status->camper_code = $batch_no;
                $reg_status->rmodel = "App\\Models\\Record";
                $reg_status->status = 0;
                $reg_status->save();
            }
            $reg_status = $status;

            $registrants = ViewRegistrant::where(['batch_no'=>$batch_no])->get();

            $registrants->map(function ($registrant){
                return $registrant["reg_json"] = json_encode($registrant);
            });

            if($registrants->count() < 1){
                $registrants = ViewRecord::where(['batch_no'=>$batch_no,'attending'=>1])->get();
//            $registrants = ViewRecord::where(['batch_no'=>$batch_no])->get();

                if($registrants->count()<1){
                    alert()->info("Sorry","It looks like your data isn't pushed into the system at all or you deleted all your members from the list. Contact the camp registration team!")->persistent('Close');
                    return redirect()->back();
                }
            }

            $online_chapter_payments = ChapterOnlinePaidMembers::where(['batch_no'=>$batch_no])->get();

            //Get payment details for batch grouped by token
//        $payment_details = OnlinePayment::select(\DB::raw('*,max(id) as max_id'))->where('batch_no',$batch_no)->whereNotNull('amount_paid')->get();
            $payment_details = OnlinePayment::where('batch_no',$batch_no)->whereNotNull('amount_paid')
                                ->orderBy('created_at','desc')->get();

            $online_payments = $online_chapter_payments->pluck('reg_id')->toArray();

            $nonpaidmembers = $registrants->whereNotIn('reg_id',$online_payments)->all();

            $paidmembers = $registrants->whereIn('reg_id',$online_payments)->all();

            $chapter_details = $registrants->first();


            $registrants->map(function($item,$key){

                if(!$item->Applicable_Camp_Fee){
                    {
                        alert()->warning("Info","Some camp member's applicacle fee not selected. Kindly check the list and update!")->persistent('Close');
                        return redirect()->back()->withInput();
                    }
                }
//                return $this->getCamperFee((strtolower($item->Applicable_Camp_Fee) == "special accomodation")?$item->Type_of_Special_Accomodation:$item->Applicable_Camp_Fee);
            });


            $total_fee = $registrants->sum("camper_fee") ; //array_sum($total_payment_all_campers->toArray());

            $received_online_payments = OnlinePayment::where('batch_no','=', $batch_no)->where(['approved'=>1,'payment_status'=>1])->sum('amount_paid');

            //Get List of members checked as paid by chapter leader
            $campers_checked = array_map('current',ChapterOnlinePaidMembers::where(['batch_no'=>$batch_no])->select('reg_id')->get()->toArray());

            $total_payment_checked_campers = $registrants->map(function($item,$key) use ($campers_checked){//
                if(in_array($item->reg_id,$campers_checked))
                    return $item->camper_fee;
//                return $this->getCamperFee((strtolower($item->Applicable_Camp_Fee) == "special accomodation")?$item->Type_of_Special_Accomodation:$item->Applicable_Camp_Fee);
            });

            $total_payment_checked_campers = array_sum($total_payment_checked_campers->toArray());

            $camp_fees = CampFee::where(["active_flag"=>1])->get()->each(function ($model) { $model->setAppends(['fee_description']); })
                ->pluck("fee_description","id");

            $gender = LookupCode::RetrieveLookups(2);
            $yesno = LookupCode::RetrieveLookups(1);
            $maritalstatus = LookupCode::RetrieveLookups(3);
            $region = LookupCode::RetrieveLookups(4);
            $OfficeHeldInChurch = LookupCode::RetrieveLookups(5);
            $Camper = LookupCode::RetrieveLookups(6);
            $AGDLanguage = LookupCode::RetrieveLookups(7);
            $CampApplicableFee = $camp_fees;//LookupCode::RetrieveLookups(8);
            $SpecialAccomodation = LookupCode::RetrieveLookups(9);
            $area = LookupCode::RetrieveLookups(11);
            $areaOfCounseling = LookupCode::RetrieveLookups(17);

            $profession = array_values(LookupCode::RetrieveLookups(10)->toArray());


            $payment_ref = 'ACF-'.$chapter_details->batch_no.'-'.BatchRegistration::batchnumber(10);

            return view('camper.chapterretrieve-new',compact('registrants','chapter_details',
                'online_payments','nonpaidmembers','paidmembers','payment_details', 'gender', 'yesno', 'maritalstatus',
                'region', 'OfficeHeldInChurch', 'Camper', 'AGDLanguage', 'CampApplicableFee', 'SpecialAccomodation',
                'area', 'profession', 'reg_status', 'status','payment_ref','total_payment_checked_campers','total_fee',
                'received_online_payments','areaOfCounseling'));
        }
        catch (\Exception $e){
            alert()->error("Sorry some error occured ".$e->getMessage(), 'Error')->persistent('Close');
            return redirect()->back();
        }
    }

    public function batchregister(Request $request)
    {
        try{
            $this->validate($request,[
                'chapter'=>'required',
                'area'=>'required',
                'ambassadorname'=>'required',
                'ambassadorphone'=>'required',
                'denomination' =>'required_without:otherdenomination',
                'otherdenomination'=>'required_without:denomination',
                'region'=>'required'
            ]);

            if($values = session('uploaddata'))
            {
                $lookups[] = Lookup::get(['id','FullName'])->toArray();

                $fees = CampFee::where(["active_flag"=>1])->get();

                $arr2 = array();
                if(isset($request['hidBatchNo'])){
                    $batchno = $request['hidBatchNo'];
                }
                else{
                    $batch = Batches::firstOrCreate([
                        'chapter'=>$request['chapter'],
                        'ambassadorname'=>$request['ambassadorname'],
                        'ambassadorphone'=>$request['ambassadorphone']
                    ]);

                    $batchno = Batches::find($batch->id)->batch_no;//BatchRegistration::batchnumber(5)."-".$date->getTimestamp();
                }

                //map all dropdowns with appropriate system dropdown value
                foreach ($values as $key => $value) {

                    $camper_cat_id = $this->lookupkey($lookups,"FullName",$value['campercat_id']);

                    $camper_fee = findItemsInCollection($fees,$camper_cat_id,$value['campfee_id'])->first();
//                    dd($camper_fee);
                    if(is_null($this->lookupkey($lookups,"FullName",$value['maritalstatus_id']))
                        || is_null($this->lookupkey($lookups,"FullName",$value['gender_id']))
                        || is_null($this->lookupkey($lookups,"FullName",$value['officechurch_id']))
                        || is_null($this->lookupkey($lookups,"FullName",$value['agdlang_id']))
                        || is_null($this->lookupkey($lookups,"FullName",$value['campercat_id']))
                        || is_null($this->lookupkey($lookups,"FullName",$value['apngrouping']))
                        || is_null($camper_fee) || empty($camper_fee)
                    )
                    {
                        alert()->error("Sorry",'Please fill the excel you downloaded and upload same. Also check all selected dropdowns to be sure they are correct')->persistent('Close');

                        return back()->withInput();
                    }
                    else{

                        $value['maritalstatus_id'] = $this->lookupkey($lookups,"FullName",$value['maritalstatus_id']);
                        $value['gender_id'] = $this->lookupkey($lookups,"FullName",$value['gender_id']);
                        $value['officechurch_id'] = $this->lookupkey($lookups,"FullName",$value['officechurch_id']);
                        $value['agdlang_id'] = $this->lookupkey($lookups,"FullName",$value['agdlang_id']);
                        $value['agdleader_id'] = $this->lookupkey($lookups,"FullName",$value['agdleader_id']);
                        $value['campercat_id'] = $this->lookupkey($lookups,"FullName",$value['campercat_id']);
                        $value['apngrouping'] = $this->lookupkey($lookups,"FullName",$value['apngrouping']);
                        $value['campfee_id'] = $camper_fee->id;
//                        $value['specialaccom_id'] = $this->lookupkey($lookups,"FullName",$value['specialaccom_id']);
                        $value['region_id']=$request['region'];
                        $value['chapter']=$request['chapter'];
                        $value['area_id']=$request['area'];
                        $value['ambassadorname']=$request['ambassadorname'];
                        $value['ambassadorphone']=$request['ambassadorphone'];
//                        $value['denomination']= (isset($request['denomination']) && !is_numeric($request['denomination']))
//                                                                ? $request['denomination'] : $request['otherdenomination'];
                        $value['created_at'] =  \Carbon\Carbon::now();
                        $value['updated_at'] = \Carbon\Carbon::now();
                        $value['batch_no']=$batchno;
                        $value['attending']=1;

                        $arr2[] = $value;
                    }

                }

                if(isset($request['hidBatchNo'])){

                    foreach ($arr2 as $camper) {
                        if($camper['camper_code']){
                            $registrant = Record::where(['reg_id'=>$camper['camper_code']])->first();
                            $registrant_merged = array_merge($registrant->toArray(),$camper);

                            unset($registrant_merged['camper_code']);
                            $registrant->update($registrant_merged);
                            Registrant::firstOrCreate($registrant_merged);
                        }
                        else{

                            $rec = Record::where(['surname'=>$camper['surname'],'firstname'=>$camper['firstname'],'dob'=>$camper['dob']])->first();

                            unset($camper['camper_code']);
                            if(isset($rec)){
                                $rec->update($camper);
                            }else{
                                Record::Create($camper);
                            }

                            $reg = Registrant::where(['surname'=>$camper['surname'],'firstname'=>$camper['firstname'],'dob'=>$camper['dob']])->first();

                            if(isset($reg)){
                                $reg->update($camper);
                            }else{
                                $camper['denomination'] = $request['denomination'];
                                $camper['area_id'] = $request['area'];
                                $camper['region_id'] = $request['region'];
                                $camper['ambassadorname'] = $request['ambassadorname'];
                                $camper['ambassadorphone'] = $request['ambassadorphone'];

                                Registrant::Create($camper);
                            }
                        }
                    }
                }

                else{

                    $chapter_members = $arr2;//RegistrantStaging::where(['batch_no'=>$batchno])->get();

                    $batch_members = [];
                    $batch_registrants = [];
//                    $batch_records = [];
                    foreach ($chapter_members as $camper) {

//                        unset($camper['id']);
                        unset($camper['created_at']);
                        unset($camper['updated_at']);

                        $stage_registrant = RegistrantStaging::firstOrCreate($camper);

                        $reg = RegistrantStaging::find($stage_registrant->id);

                        $batch_members[]=collect($reg)->except(['id','batch_id'])->toArray();;

                        $batch_registrants[] = collect($reg)->except(['id','attending'])->toArray();

                    }

                    Registrant::insert($batch_registrants);
                    Record::insert($batch_members);
                }

                //Save registration status
                $reg_status = new RegistrationStatus();
                $reg_status->camper_code = $batchno;
                $reg_status->rmodel = "App\\Models\\Record";
                $reg_status->status = 0;
                $reg_status->save();

                $get_token = Token::where(['camper_code'=>$batchno])->first();
                if($get_token != null){
                    $token = $get_token->token;
                }
                else{
                    $token = BatchRegistration::token(6);

                    //store token
                    Token::firstOrCreate([
                        'camper_code' => $batchno,
                        'telephone' => $request['ambassadorphone'],
                        'token' => $token
                    ]);
                }

                $this->notifySMS($request['ambassadorphone'],
                    'Congrats '.$request['ambassadorname'].', you registered '.count($arr2).' succesfully. Registration is incomplete until authorized at camp. Batch #: '.$batchno.' and login token: '.$token,
                    '1234');

                alert()->success("Success",'Batch registration of '.count($arr2).' was successful! Batch #: '.$batchno.'. A token will be sent to your phone shortly!')->persistent('Close');
                return redirect('/');
            }
            else{
                alert()->info("Info","Sorry, uploaded data must have been lost, please try upload again")->persistent('Close');
                return redirect()->back();
            }
        }
        catch (\Exception $e){
            $error = ErrorLog::insertError("BatchRegistrationController -- batchregister",$e->getMessage());
            alert()->error("Error","Sorry some error occured ")->persistent('Close');
            return redirect()->back();
        }
    }

    public function lookupkey($lookups, $field, $name)
    {
        foreach($lookups as $lookup)
        {
            foreach ($lookup as $key => $value){
                $name = preg_replace('/\s+/', '', $name);
                $value[$field] = preg_replace('/\s+/', '', $value[$field]);
                if( strtolower($value[$field]) == strtolower($name)){
                    return $value["id"];
                }
            }
        }
    }

    public function summaryreport($maritalstatus,$officers,$agdleaders,$camper){

    }

    public function checkValue($type){
        switch ($type){
            case 'name':
                return 'Valid';

        }
    }

    public function chapter_save_progress(Request $request){

        try{
            if($request['registrants'] == null || count(array_unique($request['registrants'])) < 0){
                alert()->warning('Warning','You must select at least two of your members as paid to proceed')->persistent('Close');
                return redirect()->back()->withInput();
            }

            //will later work on saving the payment details to DB
//       $recs =  Registrant::whereIn('id', $request['registrants'])->get();
            $request['registrants'] = array_unique($request['registrants']);

            $checkedrecs =  Registrant::whereIn('id', array_unique($request['registrants']))->with('campfee')->get();
//            dd($checkedrecs);
            //generate payment token to identify this batch selected campers payment
            $payment_token = BatchRegistration::token(6);
            $members = array();
            $batch_payments = array();
            foreach ($checkedrecs as $rec) {
                $members['reg_id'] = $rec->reg_id;
//            $members['payment_mode'] = $request['payment_mode'];
//            $members['transaction_no'] =  $request['transaction_no'];
//            $members['camper_type'] = 2;
                $members['payment_token'] =  $payment_token;
//            $members['date_paid'] =  $request['date_paid'];
                $members['camper_fee'] =  $rec->campfee->fee_amount;//Get camper fee from lookup
//            $members['amount_paid'] =  $request['amount'];
                $members['batch_no'] =  $request['hidBatchNo'];
//            $members['comment'] =  $request['comment'];
                $batch_payments [] = $members;
            }
//            dd($batch_payments);
//       Update registrant table, set confirmedpayment to -1
        $recs =  Registrant::whereIn('id', $request['registrants'])->update(['confirmedpayment' => 1]);
//dd($request['hidBatchNo']);
            //Update Status of batch in online_payments
            RegistrationStatus::where('camper_code', $request['hidBatchNo'])->update(['status' => 2]);

            ChapterOnlinePaidMembers::insert($batch_payments);

            foreach ($request['registrants'] as $registrant){
                $applicant = Registrant::where('id', $registrant)->first();
                if($applicant->room_id == null){
                    $assignroom = new AssignRoomController;
                    $assignroom->assignCamperRoomAuto($applicant);
                }
            }

//        alert()->success('Payment for '.count($request['registrants']).' members of your batch has been saved. Payment token is: '.$payment_token,'Success')->persistent('Close');
            alert()->success(count($request['registrants']).' member(s) of your batch are checked as members you\'re paying for.','Success')->persistent('Close');
            return redirect()->route('batchregistration.chapter_info_update',[$request->hidBatchNo,2]);
        }
        catch (\Exception $e){
            ErrorLog::insertError("BatchRegistrationController - chapter_save_progress",$e->getMessage());
            alert()->error('Sorry, some error occured!','Error')->persistent('Close');
            return back();
        }
    }

    public function getBatchMemberList(Request $request = null){
        $registrants = ViewRecord::where(["surname"=>"adjetey"])->first();

        return response()->json($registrants);
    }

    public function chaptermemberedit(Request $request)
    {

        try{
            if(isset($request)){
                $this->validate($request, [
                    'surname'=>'required|min:3',
                    'firstname' =>'required|min:3',
                    'gender_id' =>'required',
                    'dob' =>'required',
                    'maritalstatus_id' =>'required',
                    'localassembly' =>'required',
                    'telephone' =>'required',
                    'officechurch_id' =>'required',
                    'campercat_id' =>'required',
                    'agdlang_id' =>'required',
                    'camperfee_id' =>'required',
                    'needcounseling_id' =>'required',
                    'counselingarea_id' =>'required_if:needcounseling_id,1',
//                    'nationality' => 'required_without:othernationality',//required if othernationality is not selected
//                    'othernationality' => 'required_without:nationality',//required if nationality is not selected
//                    'specialaccom_id' => 'required_if:campfee_id,43',
                ]);

                //entry type 1:New Member; 2:Update Member
                if($request['entry_form'] == 1){
//                $registrant = new RegistrantStaging();//Discuss with Baiden checking of record exist
                    $registrant = Registrant::where(['firstname'=>$request['firstname'],'dob'=>$request['dob'],'telephone'=>$request['telephone']])->first();
                    if($registrant){
                        return response()->json(['mcode'=>2,'message'=>"It looks like you're already registered. Please contact the numbers on the registration page! "]);
                    }
                    else{
                        $registrant = new RegistrantStaging();
                    }

                    $registrant->batch_no = $request['batch_no'];
                }
                else{
                    $registrant = Record::where(['reg_id'=>$request['camperid']])->first();

                    $registrant_data = Registrant::where(['reg_id'=>$request['camperid']])->first();
                }

//            $chapter_details = Record::where(['batch_no'=>$request['batch_no']])->whereNotNull('ambassadorphone')->first();
                $chapter_details = Record::where(['batch_no'=>$request['batch_no']])->first();

                if($chapter_details){
                    $registrant->area_id = $chapter_details->area_id;
                    $registrant->region_id = $chapter_details->region_id;
                    $registrant->denomination = $chapter_details->denomination;
                    $registrant->chapter = $chapter_details->chapter;
                    $registrant->nationality = $chapter_details->nationality;
                    $registrant->ambassadorname = $chapter_details->ambassadorname;
                    $registrant->ambassadorphone = $chapter_details->ambassadorphone;
                }

                $registrant->surname = $request['surname'];
                $registrant->firstname = $request['firstname'];
                $registrant->gender_id = $request['gender_id'];
                $registrant->dob = $request['dob'];
                $registrant->maritalstatus_id = $request['maritalstatus_id'];
                $registrant->localassembly = $request['localassembly'];
                $registrant->permaddress = $request['permaddress'];
                $registrant->telephone = $request['telephone'];
                $registrant->email = $request['email'];
                $registrant->officeaposa = $request['officeaposa'];
                $registrant->officechurch_id = $request['officechurch_id'];
                $registrant->profession = $request['profession'];
                $registrant->businessaddress = $request['businessaddress'];
                $registrant->campercat_id = $request['campercat_id'];
                $registrant->campfee_id = $request['camperfee_id'];
//                $registrant->specialaccom_id = $request['specialaccom_id'];
                $registrant->agdlang_id = $request['agdlang_id'];
                $registrant->agdleader_id = $request['agdleader_id'];
                $registrant->need_counseling = $request['needcounseling_id'];
                $registrant->area_of_counseling = $request['counselingarea_id'];

                $registrant->batch_no = $request['batch_no'];
                $registrant->attending = 1;
                $registrant->update_app_userid = -40;
                $registrant->save();

                if($request['entry_form'] == 1){
                    $registrant = RegistrantStaging::where(['id'=>$registrant->id,'batch_no'=>$registrant->batch_no])->first();

                    $reg = Registrant::firstOrCreate(collect($registrant)->except(['id','attending'])->toArray());


                    $registrant = Record::firstOrCreate(collect($registrant)->except(['id'])->toArray());
                }
                else{
                    //update registrant table with possible changes
                    if($registrant_data){
                        $registrant_data->update(collect($registrant)->except(['id','attending'])->toArray());
                    }
                }

                $record = ViewRecord::where(['reg_id'=>$registrant['reg_id']])->first();


                if($record){
                    return response()->json(['mcode'=>1,'message'=>'Successful! ','type'=>'record','data'=>$record]);
                }
                else{
                    $registrant = ViewRegistrant::where(['reg_id'=>$registrant['reg_id']])->first();
                    return response()->json(['mcode'=>1,'message'=>'Successful! ','type'=>'registrant','data'=>$registrant]);
                }
            }
        }
        catch (\Exception $e){
            if($e instanceof ValidationException){
//                alert()->info("Sorry some mandatory fields are empty or incorrect. Kindly check red highlighted fields", 'Info')->persistent('Close');
//                return response()->json(['mcode'=>-1,'message'=>'Error! '.$e->getMessage()]);
                $errors = get_validation_errors($e->errors());

                return response()->json(['mcode'=>-10,'message'=>$errors]);
//                return back()->withInput();

            }
            ErrorLog::insertError("BatchRegistrationController - chaptermemberedit",$e->getMessage());
            return response()->json(['mcode'=>-1,'message'=>'Sorry some error occured saving data']);
        }
    }

    //Remove camper from batch list
    public function chaptermemberdelete(Request $request)
    {

        try {
            $request = $request->all();

//            return response()->json(['message'=>'Delete successful! ','data'=>$request]);

            if (isset($request)) {
                $registrant = Record::where(['reg_id' => $request['camperid'], 'batch_no' => $request['batch_no']])->first();


                if ($registrant) {
                    $registrant->attending = 0;
                    $registrant->save();

                    //remove from registrants if record exists
                    $rec = Registrant::where(['reg_id'=>$request['camperid'],'batch_no'=>$request['batch_no']])->delete();
                     Record::where(['reg_id'=>$request['camperid'],'batch_no'=>$request['batch_no']])->update(['attending'=>0]);
//                    $rec = Registrant::where(['reg_id' => $request['camperid']])->first();

                    if ($rec) {

//                        return response()->json(['status' => -1, 'message' => 'Delete successful! ', 'data' => $request,'rec'=>$rec]);

//                        $rec->delete();
//                        return response()->json(['status' => 1, 'message' => 'Delete successful! ', 'data' => $request]);
                        return response()->json(['status' => -1, 'message' => 'Delete successful! ', 'data' => $request,'rec'=>$rec]);
                    } //                }
                    else {
                        return response()->json(['message' => 'Registrant details not found']);
                    }
                } else {
                    return response()->json(['status' => 0, 'message' => 'Request not set properly ']);
                }
            }


        } catch (\Exception $ex) {
            return response()->json(['status' => 0, 'message' => 'Some error occured ', $ex->getMessage()]);
        }
    }

    public function exportBatchList(UserListExport $export)
    {
        // work on the export
        return $export->sheet('sheetName', function($sheet)
        {

        })->export('xls');
    }


    public function batchform(Request $request)
    {
        //Total Gender Rooms
        $total_male_rooms = Room::where('gender','=','M')
            ->where('assign','=',true)
            ->sum('total_occupants');
        $total_female_rooms = Room::where('gender','=','F')
            ->where('assign','=',true)
            ->sum('total_occupants');

        //Total Rooms assigned to each Gender
        $total_male_assigned_room = Registrant::where('gender_id','=',3)
            ->where('room_id','>',0)
            ->count('id');
        $total_female_assigned_room = Registrant::where('gender_id','=',4)
            ->where('room_id','>',0)
            ->count('id');
        $total_female_rooms_left = $total_female_rooms - $total_female_assigned_room;
        $total_male_rooms_left = $total_male_rooms - $total_male_assigned_room;
//        return $this->closedcamp();

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
        $apngrouping = LookupCode::RetrieveLookups(19);

        $rows = 2;
        if (isset($request)){
            if ($request->rows < 2){
                $rows = 2;
            }else{
                $rows = $request->rows;
            }
        }
        return view('camper.table-batch',compact('rows','gender','yesno','maritalstatus','region',
            'OfficeHeldInChurch','Camper','AGDLanguage','CampApplicableFee','SpecialAccomodation','area','areaOfCounseling',
            'total_female_rooms_left','total_male_rooms_left', 'apngrouping'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function batchform_save(Request $request)
    {
        try{
            $this->validate($request,[
                'chapter' =>'required|string',
                'ambassadorname' =>'required|string',
                'ambassadorphone' =>'required|numeric',
                'area' =>'required|numeric',
                'region' =>'required|numeric',
                'localassembly' =>'required',
                'denomination' =>'required_without:otherdenomination',
                'otherdenomination'=>'required_without:denomination|required_if:denomination,2',
                'surname' =>'required|array',
                'surname.*' =>'required|string',
                'nationality' =>'required|array',
                'nationality.*' =>'required|string',
                'firstname' =>'required|array',
                'firstname.*' =>'required|string',
                'gender_*' =>'required|numeric',
                'maritalstatus_*' =>'required|numeric',
                'foreigndel_*' =>'required|numeric',
//                'foreigndel_*' =>'required|numeric',
                'telephone' =>'nullable|array',
                'telephone.*' =>'nullable|numeric',
                'email' =>'nullable|array',
                'email.*' =>'nullable|string',
//                'foreigndel_*' =>'required|numeric',
                'officechurch_*' =>'required|numeric',
//                'foreigndel_*' =>'required|array',
                'campercat_*' =>'required',
                'agdlang_*' =>'required',
                'agdleader_*' =>'required|numeric',
                'needcounseling_*' =>'required|numeric',
                'campfee_*' =>'required',
                'specialaccom_*' =>'required_if:campfee,43',
                'disclaimer' =>'required|numeric|min:1|max:1',
            ]);

            $date = \Carbon\Carbon::now();

        $batch_no = BatchRegistration::batchnumber(5)."-".$date->getTimestamp();

            $batchno = Batches::create([
                'chapter'=>$request['chapter'],
                'batch_no'=>$batch_no,
                'ambassadorname'=>$request['ambassadorname'],
                'ambassadorphone'=>$request['ambassadorphone']
            ]);

            $batch = Batches::findOrFail($batchno->id);

            $no_campers = sizeof($request->surname);

            $batch_upload_list = array();

            for ($a = 0; $a < $no_campers; $a++){
                $b = $a+1;
                $rec = array();
                $rec['surname'] = $request->surname[$a];
                $rec['firstname'] = $request->firstname[$a];
                $rec['gender_id'] = $request['gender_'.$b];
                $rec['dob'] = $request['dob'][$a];
                $rec['nationality'] = $request['nationality'][$a];
                $rec['foreigndel_id'] = $request['foreigndel_'.$b];
                $rec['maritalstatus_id'] = $request['maritalstatus_'.$b];
                $rec['localassembly']=$request['localassembly'];
                $rec['denomination']=(isset($request['denomination']) && !is_numeric($request['denomination'])) ? $request['denomination'] : $request['otherdenomination'];
                $rec['area_id']=$request['area'];
                $rec['region_id']=$request['region'];
                $rec['telephone']=$request['telephone'][$a];
                $rec['email']=$request['email'][$a];
                $rec['batch_no']=$batch->batch_no;
                $rec['officechurch_id']=$request['officechurch_'.$b];
                $rec['campercat_id']=$request['campercat_'.$b];
                $rec['agdlang_id']=$request['agdlang_'.$b];
                $rec['agdleader_id']=$request['agdleader_'.$b];
                $rec['ambassadorname']=$request['ambassadorname'];
                $rec['ambassadorphone']=$request['ambassadorphone'];
                $rec['campfee_id']=$request['campfee_'.$b];
//                if (isset($request['specialaccom_'.$b])){
//                    $rec['specialaccom_id']=$request['specialaccom_'.$b];
//                }

                $rec['need_counseling'] = $request['needdounseling_'];
                $rec['area_of_counseling'] = $request['counselingarea_'.$b];

                $rec['update_app_userid']=Auth::id();

                $rec['region_id']=$request['region'];
                $rec['area_id']=$request['area'];
                $rec['chapter'] = $request['chapter'];
                $rec['batch_no'] = $batch->batch_no;
                $rec['ambassadorname']=$request['ambassadorname'];
                $rec['ambassadorphone']=$request['ambassadorphone'];
                $rec['apngrouping']=$request['apngrouping'];
                $rec['created_at'] =  \Carbon\Carbon::now();
                $rec['updated_at'] = \Carbon\Carbon::now();
                $batch_upload_list[]  = $rec;
            }
            RegistrantStaging::insert($batch_upload_list);

            $saved_batch_list = RegistrantStaging::where(['batch_no'=>$batch->batch_no])->get();

            $saved_batch_list->transform(function($i) {
                unset($i->id);
                unset($i->created_at);
                unset($i->updated_at);
                unset($i->attending);
                unset($i->batch_id);
                $i->confirmedpayment = 0;
                return $i;
            });

            Registrant::insert($saved_batch_list->toArray());
            Record::insert($saved_batch_list->toArray());

            $reg_status = new RegistrationStatus();
            $reg_status->camper_code = $batch->batch_no;
            $reg_status->rmodel = "App\\Models\Record";
            $reg_status->status = 1;
            $reg_status->save();

            $token = BatchRegistration::token(6);


            //store token
            Token::firstOrCreate([
                'camper_code' => $batch->batch_no,
                'telephone' => $request['ambassadorphone'],
                'token' => $token
            ]);

            $this->notifySMS($request['ambassadorphone'],
                'Congrats '.$request['ambassadorname'].', registration was successful. Registration is incomplete until authorized at camp. Batch #: '.$batch->batch_no.' and login token: '.$token,
                '1234');

            alert()->success('Campers have been added successfully! Batch #: '.$batch->batch_no.'. A token will be sent to the Ambassaddor phone number.','Success')->persistent('Close');
            return redirect()->route('registrant.registeredcamper');
        }
        catch (\Exception $e){
            ErrorLog::insertError("BatchRegistrationController - batchform_save",$e->getMessage());
            alert()->error("Error","Sorry some error occured saving data");
            return back()->withInput();
        }
    }

    public function chapteronlineauthorize(Request $request){

        $this->validate($request,[
//            'id' =>'required',
            'ptoken' =>'required',
            'batchno' =>'required',
            'amountpaid' =>'required',
            'paymentdetails' =>'required|min:5',
            'comment' =>'required'
        ]);

        $paidcampers = OnlinePayment::where(['batch_no'=>$request['batchno'],'payment_token'=>$request['ptoken']])->select('reg_id')->get();

        $batches = Registrant::where(['batch_no'=>$request['batchno']])->whereIn('reg_id',$paidcampers->toArray())->update(['confirmedpayment'=>1]);

        OnlinePayment::where(['batch_no'=>$request['batchno'],'payment_token'=>$request['ptoken']])->update(['approved'=>1]);

        $payment = new Payment();
        $payment->registrant_id = $request['batchno'];
        $payment->amount_paid = $request['amountpaid'];
        $payment->payment_details = "online payment approved for ".$request['batchno']." (".$request['ptoken'].") ".$request['paymentdetails'];
        $payment->comment = $request['comment'];
        $payment->create_app_user_id = Auth()->user()->id;
        $payment->update_app_user_id = Auth()->user()->id;
        $payment->save();

        alert()->success($batches.' member(s)  of  Batch #: '.$request['batchno'].' authorized successfully!','Success')->persistent('Close');
        return redirect()->back();
    }

    public function importTokens(){
        return view('camper.tokenupload');
    }

    public function doimportTokens(Request $request)
    {

        if(Input::hasFile('import_file')){

            $filename = $_FILES['import_file']['name'];
            $ext = pathinfo($filename, PATHINFO_EXTENSION);

            if($ext != "xlsx"){
                notify()->flash('Ooops', 'error', ['timer' => 3000,'text' => 'It looks like your file isn\'t excel!',]);
                return redirect()->back();
            }

            $batches = array();
            $path = Input::file('import_file')->getRealPath();

            $data = Excel::selectSheets('Sheet1')->load($path, function($reader) {
            })->get();

            if(!empty($data) && $data->count()){
                foreach ($data as $key => $value) {
                    $batches[]= ['camper_code' => $value->batch_no,'token' => $value->token, 'telephone' => $value->ambassadorphone,'created_at'=>\Carbon\Carbon::now(),'updated_at'=>\Carbon\Carbon::now()];
                }
            }

            Token::insert($batches);
        }
        return redirect()->back();
    }

    public function includeCamper(Request $request)
    {
        try{
            $this->validate($request,[
                'camper_id'     =>  'required|string|min:7',
                'token'         =>  'required|string|max:7',
                'batch_no'      =>  'required|string|min:10'
            ]);


            $batch = Record::where('batch_no','=',$request->batch_no)->first();
            if ($batch){

                $camper = Record::where('reg_id','=',$request->camper_id)->first();

                $batch_id = Batches::select('id')->where(['batch_no'=>$request->batch_no])->orWhere(['old_batch_no'=>$request->batch_no])->first()['id'];

                if($batch_id){

                    if ($camper){
//                    $camper->batch_id = $batch_id;
                        $camper->batch_no = $request->batch_no;
                        $camper->ambassadorname = $batch->ambassadorname;
                        $camper->ambassadorphone = $batch->ambassadorphone;
                        $camper->save();

                        $camper_reg = Registrant::where('reg_id','=',$request->camper_id)->first();
                        if ($camper_reg){
//                           $camper_reg->batch_id = $batch_id;
                            $camper_reg->batch_no = $request->batch_no;
                            $camper_reg->ambassadorname = $batch->ambassadorname;
                            $camper_reg->ambassadorphone = $batch->ambassadorphone;
                            $camper_reg->save();
                        }

                        $token = Token::where(['camper_code'=>$camper->reg_id])->first();
                        if($token){
                            $token->delete();
                        }
//                return $camper_reg;
                        alert()->success('Success','Successful, the Camper has been added to your Batch!')->persistent('Close');
                    }
                    else{

                        alert()->info('Sorry, the Camper information is invalid.','Info')->persistent('Close');
                    }
                }
                else{
                    alert()->info('Sorry, Batch not found.','Info')->persistent('Close');
                }

            }
            else{
                alert()->info('Sorry, we couldn\'t find batch details. Please contact the System Administrator!','Info')->persistent('Close');
            }
            return redirect()->back();
        }
        catch (\Exception $e){
            $error = ErrorLog::insertError("BatchRegistrationController - includeCamper",$e->getMessage());
            alert()->error('Sorry, some error occured!','Error')->persistent('Close');
            return back();
        }

    }

    public function excludeCamper(Request $request)
    {
        try{
            $this->validate($request,[
                'camper_id'     =>  'required|string|min:7',
                'phone'         =>  'required|string|min:8',
                'batch_no'      =>  'required|string|min:10'
            ]);


            $camper = Record::where('reg_id','=',$request['camper_id'])->first();

            if ($camper){
                $camper->batch_no = "";
                $camper->ambassadorname = "";
                $camper->ambassadorphone = "";
                $camper->save();

                $camper_reg = Registrant::where('reg_id','=',$request['camper_id'])->first();
                if ($camper_reg){
//                    $camper_reg->telephone = $request->phone;
//                    $camper_reg->batch_id = null;
                    $camper_reg->batch_no = "";
                    $camper_reg->ambassadorname = "";
                    $camper_reg->ambassadorphone = "";

//                    $camper_reg->update([''])
                    $camper_reg->save();
                }

                //
                ChapterOnlinePaidMembers::where(['reg_id'=>$request['camper_id'],'batch_no'=>$request['batch_no']])->delete();


                alert()->success('Successful, the Camper has been excluded from your Batch!','Success')->persistent('Close');
            }
            else{
                alert()->info('Sorry, we couldn\'t process your request. Please contact any Registration Team!','Info')->persistent('Close');
            }
            return back();
        }
        catch (\Exception $e){
            $error = ErrorLog::insertError("BatchRegistrationController - excludeCamper",$e->getMessage());
            alert()->error('Sorry, some error occured!','Error')->persistent('Close');
            return back();
        }
    }

    public function nonpaidchapters(Request $request)
    {
        try{
            $show_batch_list = 0;
            if ($request['batch_no']) {

                $batch_no = $request['batch_no'];

                $registrants = ViewRegistrant::whereIn('reg_id', function ($query) use ($batch_no) {
                    $query->select('reg_id')->from(with(new Registrant)->getTable())->where(['batch_no' => $batch_no, 'confirmedpayment' => 0]);

                })
                    ->get();
                return view('admin.layout.backend.camper.chaptersindex', compact('registrants', 'show_batch_list', 'batch_no'));
            }

            else {
                $registrants = Batches::whereIn('batch_no', function ($query) {
                    $query->select('batch_no')->from(with(new Registrant)->getTable())->where(['confirmedpayment' => 0]);
                })
                    ->whereNotIn('batch_no',function ($query) {
                        $query->select('reg_id')->from(with(new OnlinePayment)->getTable())->where(['approved' => 1, 'payment_status' => 1]);
                    })
                    ->get();

                $show_batch_list = 1;
                return view('admin.layout.backend.camper.chaptersindex', compact('registrants', 'show_batch_list'));
            }
        }
        catch (\Exception $e){
            $error = ErrorLog::insertError("BatchRegistrationController - includeCamper",$e->getMessage());
            alert()->error('Sorry, some error occured!','Error')->persistent('Close');
            return back();
        }

    }
    public function onlinepaidchapters(Request $request)
    {

        try{
        $show_batch_list = 0;
        if ($request['batch_no']) {

            $batch_no = $request['batch_no'];

            $registrants = ViewRegistrant::where(['batch_no' => $batch_no])->get();

            $chapter_payments = ChapterOnlinePaidMembers::where(['batch_no' => $batch_no])->get();
            $chapter_payments_not_authorized = ChapterOnlinePaidMembers::where(['batch_no' => $batch_no, 'approved' => 0, 'payment_status' => 0])->get();

            //Get payment details for batch grouped by token
            $payment_details = OnlinePayment::where('batch_no', $batch_no)->whereNotNull('amount_paid')
                ->orderBy('created_at', 'desc')->get();

//            dd($payment_details);

            $online_payments = $chapter_payments->where('payment_status', 1)->pluck('reg_id')->toArray();

//            dd($online_payments);

            $nonpaidmembers = $registrants->whereNotIn('reg_id', $online_payments)
                ->whereNotIn('reg_id', $chapter_payments_not_authorized->pluck('reg_id')->toArray(), 'or')
                ->all();


            $paidmembers = $registrants->whereIn('reg_id', $chapter_payments->where('payment_status', 0)->pluck('reg_id')->toArray())->all();


            $total_payment_all_campers = $registrants->map(function ($item) {
                return $item->camper_fee;
//                return $this->getCamperFee((strtolower($item->Applicable_Camp_Fee) == "special accomodation")
//                    ? $item->Type_of_Special_Accomodation : $item->Applicable_Camp_Fee);
            });

//            dd($total_payment_all_campers);

            $total_fee = array_sum($total_payment_all_campers->toArray());

//            dd($total_fee);

            $received_online_payments = OnlinePayment::where('batch_no', '=', $batch_no)->where(['approved' => 1, 'payment_status' => 1])->sum('amount_paid');

//            dd($received_online_payments);

            $camp_grounds_payments = Payment::where('registrant_id', '=', $batch_no)
                ->distinct('amount_paid','payment_details')->get()->sum("amount_paid");

//            dd($camp_grounds_payments);


            $received_online_payments = $received_online_payments + $camp_grounds_payments;

            $campers_checked = array_map('current', ChapterOnlinePaidMembers::where(['batch_no' => $batch_no])->select('reg_id')->get()->toArray());

//            dd($campers_checked);

            $total_payment_checked_campers = $registrants->map(function ($item, $key) use ($campers_checked) {//
                if (in_array($item->reg_id, $campers_checked))
                    return $item->camper_fee;
//                    return $this->getCamperFee((strtolower($item->Applicable_Camp_Fee) == "special accomodation") ? $item->Type_of_Special_Accomodation : $item->Applicable_Camp_Fee);
            });

            $total_payment_checked_campers = array_sum($total_payment_checked_campers->toArray());

//            dd($total_payment_checked_campers);
            //Get List of members checked as paid by chapter leader
            $authorized_payments = array_map('current', ChapterOnlinePaidMembers::where(['batch_no' => $batch_no, 'approved' => 1])->select('reg_id')->get()->toArray());

            $total_authorized_payments = $registrants->map(function ($item) use ($authorized_payments) {//
                if (in_array($item->reg_id, $authorized_payments))
                    return $item->camper_fee;
//                    return $this->getCamperFee((strtolower($item->Applicable_Camp_Fee) == "special accomodation") ? $item->Type_of_Special_Accomodation : $item->Applicable_Camp_Fee);
            });

            $total_authorized_payments = array_sum($total_authorized_payments->toArray());

//            dd($registrants->first()->toArray());
            return view('admin.layout.backend.camper.onlinepaidchaptersindex', compact('registrants', 'paidmembers', 'nonpaidmembers', 'payment_details', 'show_batch_list', 'total_fee',
                'total_payment_checked_campers', 'total_payment_all_campers', 'received_online_payments', 'total_authorized_payments', 'batch_no'));
        }
        else {
            $registrants = Batches::whereIn('batch_no', function ($query) {
                $query->select('batch_no')->from(with(new Registrant)->getTable())->where(['confirmedpayment' => 0]);
            })
                ->whereIn('batch_no', function ($query) {
                    $query->select('batch_no')->from(with(new OnlinePayment)->getTable())->where(['payment_status' => 1, 'approved' => 1]);
                })
                ->get();
            $show_batch_list = 1;
            return view('admin.layout.backend.camper.onlinepaidchaptersindex', compact('registrants', 'show_batch_list'));
                }
            }
        catch (\Exception $e){
//            dd($e->getMessage());
            if($e instanceof ValidationException){
            alert()->info("Info","Sorry some mandatory fields are empty or incorrect. Kindly check red highlighted fields")->persistent('Close');
            return back()->withInput();
            }
            ErrorLog::insertError("BatchRegistrationController -- onlinepaidchapters ",$e->getMessage());

            alert()->error('Error',"Sorry some error occured", )->persistent('Close');
            return back()->withInput();
            }
    }

    public function authorizedpaidchaptermembers(Request $request){

        try{

            if(isset($request['move_to_paid']) && $request['move_to_paid'] == 1){

                $checkedrecs =  Registrant::whereIn('reg_id', array_unique($request['registrants']))->with('campfee')->get();

                $payment_token = BatchRegistration::token(6);
                $members = array();
                $batch_payments = array();
                foreach ($checkedrecs as $rec) {
                    $members['reg_id'] = $rec->reg_id;
                    $members['payment_token'] =  $payment_token;
                    $members['camper_fee'] =  preg_replace("/[^0-9\.]/", '',$rec->campfee->FullName);//Get camper fee from lookup
                    $members['batch_no'] =  $request['batch_no'];
                    $members['approved'] =  0;
                    $members['payment_status'] =  0;
                    $batch_payments [] = $members;
                }
                ChapterOnlinePaidMembers::insert($batch_payments);

                alert()->success(count($checkedrecs)." added to paid list.","Success")->persistent('Close');
                return redirect()->back();
            }

            if(isset($request['paidregistrants'])){
                if(count($request['paidregistrants']) < 1){
                    alert()->info("Kindly move campers from non-paid to the paid list to authorize!","Info")->persistent('Close');
                    return redirect()->back()->withInput();
                }

                $registrants = ViewRegistrant::where(['batch_no'=>$request['batch_no']])->whereIn('reg_id',$request['paidregistrants'])
                    ->select('reg_id','Applicable_Camp_Fee','Type_of_Special_Accomodation')->get();

                $total_payment_checked_campers = $registrants->map(function($item,$key) {//
                    return $item->camper_fee;
//                    return $this->getCamperFee((strtolower($item->Applicable_Camp_Fee) == "special accomodation")?$item->Type_of_Special_Accomodation:$item->Applicable_Camp_Fee);
                });

                $total_payment_checked_campers = array_sum($total_payment_checked_campers->toArray());

                $total_amount_paying = $request['amount_balance'] + $request['amount_paid'];

                if($total_payment_checked_campers > $total_amount_paying){
                    alert()->info("You can only authorize for campers whose fees total GHS ".$total_amount_paying,"Info")->persistent('Close');
                    return redirect()->back()->withInput();
                }

                Registrant::where(['batch_no'=>$request['batch_no'],'confirmedpayment'=>0])->whereIn('reg_id',$request['paidregistrants'])
                    ->update(['confirmedpayment'=>1,'update_app_userid'=>\Auth()->user()->id]);

                ChapterOnlinePaidMembers::where(['batch_no'=>$request['batch_no'],'approved'=>0])->whereIn('reg_id',$request['paidregistrants'])
                    ->update(['approved'=>1,'payment_status'=>1,'comment'=>$request['comment']]);

                $payment = new Payment();
                $payment->registrant_id = $request['batch_no'];
                $payment->amount_paid = $request['amount_paid'];
                $payment->payment_details = $request['batch_no']."-".$request['description'];
                $payment->comment = $request['comment'];
                $payment->create_app_user_id = Auth()->user()->id;
                $payment->update_app_user_id = Auth()->user()->id;
                $payment->save();

                alert()->info("Checked campers authorized successfully!","Info")->persistent('Close');
                return redirect()->back();
            }
            else{
                alert()->info("Kindly move campers from non-paid to the paid list to authorize!","Info")->persistent('Close');
                return redirect()->back()->withInput();
            }


        }
        catch (\Exception $e){
            if($e instanceof ValidationException){
                alert()->info("Sorry some mandatory fields are empty or incorrect. Kindly check red highlighted fields", 'Info')->persistent('Close');
                return back()->withInput();
            }
            $error = ErrorLog::insertError("BatchRegistrationController -- authorizedpaidchaptermembers ",$e->getMessage());

            alert()->error("Sorry some error occured", 'Error')->persistent('Close');
            return back()->withInput();
        }
    }

    public function authorizechapterlist(Request $request){
        try{
            $this->validate($request,[
                'amount_paid'=>'required|numeric',
                'batch_no'=>'required|min:10|max:10'
            ]);

            $registrants = ViewRegistrant::where(['batch_no'=>$request['batch_no']])->whereIn('reg_id',$request['registrants'])
                ->select('reg_id','Applicable_Camp_Fee','Type_of_Special_Accomodation')->get();

            $total_payment_checked_campers = $registrants->map(function($item,$key) {//

                return $item->camper_fee;
//                return $this->getCamperFee((strtolower($item->Applicable_Camp_Fee) == "special accomodation")?$item->Type_of_Special_Accomodation:$item->Applicable_Camp_Fee);
            });

            $total_payment_checked_campers = array_sum($total_payment_checked_campers->toArray());

            if($total_payment_checked_campers > $request['amount_paid']){
                alert()->info("You can only authorize for campers whose fees total GHS ".$request['amount_paid'].' Total is: GHS '.$total_payment_checked_campers,"Info")->persistent('Close');
                return redirect()->back()->withInput();
            }

            $payment = new Payment();
            $payment->registrant_id = $request['batch_no'];
            $payment->amount_paid = $request['amount_paid'];
            $payment->payment_details = $request['batch_no']."-".$request['description'];
            $payment->comment = $request['comment'];
            $payment->create_app_user_id = Auth()->user()->id;
            $payment->update_app_user_id = Auth()->user()->id;
            $payment->save();

            Registrant::where(['batch_no'=>$request['batch_no'],'confirmedpayment'=>0])->whereIn('reg_id',$request['registrants'])
                ->update(['confirmedpayment'=>1,'update_app_userid'=>\Auth()->user()->id]);


            alert()->info("Checked campers authorized successfully!","Info")->persistent('Close');
            return redirect()->back();
        }
        catch (\Exception $e){
            if($e instanceof ValidationException){
                alert()->info("Sorry some mandatory fields are empty or incorrect. Kindly check red highlighted fields", 'Info')->persistent('Close');
                return back()->withInput();
            }
            $error = ErrorLog::insertError("BatchRegistrationController -- authorizechapterlist ",$e->getMessage());

            alert()->error("Sorry some error occured", 'Error')->persistent('Close');
            return back()->withInput();
        }
    }

    public function mergechapters(Request $request){
        if($request->all()){
            if($request['batch_no'] == $request['secondary_batch_no']){
                alert()->info("You can't merge same batch ".$request['batch_no'],"Info")->persistent('Close');
                return redirect()->back()->withInput();
            }

            $primary = Token::where(['camper_code'=>$request['batch_no'],'token'=>$request['btoken']])->first();
            $secondary = Token::where(['camper_code'=>$request['secondary_batch_no'],'token'=>$request['secondary_token']])->first();

            if($primary && $secondary){
                Registrant::where(['batch_no'=>$request['secondary_batch_no']])
                    ->update(['batch_no'=>$request['batch_no'],'update_app_userid'=>\Auth()->user()->id]);

                Record::where(['batch_no'=>$request['secondary_batch_no']])
                    ->update(['batch_no'=>$request['batch_no'],'update_app_userid'=>\Auth()->user()->id]);

                alert()->success("Chapters merged successfully. Chapter ID: ".$request['batch_no'],"Success")->persistent('Close');;
                return redirect()->back();
            }
            else{
                alert()->info("One or none of the Batch code and token match our records","Info")->persistent('Close');;
                return redirect()->back()->withInput();
            }
        }
        return view('admin.layout.backend.camper.mergechapters');
    }

    public function closedcamp(){
//        alert()->info("It was great having you for Camp 2018. Registration is closed. See you at the next camp!", 'Info')->persistent('Close');
        alert()->info("It was great having you for Camp 2018. Registration for 2019 is opening soon!", 'Info')->persistent('Close');
        return redirect()->back();
    }


    public function getCamperFee($fee){

        if($fee){
            preg_match_all('!\d+!', $fee, $matches);

            $amount_to_pay = !empty($matches[0])?$matches[0][0]:0;

            return $amount_to_pay;
        }
//        else

    }
}