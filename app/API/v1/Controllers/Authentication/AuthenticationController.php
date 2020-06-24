<?php


namespace App\API\v1\Controllers\Authentication;

use App\Groups;
use App\Http\Controllers\Controller;
use App\User;
use DateTime;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class AuthenticationController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return $this->standardResponse('invalid_credentials', $credentials, 400);
            }
            $user = User::where('email', $credentials['email'])->first();
            return $this->standardResponse('Login Successfuly', ['token' => $token, 'userInformation' => $user]);
        } catch (JWTException $e) {
            return $this->standardResponse($e->getMessage(), $credentials, $e->getCode(), $e->getTrace());
        }
    }

    public function register(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|string|email|max:255|unique:users',
        //     'password' => 'required|string|min:6|confirmed',
        // ]);

        // dd($request->all());
        // if($validator->fails()){
        //         return response()->json($validator->errors()->toJson(), 400);
        // }
        $getFirstName = explode(' ', trim($request->get('fullname')));

        $user_url = $getFirstName[0] . '-user-' . time();

        $user = User::create([
            'user_id' => strtolower($user_url),
            'fullname' => $request->get('fullname'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);

        $token = JWTAuth::fromUser($user);


        return $this->standardResponse('Registered Successfuly', ['token' => $token, 'user' => $user]);
    }

    public function getAuthenticatedUser()
    {
        try {

            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getMessage());
        } catch (TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getMessage());
        } catch (JWTException $e) {

            return response()->json(['token_absent'], $e->getMessage());
        }

        return response()->json(compact('user'));
    }
}
