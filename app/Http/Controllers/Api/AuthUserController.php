<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use TCG\Voyager\Models\Role;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\PandingUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Services\UserServices;

class AuthUserController extends Controller
{

    public function __construct(UserServices $exampleService)
    {
        $this->exampleService = $exampleService;
    }
    public function register(Request $request)
    {
        $requestData = $request->all();

        $result = $this->exampleService->validateData($requestData);
        try {
            $role = Role::where('name', 'user')->firstOrFail();
            $user = User::create([
                'f_name' => $requestData['f_name'],
                's_name' => $requestData['s_name'],
                'phone_number' => $requestData['phone_number'],
                'email' => $requestData['email'],
                'birthday' => $requestData['birthday'],
                'gender' => $requestData['gender'],
                'password' => Hash::make($requestData['password']),
                'remember_token' => Str::random(60),
                'role_id' => $role->id,
                'avatar' => $requestData['avatar'],
            ]);

            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'data' => [
                    'user' => $user,
                    'token' => $token,
                    'message' => 'Registered successfully'
                ]
            ]);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->only(['phone_number', 'password']);

        if ($token = auth()->attempt($credentials)) {
            $user = auth()->user();
            $token = JWTAuth::fromUser($user);
            $user = $user->only([
            'role_id', 'f_name',  's_name',  'email',  'phone_number', 'gender', 'birthday',  'avatar',
                'active_status',
                'dark_mode',
                'messenger_color',
            ]);

            return response()->json([
                'data' => [
                    'user' => $user,
                    'token' => $token,
                    'message' => 'Login successful'
                ]
            ]);
        }
        return response()->json([
            'status' => false,
            'errNum' => 'E002',
            'msg' => 'Invalid credentials'
        ]);
    }


    public function logout(Request $request)
    {
        $token = $request->bearerToken();
        if ($token) {
            try {

                JWTAuth::setToken($token)->invalidate(); //logout
                return $this->returnSuccessMessage('Logged out successfully');
            } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
                return $this->returnError('', 'some thing went wrongs');
            }
        } else {
            return $this->returnError('', 'some thing went wrongs');
        }
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



    public function post_profile(Request $request)
    {
        $user=auth()->user();

        $validator=Validator::make($request->all(),[
            'image'=>'image'
            //,'mimes:jpeg,png,bmp,jpg,gif,svg']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(),400);
        }
        $image=$request->file('image');
        $file_name = time() . '.' . $image->getClientOriginalExtension();
        $path='profiles/' . $file_name;
        //return $path;
        $image->move(public_path('profiles'), $file_name);

        User::where('id','=',$user->id)->update(['image_path'=>$path]);
        return response()->json("save successfully");
    }
}
