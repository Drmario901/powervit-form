<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateApiAccess
{
    /**
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $expected = config('api.access_token');

        if (! is_string($expected) || $expected === '') {
            return $next($request);
        }

        if ($request->is('api/contact')) {
            return $next($request);
        }

        $provided = $request->header('X-Api-Key');

        if (! is_string($provided) || ! hash_equals($expected, $provided)) {
            return response()->json([
                'success' => false,
                'status' => 401,
                'message' => 'Unauthorized.',
            ], 401);
        }

        return $next($request);
    }
}
