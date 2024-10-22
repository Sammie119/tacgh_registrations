<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

//Importing laravel-permission models
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
//        $user = User::all()->count();
//        if (!($user == 1)) {
//            if (!Auth::user()->hasPermissionTo('ManageUsers')) //If user does //not have this permission
//            {
//                abort('401');
//            }
//        }
//        if ($request->is('user*'))//If user visits user route
//        {
//            //Change permission_id to pick from database
//            $permittedroles = Role::whereIn('id',function($roleswithperm){$roleswithperm->From('role_has_permissions')->where('permission_id',4)->select('role_id');})->pluck('name')->toArray();
//
////            dd($permittedroles);
//            if (!Auth::user()->hasAnyRole($permittedroles))
////            if (!Auth::user()->hasAnyRole(str_replace('"', "'", $permittedroles)))
//            {
//                abort('401');
//            }
//            else {
//                return $next($request);
//            }
//        }

        if ($request->is('client*'))//If user visits client route
        {
            if (!Auth::user()->hasPermissionTo('ManageClients'))
            {
                abort('401');
            }
            else {
                return $next($request);
            }
        }
        if ($request->is('lookup*'))//If user visits lookup route
        {
            //Change permission_id to pick from database
            $permittedroles = Role::whereIn('id',function($roleswithperm){$roleswithperm->From('role_has_permissions')
                ->where('permission_id',2)->select('role_id');})->pluck('name')->toArray();

            if (!Auth::user()->hasAnyRole($permittedroles))
            {
                abort('401');
            }
            else {
                return $next($request);
            }
        }

        if ($request->is('permission*'))//If user visits permission route
        {
            $permittedroles = Role::whereIn('id',function($roleswithperm){$roleswithperm->From('role_has_permissions')->where('permission_id',6)->select('role_id');})->pluck('name')->toArray();
            if (!Auth::user()->hasAnyRole($permittedroles))
            {
                abort('401');
            }
            else {
                return $next($request);
            }
        }

        if ($request->is('roles*'))//If user visits roles route
        {
            $permittedroles = Role::whereIn('id',function($roleswithperm){$roleswithperm->From('role_has_permissions')
                ->where('permission_id',5)->select('role_id');})->pluck('name')->toArray();

            if (!Auth::user()->hasAnyRole($permittedroles))
            {
                abort('401');
            }
            else {
                return $next($request);
            }
        }

        if($request->is('audittrail')){
//            dd('Audit trail');
            if(!Auth::user()->hasRole('SysDeveloper')){
                abort('401');
            }
        }

        if($request->is('assignmenu')){
            $permittedroles = Role::whereIn('id',function($roleswithperm){$roleswithperm->From('role_has_permissions')
                ->where('permission_id',12)->select('role_id');})->pluck('name')->toArray();
            if (!Auth::user()->hasAnyRole($permittedroles)){
                abort('401');
            }
        }
        if($request->is('assign-room')){
            if(!Auth::user()->hasAnyRole(['SysDeveloper','SuperAdmin','Allocation Officer','Special Allocation Officers'])){
                abort('401');
            }
        }

        if ($request->is('registrant*'))//If user visits roles route
        {
            if (!Auth::user()->hasAnyRole(['SysDeveloper','SuperAdmin','Finance Officer']))
            {
                abort('401');
            }
            else {
                return $next($request);
            }
        }
        return $next($request);
    }
}
