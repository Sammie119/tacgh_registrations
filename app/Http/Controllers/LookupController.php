<?php

namespace App\Http\Controllers;

use App\Models\Lookup;
use App\Models\LookupCode;
use Illuminate\Http\Request;
use DB;
use Alert;

class LookupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
//        $this->middleware(['auth','isAdmin']);
        $this->middleware(['auth','isAdmin','initPwdChanged']);
    }

    public function index()
    {
        //
        $lookupcodes = LookupCode::pluck('LookUpName', 'id')->all();
        $lpcodes = Lookup::where('lookup_code_id',3)->paginate(10);

//        dd($lpcodes);
        return view('admin.lookup.index',compact('lpcodes','lookupcodes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $lookups = LookupCode::pluck('LookUpName', 'id')->all();
        return view('admin.lookup.create',compact('lookups'));
        //  var_dump($lookups);
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
        $this->validate($request,[
           'fullname'=>'required',
            'lookup'=>'required',
//            'ActiveFlag'=>'required'
        ]);
        if(!is_null($request['clickedlookup'])){
            $this->update($request,$request['clickedlookup']);
        }

     else{
        if( Lookup::firstOrCreate([
            'FullName' => $request['fullname'],
//            'ShortName' => $request['shortname'],
//            'UseShortName' => $request['useshortname'] ? 1 : 0,
            'lookup_code_id'=>$request['lookup'],
            'ActiveFlag'=>$request['ActiveFlag'] ? 1 : 0,
//            'Toggled'=>$request['Toggled'] ? 1 : 0,
            'CreateAppUserID'=>\Auth::user()->id,//To be replaced by logged in user ID
            'LastUpdateAppUserID'=>\Auth::user()->id])){
            Alert::success('Lookup item added succesfully', 'Success');
            return $this->index();
        }
        else{
            Alert::error('Error adding item', 'Error')->persistent('Close');
            return $this->index();
        }
    }
//            redirect("index");
        //die($request);
        return $this->index();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Lookup  $lookup
     * @return \Illuminate\Http\Response
     */
    public function show(Lookup $lookup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Lookup  $lookup
     * @return \Illuminate\Http\Response
     */
    public function edit(Lookup $lookup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Lookup  $lookup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        //
//        dd($request);
        $lookup = Lookup::find($id);
        $lookup->FullName = $request['fullname'];
        $lookup->ActiveFlag = $request['ActiveFlag'] ? 1:0;
        $lookup->LastUpdateAppUserID = \Auth::user()->id;
        $lookup->save();
        Alert::success('Lookup item updated succesfully', 'Success');
        return $this->index();
//        dd($lookup);
//        dd("you are about updating");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Lookup  $lookup
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lookup $lookup)
    {
        //
    }

    public function lookupindex()
    {
        $lookupid = $_GET['lookupid'];//get LookUpCode id

//        $lpcodes = Lookup::where('lookup_code_id',3)->get();//retrieve Lookups with such ID
        $lpcodes = Lookup::where('lookup_code_id',$lookupid)->get();//retrieve Lookups with such ID
//        dd($lpcodes);
        return $lpcodes;
//        return $lookupid;
    }

//    public function retrievelookups($lookupid)
//    {
//
//        $lookupcodes = LookupCode::pluck('LookUpName', 'id');
//        $lpcodes = Lookup::where('lookup_code_id',$lookupid)->paginate(10);
//        return view('admin.lookup.index',compact('lpcodes','lookupcodes'));
//        //dd($lpcodes);
//    }
//    public function getLookups(){
//
//    }
}
