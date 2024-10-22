<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Contracts\UserResolver;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements AuditableContract,UserResolver
{
    use Notifiable;
    use HasRoles;
    use Auditable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['fullname', 'email', 'password','role_id'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    //Retrieve non-developer users
    public function scopeUsers($query){
        return $query->where('role_id','<>',9);
    }
    public static function resolveId()
    {
        return \Auth::check() ? \Auth::user()->getAuthIdentifier() : null;
    }
    protected $auditExclude = [
        'password',
    ];
//    public function transformAudit(array $data)
//    {
////        dd($data);
//        if (Arr::has($data, 'new_values.role_id')) {
//            $data['old_values']['role_name'] = Role::find($this->getOriginal('id'))->name;
//            $data['new_values']['role_name'] = Role::find($this->getAttribute('id'))->name;
//        }
//
//        return $data;
//    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function role(){
        return $this->belongsTo('Spatie\Permission\Models\Role');
    }

    public static function resolve()
    {
        return Auth::check() ? Auth::user() : null;
    }
}
