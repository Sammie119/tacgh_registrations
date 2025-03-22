<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Residence;
use App\Models\Room;
use App\Models\Block;
use App\Models\Registrant;
use App\Models\Lookup;
use DB;
//use Alert;
use RealRashid\SweetAlert\Facades\Alert;

class RoomController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $block = Block::findOrFail($id);
        $room_mates = Registrant::get();
        $legends = DB::table('colors')->get();

        return view('admin.layout.backend.rooms.index',compact('block','room_mates','legends'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $room = Room::findOrFail($id);
        return $room;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $room = Room::findOrFail($id);
        $special = Lookup::where(['lookup_code_id' => 9, 'ActiveFlag' => 1])->get();

        $room_mates = Registrant::where('room_id',$id)->get();
        return view('admin.layout.backend.rooms.edit',compact('room','room_mates','special'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);

        $this->validate($request,[
            'name' => 'nullable|max:20',
            'prefix' => 'nullable|max:5',
            'suffix' => 'nullable|max:5',
            'assign' => 'required|max:1',
            'accom' => 'numeric|min:44|max:47',
            'type' => 'required|alpha',
            'gender' => 'required',
            'beds' => 'required|max:5|min:1',
        ]);

        $room->name = ucwords($request->name);
        $room->prefix = $request->prefix;
        $room->suffix = $request->suffix;
        $room->assign = $request->assign;
        $room->special_acc = $request->accom;
        $room->type = $request->type;
        $room->gender = $request->gender;
        $room->total_occupants = $request->beds;
        if ($request->type == "Reserved" or $request->assign == 0) {
            $room->floor_color = "#BC2F31";
        }

        if ($room->save()) {
            $res_id = 'block/'.$room->block_id.'/rooms';
            Alert::success('Room updated')->autoclose(1200);
            return redirect("/$res_id");
        }else{
            Alert::success('Your data was not saved. Please try again')->autoclose(1200);
            return back();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        $block_id = $room->block_id;
        if($room->delete()) {
            Alert::success('Room Deleted', 'Success')->autoclose(1200);
            return redirect("/block/$block_id/rooms");
        }
        else{
            Alert::error('Sorry, Room was not deleted!', 'Error')->autoclose(1200);
            return $this->index();
        }
    }

    public function manualroomsetup(){
        $residence = Residence::all();
//        $blocks = Residence::find($id)->blocks;

        return view('admin.layout.backend.rooms.manualcreate', compact('residence'));
    }

    public function savemanualrooms(Request $request){
//        dd($request);
        $rooms = explode(',', preg_replace('/\s+/', ' ', $request['rooms']));
        foreach ($rooms as $room_no){
            if($request['floor']){
                $room = Room::firstOrCreate(['room_no'=>$room_no,'residence_id'=>$request['residence'],'block_id'=>$request['block'],'floor_no'=>$request['floor']]);
//                dd($room);
            }
            else{
                $room = Room::firstOrCreate(['room_no'=>$room_no,'residence_id'=>$request['residence'],'block_id'=>$request['block']]);
                $room->floor_no = 0;//set to one for residences without floors
//                dd($room);
            }
            if($request['specAccom']){
                $room->special_acc = 1;
            }
            $room->total_occupants=$request['numofoccupants'];
            $room->floor_color="#6AC1BF";
            $room->gender=$request['gender'];
            $room->special_acc=$request['special_accom'];
            $room->save();
        }

        Alert::success('Room added manually', 'Success')->autoclose(1200);
        return redirect('manualroomsetup');
//        dd($rooms);
    }

    public function getBody()
    {

        $title = "This Room";

        $view = view("admin.layout.backend.rooms.ajaxViewer",compact('title'))->render();

        return response()->json(['html'=>$view]);

    }

    public function clear_room(Request $request)
    {
        Registrant::where('room_id','=', $request->room_id)->update(['room_id'=>null]);
        Alert::success('Room cleared!', 'Success')->autoclose(1200);
        return back();
    }

    public function removeRoomMate($id)
    {
//        dd($id);
        Registrant::find($id)->update(['room_id'=>null]);
        Alert::success('Room Mate Removed!', 'Success')->autoclose(1200);
        return back();
    }

}
