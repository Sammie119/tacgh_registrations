<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViewRecord extends Model
{
    //
    protected $table = 'vw_records';

    protected $columns = array('id','reg_id','surname','firstname','gender','dob','nationality','marital_status','local_assembly'
                                ,'chapter','carea','region','permanent_address',
                               'telephone','email','officechurch','profession','business_address','camper','AGD_Language','agd_leader',
                               'Applicable_Camp_Fee','Type_of_Special_Accomodation','camper_code','batch_no',
                                'ambassadorname','ambassadorphone'); // add all columns from you table
//(['id','reg_id','chapter','carea','region','ambassadorname','ambassadorphone'])
    public function scopeExclude($query,$value = array())
    {
        return $query->select( array_diff( $this->columns,(array) $value) );
    }
}
