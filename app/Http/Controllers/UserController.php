<?php

namespace App\Http\Controllers;

//use App\Client;
use App\Models\MobAppUsers;
use App\Models\WebAppUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Alert;

use App\Models\User;
//use Auth;


//Importing laravel-permission models

use Spatie\Permission\Models\Role;

//use Spatie\Permission\Models\Permission;

//Enables us to output flash messaging
//use Session;

class UserController extends Controller {

    public function __construct() {
        $this->middleware(['auth','isAdmin']); //isAdmin middleware lets only users with a //specific permission permission to access these resources
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //Get all users and pass it to the view
        if(Auth::user()->role->id != 9){
            $users = User::users()->get();
        }
        else{
            $users = User::get();
        }
        return view('admin.layout.backend.user.index')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //Get all roles and pass it to the view
//        $roles = Role::pluck('name','id');

        //Get appropriate roles and pass it to the view
        if(Auth::user()->role->id != 9){
            $roles = Role::where('id','<>',9)->pluck('name','id');
        }
        else{
            $roles = Role::pluck('name','id');
        }

//        return view('admin.user.create', ['roles'=>$roles]);
        return view('admin.layout.backend.user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //Validate name, email and password fields
        $this->validate($request, [
            'fullname'=>'required|max:120',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6|confirmed',
//            'client_id'=>'required|integer',
            'role_id'=>'required|integer'
        ]);

        //dd($request);
//        $user = User::create($request->only('email', 'fullname', 'password','client_id','role_id')); //Retrieving only the email and password data
        $user = User::create([
            'fullname' => $request['fullname'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
//            'client_id'=>$request['client_id'],
            'role_id'=>$request['role_id'] ]);
//        $roles = $request['role_id']; //Retrieving the roles field

        //Checking if a role was selected

        $role_r = Role::where('id', '=', $request['role_id'])->firstOrFail();
        $user->assignRole($role_r); //Assigning role to user


        //Redirect to the users.index view and display message
        alert()->success('User '. $user->fullname.' added!', 'Success');
        return $this->index();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        return redirect('users');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $user = User::findOrFail($id); //Get user with specified id

        if(Auth::user()->role->id != 9){
            $roles = Role::where('id','<>',9)->pluck('name','id');
        }
        else{
            $roles = Role::pluck('name','id');
        }
//        $roles = Role::pluck('name','id');

        return view('admin.layout.backend.user.edit', compact('user', 'roles')); //pass user and roles data to view

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $user = User::findOrFail($id); //Get role specified by id

//        dd($request);
        //Validate name, email and password fields
        $this->validate($request, [
            'fullname'=>'required|max:120',
            'email'=>'required|email|unique:users,email,'.$id,
            'password'=>'required_with:changepassword,on|min:6|confirmed'
        ]);

//        $request['init_pwd_changed'] = 0;
        if($request['changepassword']){
//            dd($request['changepassword']);
//            $request['password'] = bcrypt($request['password']);
//            $input = $request->only(['fullname', 'email', 'password','role_id','init_pwd_changed']); //Retreive the name, email and password fields
//            dd($input);
//            $user->fullname = $request['fullname'];
//            $user->email = $request['email'];
            $user->password = bcrypt($request['password']);
//            $user->role_id = $request['role_id'];
            $user->init_pwd_changed = 0;
        }
//        else{
//            $input = $request->only(['fullname', 'email','role_id']); //Retreive the name, email and password fields
//        }

        $user->fullname = $request['fullname'];
        $user->email = $request['email'];
//        $user->password = $request['password'];
        $user->role_id = $request['role_id'];
//        dd($input);
//        $roles = $request['roles']; //Retreive all roles
        $roles = $request['role_id']; //Retreive all roles
//        dd($input);
        $user->save();

        if (isset($roles)) {
            $user->roles()->sync($roles);  //If one or more role is selected associate user to roles
        }
        else {
            $user->roles()->detach(); //If no role is selected remove exisiting role associated to a user
        }

        alert()->success('User '. $user->fullname.' updated!', 'Success');
        return redirect()->route('user.index');
//        return $this->index();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //Find a user with a given id and delete
        $user = User::findOrFail($id);
        $user->update_app_user_id = Auth::user()->id;
        $user->active_flag = 0;
        $user->save();
//        $user->delete();

        alert()->success('Success','User blocked successfully!');
        return  redirect('user');
    }
    public function unblock(Request $request) {

        if(key_exists("uid",$request->all())){
//            dd($request->all());
            //Find a user with a given id and delete
            $userid = $request["uid"];

            $user = User::findOrFail($userid);
            $user->update_app_user_id = Auth::user()->id;
            $user->active_flag = 1;
            $user->save();
            alert()->success("Success",'User unblocked successfully!');
            return  redirect('user');
        }
        else{
            alert()->warning("Sorry","Id of user not passed");
            return  redirect()->back();
        }

    }

    public function mobappuser(){
        //get all mobile app users
        $mobusers = MobAppUsers::all();
        return view('admin.layout.backend.mobappuser.index',compact('mobusers'));
    }

    public function mobappuseradd(){
//        dd('hello');
        if(Auth::user()->role->id != 9){
            $roles = Role::where('id','<>',9)->pluck('name','id');
        }
        else{
            $roles = Role::pluck('name','id');
        }

//        return view('admin.user.create', ['roles'=>$roles]);
        return view('admin.layout.backend.mobappuser.create', compact('roles'));
    }

    public function mobappuserstore(Request $request) {
//        dd($request);
        //Validate name, username and password fields
        $this->validate($request, [
            'fullname'=>'required|max:120',
            'username'=>'required|unique:mob_app_users',
            'password'=>'required|min:6|confirmed',
//            'role_id'=>'required|integer'
        ]);
//        dd("passed validation");
        $mobuser = MobAppUsers::firstOrCreate([
            'fullname'=>$request['fullname'],
            'username'=>$request['username'],
            'password'=>bcrypt($request['password']),
            'role_id'=>$request['role_id'],
            'active_flag'=>1,
            'create_app_user_id'=>Auth()->user()->id,
            'update_app_user_id'=>Auth()->user()->id,
        ]);

        $webuser = WebAppUser::firstOrCreate([
            'fullname'=>$request['fullname'],
            'username'=>$request['username'],
            'password'=>$request['password'],
            'role_id'=>$request['role_id'],
            'active_flag'=>1,
            'create_app_user_id'=>Auth()->user()->id,
            'update_app_user_id'=>Auth()->user()->id,
        ]);
        alert()->success('Mobile app user added successfully!', 'Success')->persistent('Close');
        return redirect('mobappuser');
    }

    public function mobappuserdestroy($id) {

//        dd($id);
        //Find a user with a given id and delete
        $user = MobAppUsers::findOrFail($id);
        $user->update_app_user_id = Auth::user()->id;
        $user->active_flag = 10;
        $user->save();

//        dd('we did it');
        alert()->success('Mobile App User blocked successfully!', 'Success');
        return  redirect('mobappuser');
//        return redirect()->back();
    }

    public function mobappuserunblock() {


        //Find a user with a given id and delete
        $userid = Input::get('uid', 1005);

//        dd("hello user ".$userid);
        $user = MobAppUsers::findOrFail($userid);
        $user->update_app_user_id = Auth::user()->id;
        $user->active_flag = 1;
        $user->save();

//        dd('we unblocked it');
        alert()->success('Mobile App User unblocked successfully!', 'Success');
//        return  redirect()->back();
        return  redirect('mobappuser');
    }
}