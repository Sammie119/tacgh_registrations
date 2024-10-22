<?php

namespace App\Http\Controllers;

use App\Models\CampFee;
use App\Models\LookupCode;
//use Alert;
use Illuminate\Http\Request;

class CampFeeController extends Controller
{
    public function __construct() {
//        $this->middleware(['auth', 'isAdmin']); //isAdmin middleware lets only users with a //specific permission permission to access these resources
        $this->middleware(['auth','isAdmin'])->except("getCamperCatFees"); //isAdmin middleware lets only users with a //specific permission permission to access these resources
//        $this->middleware(['auth', 'isAdmin'])->except('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Get all users and pass it to the view
        $fees = CampFee::with(["camperType" => function($r){
            return $r->select("FullName","id");
        }])->get();
        return view('admin.layout.backend.campfee.index',compact("fees"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $camperTypes = LookupCode::retrieveLookups(6);
        return view('admin.layout.backend.campfee.create', compact('camperTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'camper_type_id'=>'required|numeric',
            'fee_tag'=>'required|min:5',
            'fee_amount'=>'required|numeric'
        ]);

        $fee = CampFee::firstOrCreate([
            "camper_type_id"=>$request["camper_type_id"],
            "fee_tag"=>$request["fee_tag"],
            "fee_amount"=>$request["fee_amount"],
            "active_flag"=>(key_exists("active_flag",$request->all())) ? 1:0,
            "create_app_user_id"=>\Auth()->user()->id,
            "update_app_user_id"=>\Auth()->user()->id,
        ]);

        if($fee){
            alert()->success("Success","Camper Fee added successfully");
            return redirect()->route("campfee.index");
        }

        return redirect()->back()->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CampFee  $campFee
     * @return \Illuminate\Http\Response
     */
    public function show(CampFee $campFee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CampFee  $campFee
     * @return \Illuminate\Http\Response
     */
    public function edit(CampFee $campfee)
    {
        $camperTypes = LookupCode::retrieveLookups(6);
//        dd($campfee);
        return view('admin.layout.backend.campfee.edit', compact("campfee",'camperTypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CampFee  $campFee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CampFee $campfee)
    {
        if(!key_exists("active_flag",$request->all()))
            $request["active_flag"] = 0;

        $campfee->update_app_user_id = \Auth()->user()->id;
        $campfee->update($request->except(["_token","_method"]));

        alert()->success('Success','Camper fee updated!')->persistent("Okay");
        return redirect()->route('campfee.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CampFee  $campFee
     * @return \Illuminate\Http\Response
     */
    public function destroy(CampFee $campFee)
    {
        //
    }


    public function getCamperCatFees($catid){
        $fees = CampFee::where(["camper_type_id"=>$catid,"active_flag"=>1])->get()
            ->map(function($fee){
                return ["id"=>$fee->id,"name"=>$fee->fee_tag." - GHC ".$fee->fee_amount];
            });
        return response()->json(['data' => $fees]);
    }
    public function getCamperCatFeesCollection($catid){
        return CampFee::where(["camper_type_id"=>$catid,"active_flag"=>1])->get()
            ->map(function($fee){
                return ["id"=>$fee->id,"name"=>$fee->fee_tag." - GHC ".$fee->fee_amount];
            });
//        return $fees;
    }
}
