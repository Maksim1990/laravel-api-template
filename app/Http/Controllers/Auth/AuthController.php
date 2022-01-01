<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\AuthenticationException;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            throw new AuthenticationException(implode(',', $validator->messages()->all()));
        }

        $credentials = $request->only('email', 'password');

        if ($token = auth()->attempt($credentials)) {
            return $this->respondWithToken($token);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function register(CreateUserRequest $request){
        $user = User::create($request->validated());
        return $this->respondWithToken(auth()->login($user));
    }

    public function logout(Request $request){
        $token = $request->bearerToken();
        JWTAuth::manager()->invalidate(new \Tymon\JWTAuth\Token($token), $forceForever = false);
        return response()->json(['message' => 'Successfully logged out']);
    }

    protected function respondWithToken(string $token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->guard()->factory()->getTTL() * 60,
            'user' => auth()->user(),
        ]);
    }
}
