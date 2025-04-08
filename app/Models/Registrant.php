<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

//use App\Carbon;

class Registrant extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    protected $appends = ["online_payments","onsite_payments"];

    //Scoped methods
    public function scopeParticipants($query,$status){
        $event = get_current_event()->id;
        return $query->where(['confirmedpayment'=> $status, 'event_id' => $event])->with('gender','maritalstatus','campercat','campfee','specialaccom');
    }

    public function scopeChapterLeaders($query){
        return $query
            ->whereNotNull('batch_no')->whereNotNull('chapter')->whereNotNull('ambassadorphone')
            ->select('area_id','region_id','chapter','ambassadorname','ambassadorphone')
            ->groupBy('ambassadorphone')
            ->get();
    }

    public function scopePaid_applicants($query){
        $event = get_current_event()->id;
        return $query->where(['confirmedpayment' => 1, 'event_id' => $event]);
    }
    //Relationships
    //Lookup relationships
    public function gender(){
        return $this->hasOne('App\Models\Lookup','id','gender_id')->withDefault(function($model){
            $model->gender_id= "";//Default value for gender_id not stated
        });    }
    //Find out how to use one relationship for many columns
    public function yesno(){
        return $this->belongsTo('App\Models\Lookup','id','');
    }

    public function maritalstatus(){
        return $this->hasOne('App\Models\Lookup','id','maritalstatus_id')->withDefault(function($model){
            $model->maritalstatus_id = "";//Default value for maritalstatus not stated
        });
    }
    public function region(){
        return $this->hasOne('App\Models\Lookup','id','region_id')->withDefault(function($model){
            $model->region_id = "";//Default value for region not stated
        });
    }
    public function officechurch(){
        return $this->hasOne('App\Models\Lookup','id','officechurch_id')->withDefault(function($model){
            $model->officechurch_id= "";//Default value for officechurch not stated
        });
    }
    public function campercat(){
        return $this->hasOne('App\Models\Lookup','id','campercat_id')->withDefault(function($model){
            $model->campercat_id = "";//Default value for category not stated
        });
    }
    public function agdlang(){

        return $this->hasOne('App\Models\Lookup','id','agdlang_id')
            ->withDefault(function($model){
            $model->agdlang_id = "";//Default value for agdLeader not stated
        });
    }
    //yes or no option
    public function agdleader(){
        return $this->hasOne('App\Models\Lookup','id','agdleader_id')->withDefault(function($model){
            $model->agdleader_id = "";//Default value for agdLeader not stated
        });
    }
    public function foreigndelegate(){
        return $this->hasOne('App\Models\Lookup','id','foreigndel_id')->withDefault(function($model){
            $model->foreigndel_id = "";//Default value for foreigndelegate not stated
        });
    }
    public function campfee(){
        return $this->hasOne('App\Models\CampFee','id','campfee_id')->withDefault(function($model){
            $model->campfee_id= "";//Default value for campfee_id not stated
        });
    }
    public function specialaccom(){
        return $this->hasOne('App\Models\Lookup','id','specialaccom_id')->withDefault(function($model){
            $model->specialaccom_id = "";//Default value for area not stated
        });
    }
    public function area(){
        return $this->hasOne('App\Models\Lookup','id','area_id')->withDefault(function($model){
            $model->area_id = "";//Default value for area not stated
        });
    }

    public function batch(){
        return $this->hasOne(Batches::class,'id','batch_id')->withDefault(function($model){
            $model->batch_id = "";//Default value for area not stated
        });
    }

    public function materials()
    {
        return $this->hasMany(Registrantmaterial::class,'id','reg_id');
    }
    public function room()
    {
        return $this->belongsTo('App\Models\Room')->withDefault(function($model) {
            $model->room_id = "";
        });
    }
    public function payment(){
        return $this->hasOne('App\Models\Payment');
    }

    public function qrcode(){
        return $this->hasOne('App\Models\Qrcode','camper_id', 'reg_id');
    }

    public function onsitepayments(){
        return $this->hasMany('App\Models\Payment','registrant_id','reg_id')
            ;
    }
    public function onlinepayments(){
        return $this->hasMany('App\Models\OnlinePayment','reg_id','registrant_id')
            ->where("payment_status","=",1)
//            ->withDefault(function($model){
//            $model->reg_id = "";
//        })
            ;
    }

    public function counselingArea(){
        return $this->hasOne(Lookup::class,"id","area_of_counseling");
    }

    public function getDobAttribute($date)
    {
        return date_diff(date_create($date), date_create('now'))->y;
//        return Carbon::parse($date)->diffInYears(Carbon::now());
    }

    public function getOnlinePaymentsAttribute(){
        return $this->onlinepayments()->sum("amount_paid");
    }
    public function getOnsitePaymentsAttribute(){
        return $this->onsitepayments()->sum("amount_paid");
    }

//    public function getCounselingAreaAttribute($value){
//        return $this->counselingArea()->FullName;
//    }
}
