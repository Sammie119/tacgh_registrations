<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    //
    protected $guarded=['id'];

    protected $dates = ['dob'];

    protected $fillable = ['surname','firstname','gender_id','dob','nationality','foreigndel_id','maritalstatus_id','chapter',
        'localassembly','denomination','area_id','region_id','permaddress','telephone','email','officeaposa',
        'officechurch_id','profession','businessaddress','studentaddress','campercat_id','agdlang_id','agdleader_id','ambassadorname',
        'ambassadorphone','campfee_id','specialaccom_id','disclaimer_id','reg_id'];

    //Lookup relationships
    public function gender(){
//        return $this->belongsTo('App\Lookup','id','gender');
        return $this->hasOne('App\Lookup','id','gender_id')->withDefault(function($model){
            $model->gender_id= "";//Default value for gender_id not stated
        });    }
    //Find out how to use one relationship for many columns
    public function yesno(){
        return $this->belongsTo('App\Lookup','id','');
    }

    public function maritalstatus(){
        return $this->hasOne('App\Lookup','id','maritalstatus_id')->withDefault(function($model){
            $model->maritalstatus_id = "";//Default value for maritalstatus not stated
        });
    }
    public function region(){
        return $this->hasOne('App\Lookup','id','region_id')->withDefault(function($model){
            $model->region_id = "";//Default value for region not stated
        });
    }
    public function officechurch(){
        return $this->hasOne('App\Lookup','id','officechurch_id')->withDefault(function($model){
            $model->officechurch_id= "";//Default value for officechurch not stated
        });
    }
    public function campercat(){
        return $this->hasOne('App\Lookup','id','campercat_id')->withDefault(function($model){
            $model->campercat_id = "";//Default value for category not stated
        });
    }
    public function agdlang(){
        return $this->hasOne('App\Lookup','id','agdlang_id');
    }
    //yes or no option
    public function agdleader(){
        return $this->hasOne('App\Lookup','id','agdleader_id')->withDefault(function($model){
            $model->agdleader_id = "";//Default value for agdLeader not stated
        });
    }
    public function foreigndelegate(){
        return $this->hasOne('App\Lookup','id','foreigndel_id')->withDefault(function($model){
            $model->foreigndel_id = "";//Default value for foreigndelegate not stated
        });;
    }
    public function campfee(){
        return $this->hasOne('App\Lookup','id','campfee_id')->withDefault(function($model){
            $model->campfee_id= "";//Default value for campfee_id not stated
        });;
    }
    public function specialaccom(){
        return $this->hasOne('App\Lookup','id','specialaccom_id')->withDefault(function($model){
            $model->specialaccom_id = "";//Default value for area not stated
        });
    }
    public function area(){
        return $this->hasOne('App\Lookup','id','area_id')->withDefault(function($model){
            $model->area_id = "";//Default value for area not stated
        });
    }
}
