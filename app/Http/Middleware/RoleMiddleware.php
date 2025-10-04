<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string ...$roles  // Capture required roles passed to the middleware
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // 1. Check if user is authenticated
        if (!Auth::check()) {
            return redirect('login'); // Or abort(401)
        }

        $user = Auth::user();

        // 2. Check if the authenticated user's role is in the required roles list
        // Note: The 'role' attribute is present on the User model
        if (!in_array($user->role, $roles)) {
            // If the role doesn't match, redirect or show an unauthorized page
            // Redirecting to the home page or a specific unauthorized page is common.
            return abort(403, 'Unauthorized access.'); // Return 403 Forbidden
        }

        return $next($request);
    }
}