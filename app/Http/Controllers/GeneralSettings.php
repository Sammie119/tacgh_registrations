<?php

namespace App\Http\Controllers;

use App\Models\CampVenue;
use App\Models\TrackVenue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GeneralSettings extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $venues = CampVenue::all();
        $current_venue = TrackVenue::where('year','=',date("Y"))->first();
        return view('admin.layout.backend.settings.general-settings',compact('venues','current_venue'));
    }

    public function saveThisYearVenue(Request $request)
    {
        DB::table('track_venues')->updateOrInsert(
            ['year' => date("Y")],
            ['camp_venue_id' => $request->venue]
        );
        DB::table('camp_venues')->where('current_camp', 1)->update(
            ['current_camp' => 0]
        );
        DB::table('camp_venues')->where('id', $request->venue)->update(
            ['current_camp' => 1]
        );

        session()->flash('message', 'Saved!');
        return back();
    }
}
