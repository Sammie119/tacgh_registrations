<?php

use App\Models\CampFee;
use App\Models\LookupCode;
use App\Models\Registrant;
use Illuminate\Database\Eloquent\Collection;

/**
 * Created by PhpStorm.
 * User: Sowee - Makedu
 * Date: 6/2/2018
 * Time: 7:15 PM
 */
if(!function_exists("isChild")) {
    function isChild($campercat_id)
    {
        if ($campercat_id == 28) {
            return true;
        } else {
            return false;
        }
    }
}
if(!function_exists("camper_amount")) {
    function camper_amount($camperfee_id)
    {
        $fee = CampFee::find($camperfee_id);
        return $fee->fee_amount;
    }
}

if(!function_exists("get_camper_type")) {
    function get_camper_type($camper_type_id = null)
    {
        return LookupCode::retrieveLookups(6);
//        dd($types);
//        if ($camper_type_id != null) {
//            if ($camper_type_id > 28 || $camper_type_id < 25) {
//                $camper_type_id = 26;
//            }
//        }
//        $type = [
//            '25' => 'Senior',
//            '26' => 'Regular',
////         '27'=>'Teen',
//            '28' => 'Child',
//            '124' => 'Senior Teen'
//        ];
//        if ($camper_type_id == null) {
//            return $type;
//        } else {
//            return $type[$camper_type_id];
//        }
    }
}

if(!function_exists("getCamperApplicableFees")) {
    function getCamperApplicableFees($camperTypeId)
    {
        return CampFee::where(["camper_type_id" => $camperTypeId])->get()->map(function ($fee) {
            return ["id" => $fee->id, "name" => $fee->fee_tag . " - GHC " . $fee->fee_amount];
        });;
    }
}

if(!function_exists("getChildrenInRoom")) {
    function getChildrenInRoom($room_id)
    {
        $children = Registrant::where('room_id', '=', $room_id)
            ->where('campercat_id', '=', 28)
            ->get();
        return $children->count();
    }
}
if(!function_exists("isMoreChildAllowedInRoom")) {
    function isMoreChildAllowedInRoom($room_id)
    {
        $room = \App\Models\Room::find($room_id);
        $limit = floor($room->total_occupants / 2);
        $childrenNumberInRoom = getChildrenInRoom($room_id);

        if ($childrenNumberInRoom < $limit) {
            return false;
        } else {
            return true;
        }
    }
}

if(!function_exists("assignAGDNo")) {
    function assignAGDNo($registrant_id)
    {
        $registrant = \App\Registrant::where('reg_id', '=', $registrant_id)->first();

        if ($registrant->agdlang_id == null) {
            $agdlang_id = 29;
        } else {
            $agdlang_id = $registrant->agdlang_id;
        }

        $code = DB::table('agd_member_list')->where('agdlang_id', '=', $agdlang_id)
            ->where('total_left', '>', 0)->pluck('code')->first();
        if (is_Null($code)) {
            $code = create_agd($agdlang_id);
        }
        $registrant->agd_no = $code;
        $registrant->save();
        return $code;
    }
}

if(!function_exists("create_agd")) {
    function create_agd($agdlang_id)
    {
        $get_setup = \App\AgdSetting::where('agdlang_id', '=', $agdlang_id)->first();
        $count = DB::table('agd_group')->where('language_id', '=', $agdlang_id)->count();
        $count += 1;
        $code = $get_setup->code . " " . $count;
        DB::table('agd_group')->insert([
            'language_id' => $get_setup->agdlang_id,
            'total_no' => $get_setup->size,
            'code' => $code
        ]);
        return $code;
    }
}

if(!function_exists("random_code")){
    function random_code(){
        $string = str_random(30);
        return $string;
    }
}

if(!function_exists("get_validation_errors")){
    function get_validation_errors($errors)
    {
        $values = [];
        foreach ($errors as $errorArray) {
            $values = array_merge($values, array_values($errorArray));
        }

        return implode(",<br/>",$values);
    }
}

if(!function_exists("findItemsInCollection")){
    function findItemsInCollection(Collection $collection, int $id, string $feeDescription): Collection
    {
        $feeDescriptionParts = array_map('trim',explode('-', $feeDescription));

//        dd($collection->where("camper_type_id",$id)
////            ->where("fee_tag","Special Accommodation (1 in a room)")
//            ->toArray());

        return $collection->where("camper_type_id",$id)->filter(function ($item) use ($id, $feeDescriptionParts) {
            $itemDescriptionParts = array_map('trim',explode('-', $item['fee_description']));

//            dd($itemDescriptionParts);

            return $item['camper_type_id'] == $id
                &&
                end($feeDescriptionParts) == end($itemDescriptionParts)
//                && reset($feeDescriptionParts) == reset($itemDescriptionParts)
                ;
        });
    }
}
