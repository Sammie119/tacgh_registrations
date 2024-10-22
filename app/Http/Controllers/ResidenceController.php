<?php

namespace App\Http\Controllers;
use App\Models\CampVenue;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Input;
use Yajra\Datatables\Datatables;
use App\Models\Residence;
use App\Models\Room;
use App\Models\Block;
use Alert;

class ResidenceController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param $venue_slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function get_venue_residences($venue_slug)
    {
        $camp_venue = CampVenue::where('slug','=',$venue_slug)->first();

        return view('admin.layout.backend.residence.camp_residence', compact('camp_venue'));
    }

    /**
+     * Display a listing of the resource.
+     *
+     * @return \Illuminate\Http\Response
+     */
    public function index()
    {
        $residence = Residence::latest()->get();
        // $residence = Residence::orderBy('created_at','desc')->get();
        return view('admin.layout.backend.residence.index', compact('residence'));
    }

    /**
     * @param $venue_slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create($venue_slug)
    {
        $residence = array(
            "page_title"    =>  "Add New Residence",
            "button"        =>  "Save Residence",
        );
        return view('admin.layout.backend.residence.create', compact('residence','venue_slug'));
    }

    /**
     * @param Request $request
     * @param $venue_slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function store(Request $request, $venue_slug)
    {
        $this->validate($request,[
            'name'      =>  'required|string',
            'blocks'    =>  'required|max:15|min:1|numeric',
//            'rooms'     =>  'required|max:3000|min:1|numeric',
            'status'     =>  'max:1',
            'gender'     =>  'max:1',
        ]);
        $venue = CampVenue::where('slug','=', $venue_slug)->pluck('id')->first();

        if ($venue){
            $res = str_replace('_', ' ', $request->name);
            $residence = new Residence;
            $residence->name = ucwords($res);
            $residence->total_blocks = $request->blocks;
            $residence->camp_venue_id = (integer)$venue;
            $residence->status = $request->status;
            $residence->gender = $request->gender;
//        $residence->total_rooms = $request->rooms;
            if ($residence->save()) {
                Alert::success('Residence Added', 'Success')->autoclose(1200);
                return redirect()->route('venue.residences',[$venue_slug]);
            }
            else{
                Alert::error('Sorry, we had trouble here!', 'Error')->autoclose(1200);
                return back();
            }
        } else {
            Alert::success('Sorry the camp venue is not available.', 'Success')->autoclose(1200);
            return back();
        }

    }

    /**
     *
     */
    public function show($id)
    {
        $residence = Residence::findOrFail($id);

        return $residence;
    }

    /**
     * @param $venue_slug
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($venue_slug,$id)
    {
        $venue = CampVenue::where('slug','=', $venue_slug)->pluck('id')->first();

        if ($venue) {
            $residence = Residence::findOrFail($id);
            return view('admin.layout.backend.residence.edit', compact('residence','venue_slug'));
        } else {
            Alert::success('Sorry the camp venue is not available.', 'Success')->autoclose(1200);
            return back();
        }
    }

    /**
     * @param Request $request
     * @param $venue_slug
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function update(Request $request, $venue_slug, $id)
    {
        $venue = CampVenue::where('slug','=', $venue_slug)->pluck('id')->first();

        if (!$venue) {
            Alert::success('Sorry the camp venue is not available.', 'Success')->autoclose(1200);
            return back();
        }

        $residence = Residence::findOrFail($id);

        $this->validate($request,[
            'name'      =>  'required|string',
            'blocks'    =>  'required|max:10|min:1|numeric',
//            'rooms'     =>  'required|max:3000|min:1|numeric',
            'status'     =>  'max:1',
            'gender'     =>  'max:1',
        ]);
        $name = str_replace('_', ' ', $request->name);
        $residence->name = ucwords($name);
        $residence->total_blocks = $request->blocks;
//        $residence->total_rooms = $request->rooms;
        $residence->status = $request->status;
        $residence->gender = $request->gender;


        if ($residence->save()) {
            $rooms = Room::where('residence_id', $id)->get();
            if (($request->gender == "F" or $request->gender == "M") and $rooms) {
                
                foreach ($rooms as $room) {
                    $room->gender = $request->gender;
                    $room->save();
                }
            }
            elseif (($request->gender == "A") and $rooms){

                foreach ($rooms as $room) {
                    $room->gender = null;
                    $room->save();
                }
            }

            $blocks = Block::where('residence_id', $id)->get();
            if (($request->gender == "F" or $request->gender == "M") and $blocks) {
                
                foreach ($blocks as $block) {
                    $block->gender = $request->gender;
                    $block->save();
                }
            }
            elseif (($request->gender == "A") and $blocks){

                foreach ($blocks as $block) {
                    $block->gender = null;
                    $block->save();
                }
            }
            Alert::success('Residence Updated', 'Success')->autoclose(1200);
            return redirect()->route('venue.residences',[$venue_slug]);
        }
        else{
            Alert::error('Sorry we had trouble here!', 'Error')->autoclose(1200);
            return back();
        }
    }

    /**
     * @param $venue_slug
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     * @throws \Exception
     */
    public function destroy($venue_slug,$id)
    {
        $venue = CampVenue::where('slug','=', $venue_slug)->pluck('id')->first();

        if (!$venue) {
            Alert::success('Sorry the camp venue is not available.', 'Success')->autoclose(1200);
            return back();
        }

        $residence = Residence::findOrFail($id);
        if($residence->delete()) {
            Alert::success('Residence Deleted', 'Success')->autoclose(1200);
            return back();
        }
        else{
            Alert::error('Sorry, Residence was not deleted!', 'Error')->autoclose(1200);
            return back();
        }

    }

    public function blocks($venue_slug,$id)
    {
        $residence = Residence::findOrFail($id);
        $blocks = Residence::find($id)->blocks;

        return view('admin.layout.backend.residence.blocks', compact('residence','blocks','venue_slug'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_Datatable()
    {
        return Datatables::eloquent(Residence::query())->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function blockstore(Request $request,$venue_slug)
    {
        // $this->validate($request,[
            // 'name'      =>  'required|alpha_dash',
            // 'rooms'     =>  'required|max:2000|min:1|numeric',
            // 'floors'    =>  'required|max:10|min:1|numeric',
            // 'gender'    =>  'max:1|alpha',
        // ]);
        // 
//        $rms=0;
//        for ($i=0; $i < $request->residence_blocks_now; $i++) {
//            $rms += $request->rooms[$i];
//        }
        
//        if ($rms > $request->residence_rooms_left) {
//            Alert::warning('The number of rooms ('.$rms.') assigned is more than rooms left ('.$request->residence_rooms_left.')', 'Warning')->persistent('Close');
//
//                return back();
//        }
        $venue = CampVenue::where('slug','=', $venue_slug)->pluck('id')->first();

        if (!$venue) {
            Alert::success('Sorry the camp venue is not available.', 'Success')->autoclose(1200);
            return back();
        }

        $count=1;
        for ($i=0; $i < $request->residence_blocks_now; $i++) { 
            $res = str_replace('_', ' ', $request->name[$i]);
            $block = new Block;
            $block->name = ucwords($res);
            $block->total_floors = $request->floors[$i];
            $block->residence_id = $request->residence_id;
            if ($request->gender == "F" or $request->gender == "M") {
                $block->gender = $request->gender;
            }else{
                $block->gender = ucfirst($request->gender[$count]);
            }
            $block->save();
            $count++;
        }
        Alert::success('Blocks Added', 'Success')->autoclose(1200);
            // return redirect('/residence');
        return redirect()->route('venue.residences',[$venue_slug]);
    }

    public function set_room_gender(Request $request)
    {
        $this->validate($request,[
            'residence'     =>      'required|numeric|min:1',
            'block'         =>      'nullable|numeric|min:1',
            'floor'         =>      'nullable|numeric|min:1',
            'room'          =>      'nullable|numeric|min:1',
            'gender'        =>      'required|alpha|min:1',
            'assign'        =>      'required|numeric|min:0',
        ]);


        $room = null;
        if (isset($request->room)){
            $room = Room::find($request->room);
            $room->gender = $request->gender;
            $room->assign = $request->assign;
            $room->save();
        }
        elseif (isset($request->floor)){
            $room = Room::where('residence_id','=', $request->residence)
                ->where('block_id','=', $request->block)
                ->where('floor_no','=', $request->floor)
                ->update(['gender'    => $request->gender,'assign'    => $request->assign]);
        }
        elseif (isset($request->block)){
            $block = Block::where('residence_id','=', $request->residence)
                ->where('id','=', $request->block)
                ->update(['gender'    => $request->gender]);
            $room = Room::where('residence_id','=', $request->residence)
                ->where('block_id','=', $request->block)
                ->update(['gender'    => $request->gender,'assign'    => $request->assign]);
        }
        elseif (isset($request->residence)){
            $room = Room::where('residence_id','=', $request->residence)
                ->update(['gender'    => $request->gender,'assign'    => $request->assign]);
        }
        if ($room){
            Alert::success('Rooms updated', 'Done')->persistent('Close');
        }

        return back();
    }

    public function get_all_blocks(Request $request)
    {
        $residence_id = $request->residence_id;
        $blocks = Block::where('residence_id', '=', $residence_id)->get();
        return response()->json($blocks);
    }

    public function get_all_rooms(Request $request)
    {
        $residence = $request->residence;
        $block = $request->block;
        $floor = $request->floor;

        $rooms = Room::where('residence_id', '=', $residence)
            ->where('block_id', '=', $block)
            ->where('floor_no', '=', $floor)
            ->get();

        return response()->json($rooms);
    }

    public function get_all_floors(Request $request)
    {
        $block = $request->block;
        $blocks = Block::find($block);
        return response()->json($blocks->total_floors);
    }
}
