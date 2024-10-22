<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request;
use Alert;

class MenuItemController extends Controller
{
    //
    public function __construct() {
        $this->middleware(['auth','isAdmin']); //isAdmin middleware lets only users with a //specific permission permission to access these resources
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $layout = "layouts.main";

    public function retrieveMenu()
    {
        $items = MenuItem::tree();
        $this->layout->content = View::make('layouts.issue.index')->withItems($items);
    }

    public function index()
    {
        //Get all menus and pass it to the view
//        $menus = MenuItem::where(['activeflag'=>1])->orderBy('menutype','asc')->orderBy('level','asc')->with('parent')->get();
        $menus = MenuItem::orderBy('menutype','asc')->orderBy('level','asc')->with('parent')->get();
//        dd($menus);
        return view('admin.layout.backend.menu.index',compact('menus'));
    }

    public function create()
    {
        //Get all menus and pass it to the view
        $menus = MenuItem::where(['parentmenuid'=>NULL])->pluck('menuname','id');
//        dd($menus);
        return view('admin.layout.backend.menu.create',compact('menus'));
    }

    public function store(Request $request)
    {
        //Get all menus and pass it to the view
        $this->validate($request, [
            'menuname'=>'required|min:3',
            'rank' =>'required',
            'nodeurl' =>'required',
            'managedmenu' =>'required',
            'menutype' =>'required',//required if othernationality is not selected
//            'othernationality'=>'required_without:nationality',//required if nationality is not selected
        ]);

        $request['level']=$request['menutype'];
        $request['pagetitle']=$request['menuname'];
        $request['activeflag']=1;
        $request['CreateAppUserID']=\Auth()->user()->id;
        $request['LastUpdateAppUserID']=\Auth()->user()->id;


        MenuItem::firstOrCreate($request->except('_token'));
//        dd($request);

            Alert::success('Menu added successfully!', 'Success');
            return redirect()->back();

    }
    public function edit($menuItem)
    {
        //
//        dd($menuItem);
        $menuitem = MenuItem::findOrFail($menuItem);
        $menus = MenuItem::where(['parentmenuid'=>NULL])->pluck('menuname','id');
//        dd($menuitem);
        return view('admin.layout.backend.menu.edit',compact('menus','menuitem'));
    }

    public function update(Request $request, $menuItem)
    {
        //
//        dd($request);
        $menu = MenuItem::findOrFail($menuItem);
        $request['LastUpdateAppUserID']=\Auth()->user()->id;
        $menu->update($request->except('_token'));
        Alert::success('Menu updated successfully!', 'Success');
        return redirect('menu');
    }

}

