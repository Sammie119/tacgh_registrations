<?php

namespace App\Http\Controllers;

use App\Models\Registrant;
use App\Models\ViewRecord;
use Illuminate\Http\Request;
use DB;
// use App\Models\Assignroom;
use App\Models\Residence;
// use App\Models\Registrantmaterial;
use App\Models\Payment;
use App\Models\Lookup;
// use App\Models\Block;

class ReportsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    	return view('admin.layout.backend.report.index');
    }

    public function camperReport(Request $request)
    {
    	$registrants = null;
    	$genders = null;
    	$chapters = null;
    	$lookups = Lookup::orderBy('lookups.id', 'asc')->get();
    	// return $request->all();
    	if (isset($request->camper_type)) {
    		$registrants = Lookup::select('lookups.id','lookups.FullName', DB::raw('count(registrants.id) as campers'))
			    		->leftJoin('registrants','lookups.id','=','registrants.campercat_id')
			    		->where('lookups.lookup_code_id',6)
			    		->where('registrants.confirmedpayment',1)
    					->orderBy('lookups.id', 'asc')
    					->groupBy('lookups.FullName')
    					->get();

    					// dd($registrants);
    	}

    	if (isset($request->gender)) {
    		$genders = Lookup::select('lookups.id','lookups.FullName', DB::raw('count(registrants.id) as campers'))
			    		->leftJoin('registrants','lookups.id','=','registrants.gender_id')
			    		->where('lookups.lookup_code_id',2)
			    		->where('registrants.confirmedpayment',1)
    					->orderBy('lookups.id', 'asc')
    					->groupBy('lookups.FullName')
    					->get();
    	}
    	if (isset($request->chapter)) {
    		$chapters = "Not yet available";
    	}
    	return view('admin.layout.backend.report.results',compact('registrants','lookups','genders','chapters'));
    }

    public function accountReport(Request $request)
    {
    	$camper_type = null;
    	$per_day = null;
    	$lookups = Lookup::orderBy('lookups.id', 'asc')->get();

    	if (isset($request->camper_type)) {
    		$camper_type = Lookup::select('lookups.id','lookups.FullName', DB::raw('sum(payments.amount_paid) as amount'))
			    		->leftJoin('registrants','lookups.id','=','registrants.campercat_id')
			    		->leftJoin('payments','registrants.id','=','payments.registrant_id')
			    		->where('lookups.lookup_code_id',6)
			    		->where('registrants.confirmedpayment',1)
    					->orderBy('lookups.id', 'asc')
    					->groupBy('lookups.FullName')
    					->get();

    	}

    	if (isset($request->per_day)) {
    		$per_day = Payment::select(DB::raw('date(updated_at) as per_day, sum(payments.amount_paid) as amount'))
    					->orderBy('per_day', 'asc')
    					->groupBy('per_day')
    					->get();
    					// dd($per_day);
    	}
    	return view('admin.layout.backend.report.accounts',compact('camper_type','per_day','lookups'));
    }
    public function financialreport(){
        $payments = Payment::payments()->get();
//        dd($payments);
        return view('admin.layout.backend.report.finances',compact('payments'));
    }

    public function genericreport(){
//        $payments = Payment::payments()->get();

        //get applicant's info with the search value request
        $paidapplicants = Registrant::participants(1)->get();

        return view('admin.layout.backend.report.genericreport',compact('paidapplicants'));
    }

    public function records(){
        $registrants = ViewRecord::select('reg_id','surname','firstname','olddob','gender','telephone','local_assembly')->get();
        return view('admin.layout.backend.report.records',compact('registrants'));
    }

    public function allpaidcampers(){
        $applicants = Registrant::participants(1)->get();
        return view('admin.layout.backend.report.all_paid_campers',compact('applicants'));
    }

    public function repchapterleaders(){
        $applicants = Registrant::ChapterLeaders();
//        dd($applicants);
        return view('admin.layout.backend.report.rep_chapter_leaders',compact('applicants'));
    }

    public function campersToCounsel(){
        $campers = Registrant::where(["need_counseling"=>1])->orWhereNotNull("area_of_counseling")
            ->with("counselingArea","campercat")->get();

        return view('admin.layout.backend.report.campers_to_counsel',compact('campers'));
    }

}
