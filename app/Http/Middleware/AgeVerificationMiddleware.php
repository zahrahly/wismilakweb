<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AgeVerificationMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // For testing: allow resetting via query param
        if ($request->has('reset_age')) {
            $request->session()->forget('age_verified');
            return redirect($request->fullUrlWithoutQuery('reset_age'));
        }

        // Skip if it's the verification page or the verification post route
        if ($request->is('age-verification') || $request->is('age-verify')) {
            return $next($request);
        }

        // If session not verified, redirect to age verification
        if (!$request->session()->get('age_verified')) {
            return redirect()->route('age.verification');
        }

        return $next($request);
    }
}
