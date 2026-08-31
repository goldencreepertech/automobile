<?php

namespace Automobile\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateWithStaticToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        if (
            config('static_token.enabled')
            && $token !== null
            && config('static_token.token') !== null
            && hash_equals((string) config('static_token.token'), $token)
        ) {
            $user = $this->resolveUserModel()::first();

            if ($user) {
                Auth::guard('sanctum')->setUser($user);
            }

            return $next($request);
        }

        return app(Authenticate::class)->handle($request, $next, 'sanctum');
    }

    /**
     * Resolve the host application's configured authenticatable model, so this
     * middleware isn't hard-coupled to a specific app's User class.
     *
     * @return class-string<\Illuminate\Contracts\Auth\Authenticatable>
     */
    private function resolveUserModel(): string
    {
        return config('auth.providers.users.model', \App\Models\User::class);
    }
}
