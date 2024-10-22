<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lookup extends Model
{

    protected $fillable=['FullName','ShortName','UseShortName','lookup_code_id','ActiveFlag','Toggled','CreateAppUserID','LastUpdateAppUserID'];


    public function lookupcode()
    {
        return $this->belongsTo('App\Models\LookupCode');
    }


//    public function registrants(){
//        return $this->hasMany('App\Registrant');
//    }

}
