<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LookupCode extends Model
{
    //
    protected $fillable=['LookupShortCode','LookUpName','ActiveFlag','CreateAppUserID','LastUpdateAppUserID'];

    protected $table = 'lookup_codes';

    public function lookup()
    {
        return $this->hasMany('App\Models\Lookup');//,'lookup_code_id','id'
    }

    public function scopeRetrieveLookups($query,$lookupid=0){
//        dd($query->get());
        return $query->find($lookupid)->lookup->where('ActiveFlag',true)->pluck('FullName','id');
    }
}

