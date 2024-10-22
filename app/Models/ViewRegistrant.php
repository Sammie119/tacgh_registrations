<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViewRegistrant extends Model
{
    //
    protected $table = 'vw_registrants';
//    protected $dates = ['dob','olddob'];

    protected $appends = ["camper_fee_desc"];

    public function getCamperFeeDescAttribute(){
        return $this->Applicable_Camp_Fee." - GHC ".$this->camper_fee;
    }
}
