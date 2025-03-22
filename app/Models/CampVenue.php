<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CampVenue extends Model
{
    //

    protected $fillable = [
        'name','location','region_id','slug','current_camp'
    ];

    protected $hidden = ['created_at','updated_at'];

    public function region(){
        return $this->hasOne('App\Models\Lookup','id','region_id')->withDefault(function($model){
            $model->region_id = "";//Default value for region not stated
        });
    }

    public function setSlugAttribute($name)
    {
        $this->attributes['slug'] = Str::slug($name);
    }

    public function residences()
    {
        return $this->hasMany('App\Models\Residence');
    }
}
