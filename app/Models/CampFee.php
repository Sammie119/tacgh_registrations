<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CampFee extends Model
{
    use HasFactory;

    protected $guarded = ["id"];

    protected $appends = ["status","fee_description"];


    public function camperType(): BelongsTo
    {
        return $this->belongsTo(Lookup::class,"camper_type_id","id");
    }

    public function getStatusAttribute(){
        switch ($this->active_flag){
            case 0:
                return "Inactive";
            case 1:
                return "Active";
            default:
                return "Unknown";
        }
    }

    public function getFeeDescriptionAttribute(){
        return $this->fee_tag." - ".$this->fee_amount;
    }
}
