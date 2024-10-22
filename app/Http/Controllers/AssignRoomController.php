<?php

namespace App\Http\Controllers;

use App\Http\Traits\SMSNotify;
use App\Models\CampVenue;
use App\Models\Qrcode;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Residence;
use App\Models\Block;
use DB;
use App\Models\Registrant;
use App\Models\SendSMS;
use App\Models\Assignroom;
use App\Models\Campmaterial;
use App\Models\Room;
use App\Models\Registrantmaterial;
use App\Models\Lookup;
use Alert;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Input;

class AssignRoomController extends Controller
{
    use SMSNotify;
//    use SendSMS;
    //
    //
    public function __construct()
    {
        $this->middleware(['auth','isAdmin']);
    }

    public function index()
    {
        return view('admin.layout.backend.activities.assignroom');
    }

    public function allocate()
    {
        $residences = FacadesDB::table('assignrooms')
                    ->join('residences', 'assignrooms.residence_id', '=', 'residences.id')
                    ->select(FacadesDB::raw('residences.id as residence_id,residences.name as residence, sum(assignrooms.total_occupants) as total_beds, sum(assignrooms.assigned_to) as assigned_to'))
                    ->groupBy('residences.id')->get();
                    // dd($residences);

        $blocks = FacadesDB::table('assignrooms')
                    ->join('blocks', 'assignrooms.block_id', '=', 'blocks.id')
                    ->select(FacadesDB::raw('blocks.id as block_id,blocks.name as block, sum(assignrooms.total_occupants) as total_beds, sum(assignrooms.assigned_to) as assigned_to,blocks.residence_id as residence_id'))
                    ->groupBy('blocks.id')->get();
                    // var_dump($residences);
                    // dd($blocks);
        return view('admin.layout.backend.activities.allocate', compact('blocks','residences'));
    }

    public function search(Request $request)
    {
//        dd($request);
        $this->validate($request,[
            'search'      =>  'required|alpha_num|min:6',
        ]);

        //get applicant's info with the search value request
        $applicant = Registrant::where('reg_id',$request->search)->first();
        $qr_code = Qrcode::where('camper_id',$request->search)->first();
        if (!$applicant) {
           alert()->warning("Warning",'This Registration Code does not exist')->persistent("Ok");
            return back()->withInput();
        }
        $agd_language = Lookup::where('id',$applicant->agdlang_id)->pluck('FullName')->first();
        $camper_type = Lookup::where('id',$applicant->campercat_id)->pluck('FullName')->first();
        $camper_fee_type =  $applicant->campfee->fee_tag;//Lookup::where('id',$applicant->campfee_id)->pluck('FullName')->first();
        $camper_acc_type = Lookup::where('id',$applicant->specialaccom_id)->pluck('FullName')->first();

        // get all unfull reserved rooms from residence
        $unfull = Assignroom::whereColumn('assigned_to','<','total_occupants')
            ->where('assign', 1)
            ->where('type',"Reserved")
            ->orderBy('room_id')
            ->get();

         //get all the materials already given to the applicant and converted to array
        $regMaterials = collect();
        //FacadesDB::table('registrantmaterials')
//                        -> join('registrants','registrantmaterials.reg_id', '=', 'registrants.reg_id')
//                        ->where('registrantmaterials.reg_id',$request->search)
//                        ->pluck('campmaterial_id');
        $regMaterialsArray = $regMaterials->toArray();

        // get all material from database ensuring only the confrirmed ones are shown for distribution
        $materials = Campmaterial::where('show',1)->get();

        // get all rooms
        $rooms = Room::get();

        // dd($applicant->room_id);
        // dd($rooms);
        $resid = Residence::get();
        $blocks = Block::get();

//        dd($applicant->toArray());

        if (in_array($applicant->campfee_id, [10,11]))
        {
            alert()->info("Info",'Applicant registered as a non-residencial camper.')->persistent("Ok");
            return back()->withInput();
        }

        if (in_array($applicant->campfee_id, [1,8]))
        {
            alert()->info("Info","Non-fee paying applicants must authroized by Finance manually before allocation")
                ->persistent("Ok");
            return back()->withInput();
        }

        if (in_array($applicant->campfee_id, [10,11]))
        {
            alert()->info("Info",'Applicant registered as a non-residencial camper.')->persistent("Ok");
            return back()->withInput();
        }
        if ($applicant->confirmedpayment != 1) {
            alert()->info("Info",'Applicant has not been authorized. Contact Finance')->persistent("Ok");
            return back()->withInput();
        }
        else{
            $reg_gender = $applicant->gender_id;
            if ($reg_gender == 3) {
            $rgender = "M";
            }
            else {
            $rgender = "F";
            }

            $camp_venue = CampVenue::where('current_camp','=', 1)->pluck('id')->first();
            
            $residences = Residence::where('camp_venue_id','=', $camp_venue)
                ->where(function ($query) use ($rgender) {
                                $query->where('gender',$rgender)
                                      ->orWhere('gender','A');
                            })
                            ->where('status', 1)
                            ->orderBy('id','asc')
                            ->get();

            return view('admin.layout.backend.activities.search_applicant',compact('applicant','residences','rooms','materials',
                'regMaterialsArray','agd_language','camper_type','camper_fee_type','camper_acc_type','unfull','resid','blocks','qr_code'));
        }
    }

    public function assign(Request $request)
    {
        $applcantMaterials = Registrantmaterial::where('reg_id',$request->registration_id)->pluck('campmaterial_id');

        $materialCount = 0;
        if (isset($request->materials)){
            $materialCount = count($request->materials);
        }
        $applcantMaterialsArray = $applcantMaterials->toArray();

        // Get applicant data via registration number
        $applicant = Registrant::where('reg_id',$request->registration_id)->first();
        if (isset($request->qr_code)){
            $code = Qrcode::where('code','=',$request->qr_code)
                ->where('active_flag','=',1)
                ->first();

            if ($code){

                $cp_code = Qrcode::where('camper_id','=',$request->registration_id)
                    ->where('active_flag','=',1)
                    ->first();

                if ($cp_code->code != $request->qr_code){

                    if($code->camper_id == null && $cp_code){

                        $cp_code->camper_id = "";
                        $cp_code->save();

                        $code->camper_id = $request->registration_id;
                        $code->save();
                    }
                    else{
                        alert()->error('The Qr-code has been assigned!', 'Error')->persistent("Ok");
                        return back();
                    }
                }
//                else{
//                    $code->camper_id = $request->registration_id;
//                    $code->save();
//                }
            }else{
                alert()->error('The Qr-code is invalid', 'Error')->persistent("Ok");
                return back();
            }
        }

        if (isset($request->sp_accom)) {
            // echo $request->sp_accom;
            $roomName = $request->room_name;
            $resName = $request->resid_name;
            $blockName = $request->block_name;

            // if user re-assign exit from saving materials
            for ($a=0; $a < $materialCount; $a++) { 
                if (in_array($request->materials[$a], $applcantMaterialsArray)) {
                    continue;
                }
                $mats = new Registrantmaterial;
                $mats->campmaterial_id = $request->materials[$a];
                $mats->reg_id = $request->registration_id;
                $mats->save();
            }
            // 
            // 
            if ($request->sp_accom > 0) {
                $applicant->room_id = $request->sp_accom;
                $applicant->agd_no = $request->agd;
            

                if ($applicant->save()) {

                    $fname = ucfirst($applicant->firstname);
                    $sname = ucfirst($applicant->surname);

                    //commenting it out cos of internet
//                    $this->sendMessage('APOSACAMP'.date('y'), "$applicant->telephone",
//                    "$fname $sname , you have been assigned to room $roomName in $resName, $blockName",
//                    '1234');

                    alert()->success("The Applicant's. Room No. is ".$request->room_name.", ". $request->resid_name.", ".$request->block_name, 'Success')->persistent("Ok");
                                // return back();
                    return redirect(route('assign'));
                }
            }else{
                $applicant->agd_no = $request->agd;$applicant->save();
                alert()->success("Information Saved.", 'Success')->persistent("Ok");
                return redirect(route('assign'));
            }
        }
        else
        {

            $gender = $request->gender;
            // Get all unfull rooms based on gender and residence
            $unfull = Assignroom::where(function ($query) use ($gender) {
                    $query->where('gender',"$gender")
                          ->orWhere('gender','A');
                })
                ->whereColumn('assigned_to','<','total_occupants')
                ->where('residence_id',"$request->residence_id")
                ->where('block_id',"$request->block_id")
                ->where('assign', 1)
                ->where('type',"Regular")
                ->orderBy('room_no')
                ->get();

            // Get current Residence info
            $resID = (int)$request->residence_id;
            $rname = Residence::where('id',$resID)->first();

            // Checks if the return value (unfull rooms) is not empty otherwise execute
            if (sizeof($unfull) != 0) {

                // $applicant->room_id = $unfull->first();
                for ($i=0; $i < sizeof($unfull); $i++) { 
                    if ($unfull[$i]->assigned_to < $unfull[$i]->total_occupants) {

                            if ($applicant->room_id == $unfull[$i]->room_id) {
                                continue;
                            }
                        $applicant->room_id = $unfull[$i]->room_id;
                        $applicant->agd_no = $request->agd;

                        if ($appl = $applicant->save()) {

                            // if user re-assign exit from saving materials
                            for ($a=0; $a < $materialCount; $a++) { 
                                if (in_array($request->materials[$a], $applcantMaterialsArray)) {
                                    continue;
                                }
                                $mats = new Registrantmaterial;
                                $mats->campmaterial_id = $request->materials[$a];
                                $mats->reg_id = $request->registration_id;
                                $mats->save();
                            }
                            
                            $roomId = $unfull[$i]->room_id;
                            // $room = Room::where('id',$roomId)->first();
                            $room = Room::findOrFail($roomId);

                            // $residence = Residence::where('id',$room->residence_id)->first();
                            $residence = Residence::findOrFail($room->residence_id);
                            
                            // $block = Block::where('id',$room->block_id)->first();
                            $block = Block::findOrFail($room->block_id);

                            $fname = ucfirst($applicant->firstname);
                            $sname = ucfirst($applicant->surname);
                            $telephone = $applicant->telephone;
                            $roomName = $room->prefix."".$room->room_no."".$room->suffix;
                            $resName = $residence->name;
                            $blockName = $block->name;

//                            $this->sendMessage('APOSACAMP'.date('y'), "$telephone",
//                                "$fname $sname , you have been assigned to room $roomName in $resName, $blockName",
//                                '1234');
                            $this->sendMessage($telephone,
                                "$fname $sname , you have been assigned to room $roomName in $resName, $blockName","1234");
//                            $this->sendMessage('APOSACAMP'.date('y'), "$telephone",
//                                "$fname $sname , you have been assigned to room $roomName in $resName, $blockName",
//                                '1234');

                            alert()->success("The Applicant's. Room No. is ".$room->prefix."".$room->room_no."".$room->suffix.", ". $residence->name.", ".$block->name, 'Success')->persistent("Ok");
                            // return back();
                            return redirect(route('assign'));
                        }else{
                            alert()->error('Something went wrong. Please try again.', 'Error')->persistent("Ok");
                            // return redirect(route('assign'));
                            return back()->withInput();
                        }
                    }else{
                        alert()->info('Sorry, '.$rname->name.' just got full. Try next available residence.', 'Oops')->persistent("Ok");
                        // return redirect(route('assign'));
                        return back()->withInput();
                    }
                }
            }else{
                // alert()->info('Sorry, '.$rname->name.' has no available space.', 'Oops')->persistent("Ok");
                 alert()->info('Sorry, This Block has no available space.', 'Oops')->persistent("Ok");
                // return redirect(route('assign'));
                return back();
            }
            
        }
    }

    public function assignBulk(Request $request)
    {
//        get_camper_type();
        // Check if value is a bulk
        $batch = $request->bulk;
        $bulkList = Registrant::where(['batch_no'=>$batch,'confirmedpayment'=>1])->get();

        if($bulkList->count()<1){
            alert()->warning("Sorry",'No member of given batch has been authorized yet!')->persistent("Ok");
            return redirect()->back();
        }

        $types = get_camper_type();


        $Fresidences = Residence::where('gender', '!=', 'M')
            ->where('status', '=', 1)->get();

        $Mresidences = Residence::where('gender', '!=', 'F')
            ->where('status', '=', 1)->get();

        return view('admin.layout.backend.activities.bulkIndex',compact('batch','types', 'bulkList', 'Mresidences', 'Fresidences'));

        //Loop through Registrants with the batch no. to obtain batch list


        // For each batch member,
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function batchAllocation()
    {
        set_time_limit(0);
        $message = "";
        $applicants = array();
        $gender_id = Input::get('gender_id');
        $batch_id = Input::get('batch_no');

//        dd($batch_id);
        $residence_id = Input::get('residence_id');
        $block_id = Input::get('block_id');
        $bulkList = Registrant::where('batch_no','=', $batch_id)
            ->where('room_id', '=', null)
            ->where('confirmedpayment', '=', 1)
            ->where('campfee_id', '<>', 43)
            ->where('gender_id', '=', $gender_id)->get();

        if ($gender_id == 3){
            $gender = "M";
        }
        elseif ($gender_id == 4){
            $gender = "F";
        }
        else{
            $gender = "A";
        }
        foreach ($bulkList as $registrant){

                // Get all unfull rooms based on gender and residence
                $unfull = Assignroom::where(function ($query) use ($gender) {
                    $query->where('gender',"$gender")
                        ->orWhere('gender','A');
                })
                    ->whereColumn('assigned_to','<','total_occupants')
                    ->where('residence_id',"$residence_id")
                    ->where('block_id',"$block_id")
                    ->where('assign', 1)
                    ->where('type',"Regular")
                    ->orderBy('room_no')
                    ->get();

//                dd($unfull);

                // Checks if the return value (unfull rooms) is not empty otherwise execute
                if (sizeof($unfull) != 0) {

                    // $applicant->room_id = $unfull->first();
                    for ($i = 0; $i < sizeof($unfull); $i++) {

//                        if (($unfull[$i]->assigned_to < $unfull[$i]->total_occupants) and ($registrant->room_id != $unfull[$i]->room_id))
                        if (($unfull[$i]->assigned_to < $unfull[$i]->total_occupants) and ($registrant->room_id == NULL))
                        {
                            $isChild = isChild($registrant->campercat_id);
                            $room_id = $unfull[$i]->room_id;

                            //Check if the room has space for another child
                            if ($isChild and isMoreChildAllowedInRoom($room_id)){

//                                return response()->json($room_id);
                                break;

                            }else{

//                                dd($room_id);
//                                return response()->json(['registrant'=>$registrant, 'message'=> $unfull[$i]->room_id]);
//                                exit;
                                $registrant->room_id = $unfull[$i]->room_id;
                                $registrant->save();

                                break;
                            }
//                            return response()->json(['theList'=>$isChild, 'message'=> $room_id]);
                        }
                        else{
//                            dd($unfull[$i]);
                            continue;
                        }
                    }
                }
                else{
                    $message = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fa fa-warning"></i> Sorry, This Block has no available space.</div>';
                }
        }

        $batchList = Registrant::where('batch_no','=', $batch_id)
            ->where('gender_id', '=', $gender_id)->get();

        $types = get_camper_type();
//        dd($types);
        $theView = view('admin.layout.backend.activities.batch_list_response', compact('gender_id','batchList','types'))->render();
        return response()->json(['theList'=>$theView, 'message'=> $message]);
    }

    public function manual(Request $request)
    {
        $this->validate($request,[
            'r_id'      =>  'required|numeric|min:1',
            'r_app'      =>  'required|numeric|min:0',
            'applicant_no'      =>  'required|alpha_num|min:6',
        ]);
        // dd($request->r_id);
        $roomId = $request->r_id;

        $room = Room::where('id',$roomId)->first();

        //get applicant's info with the search value request
        $applicant = Registrant::where('reg_id',$request->applicant_no)->first();
        if (!$applicant) {
           alert()->warning('This Registration Code does not exist', 'Warning')->persistent("Ok");
        }
        elseif ($applicant->campfee_id == 41) {
            alert()->info('Applicant registered as a non-residencial camper.', 'Info')->persistent("Ok");
        }elseif ($applicant->confirmedpayment != 1) {
            alert()->info('Applicant has not been authorized. Contact Finance', 'Info')->persistent("Ok");
        }elseif ($applicant->room_id != null) {
            alert()->info('Applicant has not been assigned a room already. Use the applicant transfer form.', 'Info')->persistent("Ok");
        }elseif ($request->r_app >= $room->total_occupants) {
            alert()->info('Sorry, the room is up to capacity.', 'warning')->persistent("Ok");
        }else{
            $applicant->room_id = $roomId;
            $appl = $applicant->save();
                            
            $residence = Residence::where('id',$room->residence_id)->first();
            
            $block = Block::where('id',$room->block_id)->first();

            $fname = ucfirst($applicant->firstname);
            $sname = ucfirst($applicant->surname);
            $telephone = $applicant->telephone;
            $roomName = $room->prefix."".$room->room_no."".$room->suffix;
            $resName = $residence->name;
            $blockName = $block->name;

            // $this->sendMessage('APOSACAMP'.date('y'), "$telephone",
            // "$fname $sname , you have been assigned to room $roomName in $resName, $blockName",
            // '1234');

            alert()->success("The Applicant's. Room No. is ".$roomName.", ". $resName.", ".$blockName, 'Success')->persistent("Ok");
        }

        
            return back()->withInput();
    }

    public function transfer(Request $request)
    {
        $this->validate($request,[
            'r_id'      =>  'required|numeric|min:1',
            'r_app'      =>  'required|numeric|min:0',
            'applicant_no'      =>  'required|alpha_num|min:6',
        ]);
        $roomId = $request->r_id;

        $room = Room::where('id',$roomId)->first();

        //get applicant's info with the search value request
        $applicant = Registrant::where('reg_id',$request->applicant_no)->first();
        if (!$applicant) {
           alert()->warning('This Registration Code does not exist', 'Warning')->persistent("Ok");
        }
        elseif ($applicant->campfee_id == 41) {
            alert()->info('Applicant registered as a non-residencial camper.', 'Info')->persistent("Ok");
        }elseif ($applicant->confirmedpayment != 1) {
            alert()->info('Applicant has not been authorized. Contact Finance', 'Info')->persistent("Ok");
        }elseif ($request->r_app >= $room->total_occupants) {
            alert()->info('Sorry, the room is up to capacity.', 'warning')->persistent("Ok");
        }else{
            $old_room = $applicant->room_id;
            $applicant->room_id = $roomId;
            $appl = $applicant->save();
                            
            $residence = Residence::where('id',$room->residence_id)->first();
            
            $block = Block::where('id',$room->block_id)->first();

            $fname = ucfirst($applicant->firstname);
            $sname = ucfirst($applicant->surname);
            $telephone = $applicant->telephone;
            $roomName = $room->prefix."".$room->room_no."".$room->suffix;
            $resName = $residence->name;
            $blockName = $block->name;

            if ($old_room == null) {
//                $this->sendMessage('APOSACAMP'.date('y'), "$telephone",
//                "$fname $sname , you have been assigned to room $roomName in $resName, $blockName",
//                '1234');

                alert()->success("The Applicant's. Room No. is ".$roomName.", ". $resName.", ".$blockName, 'Success')->persistent("Ok");
            }else{
//                $this->sendMessage('APOSACAMP'.date('y'), "$telephone",
//                "$fname $sname , you have been re-assigned to room $roomName in $resName, $blockName",
//                '1234');

                alert()->success("Transfer successful. The Applicant's. Room No. is ".$roomName.", ". $resName.", ".$blockName, 'Success')->persistent("Ok");
            }
        }
            return back()->withInput();
    }

    public function assignCamperRoomAuto(Registrant $applicant)
    {
        ($applicant->gender_id == 3) ? $gender='M':$gender='F';

        //Get Residences based on Registrant Gender
        $camp_venue = CampVenue::where('current_camp','=', 1)->pluck('id')->first();

        $residences = Residence::where('camp_venue_id','=', $camp_venue)
            ->where(function ($query) use ($gender) {
                $query->where('gender',$gender)
                    ->orWhere('gender','A');
            })
            ->where('status', 1)
            ->orderBy('id','asc')
            ->pluck('id')->toArray();

        $blocks = Block::whereIn('residence_id', $residences)
            ->where(function ($query) use ($gender) {
                $query->where('gender',$gender)
                    ->orWhere('gender','A');
            })
            ->pluck('id')->toArray();


        // Get all unfull rooms based on gender and residence
        $unfull = Assignroom::where(function ($query) use ($gender) {
            $query->where('gender',"$gender")
                ->orWhere('gender','A');
        })
            ->whereColumn('assigned_to','<','total_occupants')
            ->whereIn('residence_id',$residences)
            ->whereIn('block_id',$blocks)
            ->where('assign', 1)
            ->where('type',"Regular")
            ->orderBy('room_id','ASC')
            ->get();


        // Get current Residence info

        // Checks if the return value (unfull rooms) is not empty otherwise execute
        if (sizeof($unfull) != 0) {

            // $applicant->room_id = $unfull->first();
            for ($i=0; $i < sizeof($unfull); $i++) {
                if ($unfull[$i]->assigned_to < $unfull[$i]->total_occupants) {

                    if ($applicant->room_id == $unfull[$i]->room_id) {
                        continue;
                    }
                    $applicant->room_id = $unfull[$i]->room_id;

                    if ($appl = $applicant->save()) {

                        $roomId = $unfull[$i]->room_id;
                        $room = Room::findOrFail($roomId);

                        $residence = Residence::findOrFail($room->residence_id);

                        $block = Block::findOrFail($room->block_id);

                        $fname = ucfirst($applicant->firstname);
                        $sname = ucfirst($applicant->surname);
                        $telephone = $applicant->telephone;
                        $roomName = $room->prefix."".$room->room_no."".$room->suffix;
                        $resName = $residence->name;
                        $blockName = $block->name;

                        $this->sendMessage($telephone, "$fname $sname , you have been assigned to room $roomName in $resName, $blockName","1234");
                        break;
                    }
                }
            }
        }

    }
}
