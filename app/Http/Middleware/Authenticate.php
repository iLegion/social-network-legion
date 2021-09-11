<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo($request): void
    {
        if (!$request->expectsJson()) {
            abort(response()->json([
                'message' => 'Unauthenticated'
            ], 401));
        }
    }
}
