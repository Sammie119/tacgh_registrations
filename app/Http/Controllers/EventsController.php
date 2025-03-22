<?php

namespace App\Http\Controllers;

use App\Models\Events;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['events'] = Events::orderByDesc('id')->get();
        return view('admin.layout.backend.events.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.layout.backend.events.create');
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
            'name'=>'required',
            'description' =>'required',
            'code_prefix' =>'required',
            'start_date' =>'required',
            'end_date' =>'required',
            'isPaymentRequired' => 'required',
            'activeflag' => 'required'
        ]);

        $request['CreateAppUserID']=\Auth()->user()->id;
        $request['LastUpdateAppUserID']=\Auth()->user()->id;
//        dd($request->all());
        Events::firstOrCreate($request->except('_token'));
//        dd($request);

        Alert::success('Event added successfully!', 'Success');

        return redirect('events');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Events  $events
     * @return \Illuminate\Http\Response
     */
    public function edit($events)
    {
        $data['event'] = Events::find($events);
        return view('admin.layout.backend.events.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Events  $events
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $events)
    {
        $menu = Events::findOrFail($events);
        $request['LastUpdateAppUserID']=\Auth()->user()->id;
        $menu->update($request->except('_token'));
        Alert::success('Event updated successfully!', 'Success');
        return redirect('events');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Events  $events
     * @return \Illuminate\Http\Response
     */
    public function destroy($events)
    {
        $event = Events::find($events);
        if($event->activeflag >= 1){
            Alert::error('Event cannot be deleted!', 'Error');
            return redirect('events');
        }
        $event->delete();

        Alert::success('Event Deleted successfully!', 'Success');
        return redirect('events');
    }
}
