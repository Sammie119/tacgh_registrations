<?php

namespace App\Http\Controllers;

use App\Models\LookupCode;
use Illuminate\Http\Request;

class LookupCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //
        $lpcodes = LookupCode::all();
        return view('admin.lookupcode.index',compact('lpcodes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.lookupcode.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request['ActiveFlag']){
            $activeflag = 1;
        }
        else{
            $activeflag = 0;
        }
        if( LookupCode::firstOrCreate([
            //'fullname' => $data['fullname'],
            'LookupShortCode' => $request['LookupShortCode'],
            'LookUpName' => $request['LookUpName'],
            'ActiveFlag' => $activeflag,
            'CreateAppUserID'=>1,
            'LastUpdateAppUserID'=>1,
        ]))
//            redirect ("index");
//            return $this->index();
            return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\LookupCode  $lookupCode
     * @return \Illuminate\Http\Response
     */
    public function show(LookupCode $lookupCode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\LookupCode  $lookupCode
     * @return \Illuminate\Http\Response
     */
    public function edit(LookupCode $lookupCode)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\LookupCode  $lookupCode
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LookupCode $lookupCode)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LookupCode  $lookupCode
     * @return \Illuminate\Http\Response
     */
    public function destroy(LookupCode $lookupCode)
    {
        //
    }
}
