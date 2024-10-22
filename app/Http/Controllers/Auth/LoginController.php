<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\TrackVenue;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Alert;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    private $home_page_roles ;

    public function authenticated(Request $request , $user){
//        dd($user->role->name);
        $role = $user->role->name;
        $current_venue = TrackVenue::where('year','=', date('Y'))->pluck('camp_venue_id')->first();
        session(['camp_venue'=>$current_venue]);
        if($user->hasAnyRole($this->home_page_roles)){
            return redirect()->route('home') ;
        }elseif($user->role->name=='Registration Assistant'){
            return redirect()->route('camper') ;
        }
        elseif($user->role->name=='Allocation Officer' || $user->role->name=='Special Allocation Officers'){
            return redirect()->route('assign') ;
        }
        else{
            return redirect()->route('passwordreset') ;
        }
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->home_page_roles = ["SuperAdmin","Finance Officer","SysDeveloper"];
        $this->middleware('guest')->except('logout');
    }

    public function credentials(Request $request)
    {
//        dd($request);
        $credentials = $request->only($this->username(),'password');
//        dd($credentials);
        $credentials['active_flag'] = 1;
//        dd($credentials);
        return $credentials;
    }
    public function sendFailedLoginResponse(Request $request)
    {
        $errors = [$this->username() => trans('auth.failed')];
//        dd($errors);
        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }

        alert()->error("Login Failed","Your account doesn't exist or it's been blocked! Contact the administrator")->persistent('Close');
        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors($errors);
    }

    public function logout(Request $request) {
        Auth::logout();
        return redirect('/login');
    }
}
