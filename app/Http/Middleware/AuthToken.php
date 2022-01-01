<?php

namespace App\Http\Middleware;

use App\Exceptions\AuthenticationException;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthToken
{
    public function handle(Request $request, Closure $next)
    {
        $this->processUserAuthentication($request);
        return $next($request);
    }


    private function throwAuthException(string $message)
    {
        throw new AuthenticationException($message, Response::HTTP_UNAUTHORIZED);
    }

    private function processUserAuthentication(Request $request): void
    {
        if (config('system.disable_test_auth_via_token')) {
            return;
        }

        if (($tokenString = $request->bearerToken()) === null) {
            $this->throwAuthException('Authorization token must be provided');
        }

        try {
            $user = JWTAuth::toUser(JWTAuth::parseToken($tokenString));
        } catch (TokenBlacklistedException) {
            $this->throwAuthException('Can\'t authenticate user. The token was revoked');
        }

        if (!$user) {
            $this->throwAuthException('Invalid JWT token provided');
        }

        Auth::setUser($user);
    }
}
