<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
class AdminAuthController extends Controller
{
   // use AuthenticatesUsers;
    public function postLogin(Request $request){
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (!Auth::attempt($credentials)) {

            $this->incrementLoginAttempts($request);

            return $this->sendFailedLoginResponse($request);
        }


        $user = auth()->user();
        $token = JWTAuth::fromUser($user);
        $user->token = $token;

        return response()->json(['user' => $user,  'message' => 'Login successfully']);
        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.

    }

       /* // Validate the request data
        $this->validateLogin($request);

        // Check if the user has too many login attempts
        if ($this->hasTooManyLoginAttempts($request)) {
            // Log the lockout event
            $this->fireLockoutEvent($request);

            // Send a response indicating the user is locked out
            return $this->sendLockoutResponse($request);
        }

        // Prepare the credentials for authentication
        $credentials = [
            'email' => $request->email,
            'phone_number' => $request->phone_number
        ];

        if ($token = auth()->attempt($credentials)) {
            $user = auth()->user();
            $token = JWTAuth::fromUser($user);


        // Return a JSON response indicating the login was successful
        return response()->json([
            'data' => [
                'user' => $user, // Assuming $user is defined elsewhere in the method
                'message' => 'Login successful'
            ]
        ]);
    }
    }*/
}
