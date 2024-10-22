<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Qrcode extends Model
{
    //
    protected $table = 'qrcodes';

    protected $guarded = ['id'];
    public function camper()
    {
        $this->belongsTo('App\Registrant','camper_id','reg_id');
    }
    public function campercat()
    {
        return $this->hasOne('App\Lookup','id','camper_cat')->withDefault(function($model){
            $model->camper_cat= "";//Default value for officechurch not stated
        });
    }
}
