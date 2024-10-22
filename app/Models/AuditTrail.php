<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class AuditTrail extends Model implements AuditableContract
{
    Use Auditable;
    //
    protected $table="audits";


    public function user(){
        return $this->belongsTo('App\Models\User','create_app_userid')->withDefault(function($model){
            $model->create_app_userid = "";//Default value for area not stated
        });
    }

}
