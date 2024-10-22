<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OnlinePayment extends Model
{
    //
    protected $table = 'online_payments';
    protected $guarded = ['id'];

    public function camper(){
        return $this->belongsTo('App\Models\Registrant','reg_id','reg_id')->withDefault(function($model){
            $model->reg_id = "";
        });
    }

}
