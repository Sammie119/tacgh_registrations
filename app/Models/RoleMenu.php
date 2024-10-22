<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleMenu extends Model
{
    protected $table = 'role_menu';

    protected $guarded = ['id'];

//    public function menuitems(){
//        return $this->belongsToMany(MenuItem::class,"role_")
//    }
}
