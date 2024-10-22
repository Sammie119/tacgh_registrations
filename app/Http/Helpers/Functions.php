<?php
/**
 * Created by PhpStorm.
 * User: Sowee - Makedu
 * Date: 7/9/2018
 * Time: 8:22 AM
 */
use App\Http\Helpers\ToastNotification;
/**
 * @param ToastNotification $notification
 */
function notify(ToastNotification $notification){
    session()->push('notifications', $notification);
    return;
}

function flushNotifications(){
    session()->forget('notifications');
}

function getUniqueSlug($name)
{
    $sluged = str_slug($name);
//        $slug = str_slug(trim($sluged), '-');

    $existing = \App\Models\Residence::where('slug', '=', $sluged)->count();
    if ($existing){

        $existingCount = \App\Models\Residence::where('slug', 'like', $sluged.'-%')->count();

        if($existingCount)
        {
            $value = (integer)$existingCount + 1;
            return $sluged."-".$value;
        }else{
            return $sluged."-1";
        }

//
    }else{
        return $sluged;
    }

}