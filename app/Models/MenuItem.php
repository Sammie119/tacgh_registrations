<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class MenuItem extends Model
{
//    protected $table = 'menu_items';

    protected $guarded = ['id'];
    public function parent() {
        return $this->hasOne('App\Models\MenuItem', 'id', 'parentmenuid');
    }

    public function children() {
        return $this->hasMany('App\Models\MenuItem', 'parentmenuid', 'id');
    }

    public static function tree($roleid=100) {
        //working menu
//        return MenuItem::whereIn('id',function($ugrole) use($roleid){ $ugrole->From('role_menu')->Where(['activeflag'=>1,'role_id'=>$roleid])->select('menu_item_id');})
//            ->where(['activeflag'=>1,'parentmenuid'=>null])
////            ->with([implode('.', array_fill(0, 4, 'children'))
//            ->with(array('children'=>function($child) use($roleid){
//                $child->whereIn('id',function($ugrole)use($roleid){ $ugrole->From('role_menu')->Where(['activeflag'=>1,'role_id'=>$roleid])->select('menu_item_id');});
//                }))->orderBy('menu_items.level','asc')->orderBy('rank','asc')->get();

        $nonmanaged = MenuItem::where(['activeflag'=>1,'parentmenuid'=>null,'managedmenu'=>0])->with(array('children'=>function($child) use($roleid) {
            $child->Where(['activeflag' => 1, 'managedmenu' => 0]);}))->get();
//
//            }));

        $managed = MenuItem::whereIn('id',function($ugrole) use($roleid){ $ugrole->From('role_menu')->Where(['activeflag'=>1,'role_id'=>$roleid])->select('menu_item_id');})
            ->where(['activeflag'=>1,'parentmenuid'=>null])
//            ->with([implode('.', array_fill(0, 4, 'children'))
            ->with(array('children'=>function($child) use($roleid){
                $child->whereIn('id',function($ugrole)use($roleid){ $ugrole->From('role_menu')->Where(['activeflag'=>1,'role_id'=>$roleid])->select('menu_item_id');});
            }))->orderBy('level','asc')->orderBy('rank','asc')->get();

        return $nonmanaged->merge($managed)->sortBy('level')->sortBy('rank');
//        $menus = $nonmanaged->merge($managed);
//        return $menus;

    }
}
