<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class MobAppUsers extends Authenticatable implements JWTSubject
{
    //
    use Notifiable;
    protected $table = 'mob_app_users';

    protected $fillable = ['fullname','username','password','role_id','active_flag','create_app_user_id','update_app_user_id'];


    protected $hidden = ['password'];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
}
