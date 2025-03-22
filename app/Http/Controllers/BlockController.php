<?php

namespace App\Http\Controllers;

use App\Models\CampVenue;
use Illuminate\Http\Request;
use App\Models\Residence;
use App\Models\Room;
use App\Models\Block;
//use Alert;
use Illuminate\Support\Facades\Input;
use RealRashid\SweetAlert\Facades\Alert;

class BlockController extends Controller
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
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        // dd($id);
        $residence = Residence::where('id',$id)->first();
        // return print_r($residence);
        return view('admin.layout.backend.blocks.create',compact('residence'));
    }

    public function get_blocks(Request $request)
    {
        $residence_id = $request->residence_id;
        $gender = $request->gender;
        $blocks = Block::where('residence_id', '=', $residence_id)
            ->where(function ($query) use ($gender) {
            $query->where('gender',$gender)
                ->orWhere('gender','A');
            })->get();
        return response()->json($blocks);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $block = Block::where('id','=',$id)->first();
        $residence = Residence::with(['venue:id,slug'])->find($block->residence_id);
        $venue_slug = $residence->venue->slug;
        return view('admin.layout.backend.blocks.edit',compact('block','venue_slug'));
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
        $block = Block::findOrFail($id);
//        dd($block->residence->venue()->slug);
        $venue_slug = $block->residence->venue()->first()->slug;

        $residenceId = $block->residence_id;

//        $residence_other_blocks_room_sum = Block::where('residence_id', $residenceId)
//                                            ->where('id','!=', $id)
//                                            ->sum('total_rooms');

//        $total_rooms_for_blocks = $residence_other_blocks_room_sum + $request->rooms;
//        $excess = $total_rooms_for_blocks - $block->residence->total_rooms;

//        if ($total_rooms_for_blocks > $block->residence->total_rooms) {
//            Alert::error('Total blocks rooms ('.$total_rooms_for_blocks.') has exceeded the total rooms assigned to the Residence ('.$block->residence->total_rooms.')<br>Exceeded number of rooms = '.$excess, 'Error')->persistent("OK");
//
//            return back()->withInput();
//        }

        $this->validate($request,[
            'name' => 'required',
//            'rooms' => 'required|min:1|max:2000',
            'floors' => 'required|min:1|max:20',
        ]);

        $block->name = ucwords($request->name);
        $block->total_floors = $request->floors;
//        $block->total_rooms = $request->rooms;
        $block->gender = $block->residence->gender;
        
        if ($block->save()) {
//            $rooms = Room::where('block_id', $id)->get();
//            if (($block->residence->gender == "F" or $block->residence->gender == "M") and $rooms) {
//
//                Room::where('block_id', $id)->update([
//                    'gender'    =>  $block->residence->gender
//                ]);
                
//                foreach ($rooms as $room) {
//                    $room->gender = $block->residence->gender;
//                    $room->save();
//                }
//            }
            $res_id = $block->residence->id;
            Alert::success('Update Successful')->autoclose(1200);
            return redirect()->route('residence.blocks',[$venue_slug,$res_id]);
        }else{
            Alert::error('Your data was not saved. Please try again')->autoclose(1200);
            return back()->withInput();
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function generate_rooms($id)
    {
        $block = Block::findOrFail($id);
        $venue_slug = $block->residence->venue()->first()->slug;

        return view('admin.layout.backend.blocks.generate_rooms',compact('block','venue_slug'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store_rooms(Request $request)
    {
//        return $request->all();
//        dd($request->all());
        $venue = CampVenue::where('slug','=', $request->venue_slug)->pluck('id')->first();
        $block = Block::findOrFail($request->block_id);

        if (!$venue || !$block) {
            Alert::success('Sorry the camp venue is not available.', 'Success')->autoclose(1200);
            return back();
        }
        $totalRooms = 0;
        for ($i=0; $i < $request->floors; $i++) {
                $a = 0;
                $a=$i+1;

            if ($request->end[$i] < $request->start[$i]) {
                Alert::error('On floor '.$a.', the Start room should be less than the End room.', 'Attention')->persistent("Ok");
                return back()->withInput();
            }

//            if ($request->floors > $a) {
//                if ($request->start[$a] < $request->end[$i]) {
//                    Alert::error('On floor '.($a+1).', the Start room should be more than the End room on floor '.$a, 'Attention')->persistent("Ok");
//                    return back()->withInput();
//                }
//            }
            $totalRooms += 1+($request->end[$i] - $request->start[$i]);
        }


//        if ($totalRooms > $request->rooms) {
//            $extra = $totalRooms - $request->rooms;
//            Alert::error('The total number of rooms entered is '.$extra.' more than total requested.', 'Attention')->persistent("Ok");
//                return back()->withInput();
//        }

        for ($i=0; $i < $request->floors; $i++) { 
            $room_no = $request->start[$i];
            while ($room_no <= $request->end[$i]) {
                $color = '#6AC1BF';
                // if ($request->floor_no[$i] % 2 == 0) {
                //     $color = '#85C3D4';
                // }
                $room = new Room;
                $room->room_no = $room_no;
                $room->floor_no = $request->floor_no[$i];
                $room->prefix = $request->prefix[$i];
                $room->suffix = $request->suffix[$i];
                $room->floor_color = $color;
                $room->total_occupants = $request->occupants[$i];
                $room->residence_id = $request->residence_id;
                $room->block_id = $request->block_id;
                if ($request->gender == "F" or $request->gender == "M") {
                    $room->gender = $request->gender;
                }
                $room->save();
                $room_no++;
            }
            
        }
            Alert::success('Update Successful')->autoclose(1200);
        return redirect()->route('residence.blocks', [$request->venue_slug,$request->residence_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_rooms($id)
    {
        $block = Block::findOrFail($id);
        $venue_slug = $block->residence->venue()->first()->slug;

        return view('admin.layout.backend.blocks.edit_rooms', compact('block','venue_slug'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_rooms(Request $request,$id)
    {
        $block = Block::findOrFail($id);

        // $totalRooms = 0;
        // for ($i=0; $i < $request->floors; $i++) { 
        //         $a = 0;
        //         $a=$i+1;
        //     if ($request->end[$i] < $request->start[$i]) {
        //         Alert::error('On floor '.$a.', the Start room should be less than the End room.', 'Attention')->autoclose(1200);
        //         return back();
        //     }
        // }
        
        $totalRooms = 0;
        for ($i=0; $i < $request->floors; $i++) { 
                $a = 0;
                $a=$i+1;

            if ($request->end[$i] < $request->start[$i]) {
                Alert::error('On floor '.$a.', the Start room should be less than the End room.', 'Attention')->persistent("Ok");
                return back()->withInput();
            }

//            if ($request->floors > $a) {
//                if ($request->start[$a] < $request->end[$i]) {
//                    Alert::error('On floor '.($a+1).', the Start room should be more than the End room on floor '.$a, 'Attention')->persistent("Ok");
//                    return back()->withInput();
//                }
//            }
            // if ($request->start[$a] < $request->end[$i]) {
            //     Alert::error('On floor '.($a+1).', the Start room should be more than the End room on floor '.$a, 'Attention')->persistent("Ok");
            //     return back()->withInput();
            // }
            $totalRooms += 1+($request->end[$i] - $request->start[$i]);
        }

//        if ($totalRooms > $request->rooms) {
//            $extra = $totalRooms - $request->rooms;
//            Alert::error('The total number of rooms entered is '.$extra.' more than total requested.', 'Attention')->persistent("Ok");
//                return back()->withInput();
//        }

        $rooms = json_decode($block->rooms->pluck('room_no'));

        for ($i=0; $i < $request->floors; $i++) { 
                $a = $i;
                $a++;
                
                 $room_no = $request->start[$i];
            while ($room_no <= $request->end[$i]) {
                    $color = '#6AC1BF';
                    // if ($request->floor_no[$i] % 2 == 0) {
                    //     $color = '#85C3D4';
                    // }

                if (in_array($room_no, $rooms)) {

                    $rm = $block->rooms->where('room_no',$room_no)->pluck('id')->first();

                    $room_info = Room::findOrFail($rm);
                    
                    $room_info->room_no = $room_no;
                    $room_info->floor_no = $request->floor_no[$i];
                    $room_info->prefix = $request->prefix[$i];
                    $room_info->suffix = $request->suffix[$i];
                    $room_info->floor_color = $color;
                    $room_info->total_occupants = $request->occupants[$i];
                    $room_info->residence_id = $request->residence_id;
                    $room_info->block_id = $request->block_id;
                    $room_info->save();
        
                }
                else{
               
                    $room_info = new Room;
                    $room_info->room_no = $room_no;
                    $room_info->floor_no = $request->floor_no[$i];
                    $room_info->prefix = $request->prefix[$i];
                    $room_info->suffix = $request->suffix[$i];
                    $room_info->floor_color = $color;
                    $room_info->total_occupants = $request->occupants[$i];
                    $room_info->residence_id = $request->residence_id;
                    $room_info->block_id = $request->block_id;
                    $room_info->save();
        
                }
                    $room_no++; 
            }
            
        }
            Alert::success('Update Successful')->autoclose(1200);
        return redirect()->route('residence.blocks', [$request->venue_slug,$request->residence_id]);
    }

    // function to check the rooms allocated to blocks in comparison to the residence
    public function residence_block_room_check($blockId)
    {
        $block = Block::findOrFail($blockId);
        $residenceId = $block->residence_id;

        $residence_blocks_room_sum = Block::where('residence_id', $residenceId)->sum('total_rooms');

        if ($residence_blocks_room_sum < $block->residence->total_rooms) {
            return false;
        }
        else{
            return true;
        }
    }
}
