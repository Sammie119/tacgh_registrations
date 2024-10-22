<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registrantmaterial extends Model
{
    
    public function registrant()
    {
        return $this->belongsTo('App\Models\Registrant','id','reg_id');
    }

}
