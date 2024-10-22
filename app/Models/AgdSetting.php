<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgdSetting extends Model
{
    //
    protected $table = 'agd_settings';
    protected $fillable = ['code','size','name','agdlang_id'];
}
