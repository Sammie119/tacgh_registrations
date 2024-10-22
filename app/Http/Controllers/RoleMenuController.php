<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Models\RoleMenu;
use Illuminate\Http\Request;
//use Auth;
//Importing laravel-permission models
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class RoleMenuController extends Controller
{
    //

    public function __construct()
    {
//        $this->middleware(['auth','isAdmin']);
        $this->middleware(['auth','isAdmin']);
    }

    public function assignmenu(){

        if(Auth::user()->role->id != 9){
            $roles = Role::where('id','<>',9)->pluck('name','id');
        }
        else{
            $roles = Role::pluck('name','id');
        }


        $menus = MenuItem::where(['managedmenu'=>1,'activeflag'=>1])->pluck('menuname','id');

//        $assigendmenus = MenuItem::whereIn('id',function($menu){$menu->From('role_menu')->where(['role_id'=>Auth::user()->role_id,'activeflag'=>1])->select('menu_item_id');})->orderby('menuname','ASC')->pluck('menuname','id');
        $assigendmenus = MenuItem::whereIn('id',function($menu){$menu->From('role_menu')->where(['role_id'=>0,'activeflag'=>1])->select('menu_item_id');})->orderby('menuname','ASC')->pluck('menuname','id');
        $menus = $menus->diff($assigendmenus)->all();

        return view('admin.layout.backend.menu.assignmenu', compact('roles', 'assigendmenus','menus'));
    }

    public function rolemenu()
    {
        $roleid = $_GET['roleid'];//get LookUpCode id

        $menus = MenuItem::where(['managedmenu'=>1,'activeflag'=>1])->pluck('menuname','id');

        $assigendmenus = MenuItem::whereIn('id',function($menu) use($roleid){$menu->From('role_menu')->where(['role_id'=>$roleid,'activeflag'=>1])->select('menu_item_id');})->orderby('menuname','ASC')->pluck('menuname','id');

        $menus = $menus->diff($assigendmenus)->all();

        $result = array('menusavail' => $menus,'menusassigned'  => $assigendmenus);
        return $result;
    }


    public function mapmenu(Request $request) {

        //dd($request);

        //Validate name and permission fields
        //dd($request);
        $this->validate($request, [
            'role'=>'required',
        ]);
        $roleid = $request['role'];
//        $role = Role::findOrFail($request['role']);//Get role with the given id
        $allmenus = MenuItem::where(['activeflag'=>1,'managedmenu'=>1])->pluck('id');

        //$assigendmenusfromdb = MenuItem::whereIn('id',function($menu) use($roleid){$menu->From('role_menu')->where(['role_id'=>$roleid,'activeflag'=>1])->select('menu_item_id');})->orderby('menuname','ASC')->pluck('id');

       // print($assigendmenusfromdb);
        $assignedmenus = collect($request['assignedmenus']);

//        dd($assignedmenus);

//        $menudiffs = $allmenus->diff($assignedmenus)->all();


//        dd($menudiffs);
        //Delete unassigned menus from role_menu table
        RoleMenu::where('role_id',$roleid)->delete();


//        $ids_to_delete = array_map(function($item){
////            dd($item);
//            return $item['id']; }, $menudiffs);
//        dd($ids_to_delete);
//        RoleMenu::whereIn('menu_item_id',[3,5,6,7,9,12,14,15,16])->where('role_id',$roleid)->delete();

        foreach ($assignedmenus as $assignedmenu) {
            $addmenu = RoleMenu::firstOrCreate([
                'role_id'=>$roleid,
                'menu_item_id'=>$assignedmenu,
                'activeflag'=>1,
                'CreateAppUserID'=>Auth::user()->id,
                'LastUpdateUserID'=>Auth::user()->id
            ]);
            $addmenu->save();
        }

        alert()->success("Success","Roles mapped successfully!");
        return redirect()->back();
    }
}
