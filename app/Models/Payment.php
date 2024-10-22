<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Contracts\UserResolver;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class Payment extends Authenticatable implements AuditableContract,UserResolver
{
    use Notifiable;
    use HasRoles;
    use Auditable;
    //
    protected $guarded = ['id'];

    public function scopePayments($query){
        return $query->with(['user','batch'=>function($q){
            $q->whereNotNull('chapter')->first();
        },'registrant']);
    }

//    public function registrant(){
//        return $this->belongsTo('App\Registrant')->withDefault(function($model){
//            $model->batch_no = "";
//        });
//    }

//    public function camper(){
//        return $this->belongsTo('\App\Registrant','reg_id','reg_id')->withDefault(function($model){
//            $model->reg_id = "";
//        });
//    }

    public function user(){
        return $this->belongsTo('App\Models\User','create_app_user_id');
    }

    public function batch(){
        return $this->belongsTo('App\Models\Batches','registrant_id','batch_no')->withDefault(function($model) {
            $model->registrant_id = "";
        });
    }

    public function registrant(){
        return $this->belongsTo('App\Models\Registrant','registrant_id','reg_id')->withDefault(function($model) {
            $model->registrant_id = "";
        });
    }

    public static function resolveId()
    {
        return \Auth::check() ? \Auth::user()->getAuthIdentifier() : null;
    }

    public function transformAudit(array $data): array
    {
        if (Arr::has($data, 'new_values.role_id')) {
            $data['old_values']['role_name'] = Role::find($this->getOriginal('role_id'))->name;
            $data['new_values']['role_name'] = Role::find($this->getAttribute('role_id'))->name;
        }
        return $data;
    }

    public static function resolve()
    {
        return Auth::check() ? Auth::user() : null;
    }
}
