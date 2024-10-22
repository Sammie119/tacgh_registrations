<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

//Importing laravel-permission models
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Session;
use Alert;

class PermissionController extends Controller {

    public function __construct() {
//        $this->middleware(['auth', 'isAdmin']); //isAdmin middleware lets only users with a //specific permission permission to access these resources
        $this->middleware(['auth','isAdmin']); //isAdmin middleware lets only users with a //specific permission permission to access these resources
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $permissions = Permission::paginate(5); //Get all permissions
//dd($permissions);
        return view('admin.layout.backend.permission.index')->with('permissions', $permissions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $roles = Role::get(); //Get all roles

        return view('admin.layout.backend.permission.create')->with('roles', $roles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->validate($request, [
            'name'=>'required|max:40',
        ]);

        $name = $request['name'];
        $permission = new Permission();
        $permission->name = $name;

        $roles = $request['roles'];

        $permission->save();

        if (!empty($request['roles'])) { //If one or more role is selected
            foreach ($roles as $role) {
                $r = Role::where('id', '=', $role)->firstOrFail(); //Match input role to db record

                $permission = Permission::where('name', '=', $name)->first(); //Match input //permission to db record
                $r->givePermissionTo($permission);
            }
        }

        Alert::success('Permission added successfully!','Success');
        return redirect()->back();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        return redirect('permissions');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $permission = Permission::findOrFail($id);
        $roles = Role::get(); //Get all roles

        return view('admin.layout.backend.permission.edit', compact('permission','roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $permission = Permission::findOrFail($id);
        $this->validate($request, [
            'name'=>'required|max:40',
        ]);
        $input = $request->except('roles');
//        dd($input);
        $permission->fill($input)->save();


//        $name = $request['name'];
//        $permission = new Permission();
//        $permission->name = $name;

        $checkedroles = collect($request['roles']);
//        dd($checkedroles);


        $roles = collect(Role::all()->pluck('id'));//Get all roles
//        dd($roles);
        $diffroles = $roles->diff($checkedroles);
//        dd($diffroles->all());
//        $permission->save();

        if (!empty($diffroles)) { //If one or more role is selected
            foreach ($diffroles->all() as $role) {
                $r = Role::where('id', '=', $role)->firstOrFail(); //Match input role to db record
                $r->revokePermissionTo($permission);
            }
//            dd('helow');
        }
        if(!empty($checkedroles)){
            foreach ($checkedroles as $role){
                $r = Role::where('id', '=', $role)->firstOrFail(); //Match input role to db record
                if(!$r->hasPermissionTo($permission))
                $r->givePermissionTo($permission);
            }
        }

//        Alert::success('Permission added successfully!','Success');
//        return redirect()->back();

        Alert::success('Permission updated successfully!','Success');
        return $this->index();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $permission = Permission::findOrFail($id);

        //Make it impossible to delete this specific permission
        if ($permission->name == "Administer roles & permissions") {
            return redirect()->route('permission')
                ->with('flash_message',
                    'Cannot delete this Permission!');
        }

//        $permission->delete();

        return redirect()->back()->with('flash_message','Permission deleted!');

    }
}
