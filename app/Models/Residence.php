<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Residence extends Model
{
    /**
     * Get the blocks for the residence.
     */
    public function blocks()
    {
        return $this->hasMany('App\Models\Block');
    }

    /**
     * Get the rooms for the residence.
     */
    public function rooms()
    {
        return $this->hasMany('App\Models\Room');
    }

    /**
     * Get the campers for the residence.
     */
    public function campers()
    {
        return $this->hasMany('App\Models\Registrant');
    }

    /**
     * Get the campers for the residence.
     */
    public function venue()
    {
        return $this->belongsTo(CampVenue::class,'camp_venue_id');
    }
}
