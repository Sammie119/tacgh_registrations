<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebMealsServer extends Model
{

    public function centre()
    {
        return $this->belongsTo('App\Models\Centre', 'centre_id')->withDefault(function($model){
            $model->centre_id = "";//Default value for centre not stated
        });
    }
    protected $table ='meals_servers';
    protected $fillable =['name','centre_id','code'];
}
