<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    /**
     * Get the blocks for the residence.
     */
    public function residence()
    {
        return $this->belongsTo('App\Models\Residence');
    }

    /**
     * Get the rooms for the rooms.
     */
    public function rooms()
    {
        return $this->hasMany('App\Models\Room');
    }

    /**
     * Get the campers for the registrants.
     */
    public function campers()
    {
        return $this->hasMany('App\Models\Registrant');
    }
}
