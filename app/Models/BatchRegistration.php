<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BatchRegistration extends Model
{
    //
//    use \Laravel\Passport\HasApiTokens;
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }
    protected $guarded = ['id'];

    protected $table = 'registrants';

    public function campfee(){
        return $this->hasOne(Lookup::class,'id','campfee_id')->withDefault(function($model){
            $model->campfee_id= "";//Default value for campfee_id not stated
        });
    }


    public static function batchnumber($size = 10){
        $chars = array(0,1,2,3,4,5,6,7,8,9,'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
        $serial = '';
        $max = count($chars)-1;
        for($i=0;$i<$size;$i++){
            $serial .= (!($i % 5) && $i ? '-' : '').$chars[rand(0, $max)];
        }
        return $serial;
    }

    public static function token($size = 10){
        $divisor = 2;
//        $chars = array(0,1,2,3,4,5,6,7,8,9,'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
        $chars = array(0,1,2,3,4,5,6,7,8,9);
        $serial = '';
        $max = count($chars)-1;

        if((($size % 2) == 1) || ($size <= 4)) {
            $divisor = 1;
        }
        for($i=0;$i<$size;$i++){
            $serial .= (!($i % ($size/$divisor)) && $i ? '-' : '').$chars[rand(0, $max)];
        }

        return $serial;
    }
}
