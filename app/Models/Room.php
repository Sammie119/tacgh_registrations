<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    /**
     * Get the blocks for the residence.
     */
    public function residence()
    {
        return $this->belongsTo('App\Models\Residence');
    }

    /**
     * Get the rooms for the block.
     */
    public function block()
    {
        return $this->belongsTo('App\Models\Block');
    }

    /**
     * Get the campers for the registrants.
     */
    public function campers()
    {
        return $this->hasMany('App\Models\Registrant');
    }

    // public function scopeRetrieveRoomLabel($query){
    //     return $query->;
    // }
}
