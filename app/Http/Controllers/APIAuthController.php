<?php

namespace App\Http\Controllers;

use App\Models\MealsServer;
use App\Models\MobAppUsers;
use Exception;
use Illuminate\Http\Request;
use App\Models\User;
use JWTAuth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use DB,Mail, Illuminate\Support\Facades\Password;

class APIAuthController extends Controller
{

    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('jwt.verify', ['except' => ['login','authenticate']]);
    }

    protected $redirectTo = '/apilogin';
    protected $guard = 'server';
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function authenticate(Request $request)
    {
//        return $request;
        $credentials = $request->only('username', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));
    }


    public function login(Request $request)
    {
//        $credentials = request()->only('username', 'password');
//
//        $auth = MobAppUsers::where(['username'=>'bsowah'])->first();
//        if(Hash::check($credentials['password'], $auth->password)){
//            $token = auth('api')->login($auth);
//            return response()->json(compact('token'));
//        }
//        else{
//            return 'hello';
//        }

//        return response()->json($auth);

        $credentials = $request->only('username', 'password');

//        $status = JWTAuth::attempt($credentials);
//        return $status;
//        return $credentials;
//        return JWTAuth::parseToken();
        \Config::set('auth.providers.users.model', \App\MobAppUsers::class);
        try {
//            return response()->json(['passed_credentials'=>$credentials]);
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (Exception $e) {
            return response()->json(['error' => 'could_not_create_token '.$e], 500);
        }

        return response()->json([compact('token')]);
////        $auth = auth('server')::attempt($credentials);
//
////        if (! $token = auth('server')->attempt($credentials)) {
////            return response()->json(['error' => 'Unauthorized'], 401);
////        }
////
//        return $this->respondWithToken($token);

//        if (auth('server')->login(['login_id'=>"mantse",'centre_id'=>1])) {
//            $details = auth('server');
////            $user = $details['original'];
//            return $details;
//        } else {
//            return 'auth fail';
//        }
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
//        return "heya";
        return response()->json(['mobappuser'=>auth('api')->user()]);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function apilogin(){
        return response()->json(['message' => 'Hello you\'re authenticated!']);
}

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function open()
    {
        $data = "This data is open and can be accessed without the client being authenticated";
        return response()->json(compact('data'),200);

    }

    public function closed()
    {
        $data = "Only authorized users can see this";
        return response()->json(compact('data'),200);
    }

    public function getAuthenticatedUser()
    {
        try {
//            return JWTAuth::parseToken()->authenticate();
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());
        }
        return response()->json(compact('user'));
    }

    public function register(Request $request)
    {
        $credentials = $request->only('username', 'email', 'password');
        $rules = [
            'fullname' => 'required|max:255|unique:users',
            'username' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
        ];
        $validator = Validator::make($credentials, $rules);
        if($validator->fails()) {
            return response()->json(['success'=> false, 'error'=> $validator->messages()]);
        }
        $fullname = $request->fullname;
        $username = $request->username;
        $password = $request->password;
        User::create(['fullname' => $fullname, 'username' => $username, 'password' => Hash::make($password)]);
        return $this->login($request);
    }
//
//    public function login(Request $request)
//    {
////        dd($request->password);
//        $credentials = $request->only('email', 'password');
//        $rules = [
//            'email' => 'required|email',
//            'password' => 'required',
//        ];
//        $validator = Validator::make($credentials, $rules);
//        if($validator->fails()) {
//            return response()->json(['success'=> false, 'error'=> $validator->messages()]);
//        }
//        try {
//            // attempt to verify the credentials and create a token for the user
//            if (!$token = JWTAuth::attempt($credentials)) {
//                return response()->json(['success' => false, 'error' => 'We cant find an account with this credentials.'], 401);
//            }
//        } catch (JWTException $e) {
//            // something went wrong whilst attempting to encode the token
//            return response()->json(['success' => false, 'error' => 'Failed to login, please try again.'], 500);
//        }
//        // all good so return the token
//        return response()->json(['success' => true, 'data'=> [ 'token' => $token ]]);
//    }
//    /**
//     * Log out
//     * Invalidate the token, so user cannot use it anymore
//     * They have to relogin to get a new token
//     *
//     * @param Request $request
//     */
//    public function logout(Request $request) {
//        $this->validate($request, ['token' => 'required']);
//        try {
//            JWTAuth::invalidate($request->input('token'));
//            return response()->json(['success' => true, 'message'=> "You have successfully logged out."]);
//        } catch (JWTException $e) {
//            // something went wrong whilst attempting to encode the token
//            return response()->json(['success' => false, 'error' => 'Failed to logout, please try again.'], 500);
//        }
//    }
//
//    public function recover(Request $request)
//    {
//        $user = User::where('email', $request->email)->first();
//        if (!$user) {
//            $error_message = "Your email address was not found.";
//            return response()->json(['success' => false, 'error' => ['email'=> $error_message]], 401);
//        }
//        try {
//            Password::sendResetLink($request->only('email'), function (Message $message) {
//                $message->subject('Your Password Reset Link');
//            });
//        } catch (\Exception $e) {
//            //Return with error
//            $error_message = $e->getMessage();
//            return response()->json(['success' => false, 'error' => $error_message], 401);
//        }
//        return response()->json([
//            'success' => true, 'data'=> ['message'=> 'A reset email has been sent! Please check your email.']
//        ]);
//    }
}
