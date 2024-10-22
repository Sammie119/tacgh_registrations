<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class WebAppUser extends Model
{
    //
    use Notifiable;
    protected $table = 'web_app_users';

    protected $fillable = ['fullname','username','password','role_id','active_flag','create_app_user_id','update_app_user_id'];


    protected $hidden = ['password'];
}
