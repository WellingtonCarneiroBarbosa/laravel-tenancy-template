<?php

namespace App\Http\Middleware\Applications\API;

use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $token = PersonalAccessToken::findToken($request->bearerToken());
        } catch (ModelNotFoundException) {
            abort(401);
        }

        $request->attributes->add([
            'user' => $token->tokenable,
        ]);

        return $next($request);
    }
}
