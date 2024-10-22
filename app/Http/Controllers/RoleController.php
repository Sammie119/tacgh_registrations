<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request;

use Auth;
use App\Models\RoleMenu;

//Importing laravel-permission models
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Alert;
use Session;

class RoleController extends Controller {

    public function __construct() {
//        $this->middleware(['auth', 'isAdmin']);//isAdmin middleware lets only users with a //specific permission permission to access these resources
        $this->middleware(['auth','isAdmin']);//isAdmin middleware lets only users with a //specific permission permission to access these resources
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $roles = Role::all();//Get all roles
//        return view('admin.roles.index')->with('roles', $roles);
//        dd($roles);
        return view('admin.layout.backend.roles.index')->with('roles', $roles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $permissions = Permission::all();//Get all permissions
        return view('admin.layout.backend.roles.create', ['permissions'=>$permissions]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

//        dd($request);
        //Validate name and permissions field
        $this->validate($request, [
                'name'=>'required|unique:roles|max:40',
//                'permissions' =>'required',
            ]
        );

       // dd($nonmanagedmenu);

        $name = $request['name'];
//        $role = new Role();
//        $role->name = $name;
//
        //Create new role
        $newrole = Role::firstOrCreate(['name'=>$name]);

        //Get Assigned Permissions
        $permissions = $request['permissions'];
//        dd($permissions);
        //$role->save();

        //Loop thru selected permissions
        if(isset($permissions))
            {
                foreach ($permissions as $permission) {
                    $p = Permission::where('id', '=', $permission)->firstOrFail();

                    $newrole->givePermissionTo($p);
                }
            }
        //Get all non-managed menus
//        $nonmanagedmenu = MenuItem::where('managedmenu',0)->pluck('id')->get();
        $nonmanagedmenu = MenuItem::where('managedmenu',0)->get();
       // $addmenu = new RoleMenu();

       // Get AppUser id
        $userid = Auth::user()->id;
        //Loop through menu and assign to role
        foreach ($nonmanagedmenu as $menuitem){
            RoleMenu::firstOrCreate(['role_id'=>$newrole->id,'menu_item_id'=>$menuitem->id,'activeflag'=>1,'CreateAppUserID'=>$userid,'LastUpdateUserID'=>$userid]);
        }

        Alert::success('Role '. $name.' added successfully!', 'Success');
        return $this->index();
 //            ->with('flash_message','Role added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        return redirect('roles');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {

        $role = Role::findOrFail($id);
        $availablepermissions = Permission::pluck('name','id');

        $assignedpermissions = $role->permissions->pluck('name','id');

        $availablepermissions = $availablepermissions->diff($assignedpermissions)->all();

        return view('admin.layout.backend.roles.edit', compact('role', 'assignedpermissions','availablepermissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {

//dd($id);
        $role = Role::findOrFail($id);//Get role with the given id
        //Validate name and permission fields
        //dd($request);
        $this->validate($request, [
            'name'=>'required|max:25|unique:roles,name,'.$id,
            'assignedperms' =>'required',
        ]);
        //dd($request);
        $input = $request->except(['assignedperms','availperms']);

       // dd($input);

//        $permissions = implode(",",$request['assignedperms']);
        $permissions = $request['assignedperms'];
//        dd($permissions);
        $role->fill($input)->save();

        $p_all = Permission::all();//Get all permissions

        foreach ($p_all as $p) {
            $role->revokePermissionTo($p); //Remove all permissions associated with role
        }

        foreach ($permissions as $permission) {
            $p = Permission::where('id', '=', $permission)->firstOrFail(); //Get corresponding form //permission in db
//            print_r($p->name);
            $role->givePermissionTo($p);  //Assign permission to role
        }
//        dd($request);

        Alert::success('Role '. $role->name.' updated!', 'Success');
        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
//        $role->delete();

        notify()->flash('Role deleted!', 'success');
        return redirect()->route('roles.index');

    }
}