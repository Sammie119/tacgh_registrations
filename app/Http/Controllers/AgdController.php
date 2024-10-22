<?php

namespace App\Http\Controllers;

use App\Models\AgdSetting;
use App\Models\Lookup;
use Illuminate\Http\Request;

class AgdController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $groups = AgdSetting::all();
        $languages = Lookup::where('lookup_code_id', '=', 7)->get();
        return view('admin.layout.backend.agd.index', compact('groups','languages'));
    }

    public function save(Request $request)
    {
        $this->validate($request,[
            'shortname' => 'required|alpha|min:2',
            'group_size' => 'required|numeric|min:1',
            'fullname' => 'required|string|min:2'
        ]);
        $agdlang_id = Lookup::where('lookup_code_id', '=', 7)
            ->where('ShortName', '=', $request->shortname)->pluck('id')->first();
        AgdSetting::updateOrCreate([
            'code' => $request->shortname,
            'agdlang_id' => $agdlang_id,
        ],[
        'name' => $request->fullname,
        'size' => $request->group_size,
        ]);
        return back();
    }

    public function assignAGD_no($registrant_id)
    {
        return assignAGDNo($registrant_id);
    }
}
