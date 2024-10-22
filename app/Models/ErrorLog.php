<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ErrorLog extends Model
{
    //

    protected $guarded = ['id'];

    protected $table = 'error_log';

    public static function insertError($source, $message){
//        dd($source);
      $model =   static::query()->create([
            'error_source'=>$source,
            'error_message'=>$message
        ]);
     return $model;
//        $model = static::query()->create($attributes);
    }
}
