<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\JwtAPI as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class MealsServer extends Authenticatable implements JWTSubject
{
    use Notifiable;
    //
    protected $table ='meals_servers';
    protected $fillable =['name','centre_id','code'];

    public function centre()
    {
        return $this->belongsTo('App\Models\Centre', 'centre_id')->withDefault(function($model){
            $model->centre_id = "";//Default value for centre not stated
        });
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

}
