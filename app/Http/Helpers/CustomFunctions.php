<?php

use App\Models\Events;

if (!function_exists("get_current_event")) {
    function get_current_event()
    {
        return Events::where('activeflag', 1)->first();
    }
}

if(!function_exists("event_registration_code")){
    function event_registration_code ($input, $pad_len = 7, $prefix = null, $subfix = null) {
        if (is_string($prefix))
            return sprintf("%s%s", $prefix, str_pad($input, $pad_len, "0", STR_PAD_LEFT));

        return str_pad($input, $pad_len, "0", STR_PAD_LEFT);
    }
}