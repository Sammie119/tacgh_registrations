<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    //
//    protected $guarded = ['id'];
    protected $fillable = ['camper_code','telephone','token'];
}
