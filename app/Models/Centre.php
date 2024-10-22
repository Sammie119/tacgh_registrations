<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Centre extends Model
{
    //
    protected $fillable = ['name'];

    public function officials()
    {
        return $this->hasMany('App\Models\MealsServer');
    }
}
