<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Traits\ApiTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ApiTrait;

    /**
     * set guard to replace auth()
     */
    public function guard()
    {
        return Auth::guard('api');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $rules = [
            'uid' => 'required|unique:users',
            'email' => 'required|email',
        ];
        $this->validate($request, $rules);

        $user = User::create($request->only(['uid', 'email']));
        $user->password = Hash::make($request->email);
        $user->save();

        $credentials = [
            'uid' => $user->uid,
            'password' => $user->email,
        ];

        return $this->respondWithToken($this->guard()->attempt($credentials));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $rules = [
            'uid' => 'required',
            'password' => 'required',
        ];
        $this->validate($request, $rules);

        $credentials = $request->only(['uid', 'password']);

        if (! $token = $this->guard()->attempt($credentials)) {
            return $this->return404Response();
        }

        return $this->respondWithToken($token);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function refreshToken()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        $user = $this->guard()->user();

        return ($user) ? $this->returnSuccess('Success.', $user) : $this->return404Response();
    }

    /**
     * Get the token array structure.
     * @param  string $token
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return $this->returnSuccess('Success.', [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }
}
