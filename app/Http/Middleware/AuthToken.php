<?php

namespace App\Http\Middleware;

use App\Exceptions\AuthenticationException;
use App\Models\User;
use App\Services\Auth\AuthManager;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthToken
{


    public function __construct(private AuthManager $authManager)
    {

    }

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
        if (($token = $request->bearerToken()) === null) {
            $this->throwAuthException('Authorization token must be provided');
        }

        if (!($user = User::find($this->authManager->processAuthToken($token)))) {
            $this->throwAuthException('Can\'t authenticate user');
        }

        Auth::setUser($user);
    }
}
