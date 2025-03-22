<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ToastNotification;
use App\Models\CampVenue;
use App\Models\Lookup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class CampVenueController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $venues = CampVenue::orderBy('name','ASC')->get();
        $regions = Lookup::where('lookup_code_id','=', 4)
            ->orderBy('FullName','ASC')
            ->pluck('FullName','id');

        return view('admin.layout.backend.venues.index',compact('venues','regions'));
    }

    public function getVenues(){
        $venues = DB::table('camp_venues')
            ->join('lookups', 'camp_venues.region_id', '=', 'lookups.id')
            ->select('camp_venues.id', 'camp_venues.name', 'camp_venues.slug', 'camp_venues.location', 'lookups.FullName', 'camp_venues.region_id')
            ->where('lookup_code_id','=', 4)
            ->orderBy('lookups.FullName','ASC')
            ->get();
        return $venues;
    }

    public function getRegions(){
        $regions = Lookup::where('lookup_code_id','=', 4)
            ->orderBy('FullName','ASC')
            ->pluck('FullName','id')->toJson();
        return $regions;
    }

    public function get_venue_info(Request $request){
        $venue = DB::table('camp_venues')
            ->join('lookups', 'camp_venues.region_id', '=', 'lookups.id')
            ->select('camp_venues.id', 'camp_venues.name', 'camp_venues.slug', 'camp_venues.location', 'lookups.FullName', 'camp_venues.region_id', 'camp_venues.current_camp')
            ->where('camp_venues.slug','=', $request->slug)
            ->first();
        $regions = Lookup::where('lookup_code_id','=', 4)
            ->orderBy('FullName','ASC')
            ->pluck('FullName','id');
        $theForm =  view('admin.layout.backend.venues.edit-venue', compact('venue','regions'))->render();
        return response()->json(['theForm'=>$theForm]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'venue'=>'required|string|unique:camp_venues,name|min:2|max:255',
            'location'=>'required|string|min:2|max:255',
            'region'=>'required|numeric'
        ]);

        $venue = CampVenue::firstOrCreate([
            'name' => ucwords($request->venue),
            'location' => ucwords($request->location),
            'region_id' => $request->region,
            'slug' => $request->venue,
        ]);
        if ($venue){
//            notify(new ToastNotification('Venue Created', $venue->venue.' has been successfully added.','success'));
            Alert::success('Venue Created successfully!', 'Success');
        }

        $getvenues = DB::table('camp_venues')
            ->join('lookups', 'camp_venues.region_id', '=', 'lookups.id')
            ->select('camp_venues.id', 'camp_venues.name', 'camp_venues.slug', 'camp_venues.location', 'lookups.FullName', 'camp_venues.region_id')
            ->where('lookup_code_id','=', 4)
            ->where('camp_venues.id','=', $venue->id)
            ->first();
        return response()->json($getvenues);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CampVenue  $campVenue
     * @return \Illuminate\Http\Response
     */
    public function show(CampVenue $campVenue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CampVenue  $campVenue
     * @return \Illuminate\Http\Response
     */
    public function edit(CampVenue $campVenue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CampVenue  $campVenue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
//        dd($request->all());
        $this->validate($request,[
            'venue'=>'required|string|unique:camp_venues,name,'.$request->id.'|min:2|max:255',
            'location'=>'required|string|min:2|max:255',
            'region'=>'required|numeric',
            'id'=>'required|numeric'
        ]);

        if($request->current_camp == 1){
            DB::table('camp_venues')->update([
                'current_camp' => 0,
            ]);
        }

        $updated = CampVenue::find($request->id)
            ->update([
                'name' => ucwords($request->venue),
                'location' => ucwords($request->location),
                'region' => $request->region,
                'slug' => $request->venue,
                'current_camp' => $request->current_camp,
            ]);

        $status=false;
        if ($updated){
            $status=true;
//            notify(new ToastNotification('Venue Updated', 'Successful','success'));
            Alert::success('Venue Updated successfully!', 'Success');
        }

//        $getvenues = DB::table('camp_venues')
//            ->join('lookups', 'camp_venues.region_id', '=', 'lookups.id')
//            ->select('camp_venues.id', 'camp_venues.name', 'camp_venues.slug', 'camp_venues.location', 'lookups.FullName', 'camp_venues.region_id')
//            ->where('lookup_code_id','=', 4)
////            ->where('camp_venues.id','=', $request->id)
//            ->get();

        return response()->json(['status'=>$status]);
    }

    public function destroy($id)
    {
        CampVenue::destroy($id);
//        notify(new ToastNotification('Venue Deletion', 'Venue deleted successfully', 'success'));
    }
}
