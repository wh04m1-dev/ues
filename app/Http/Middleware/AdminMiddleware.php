<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated and is an admin
        if (Auth::check() && Auth::user()->role_id === 1) { // Assuming 1 is the admin role ID
            return $next($request);  // Proceed with the request if the user is an admin
        }

        // Return an error response if the user is not an admin
        return response()->json(['error' => 'Unauthorized'], 403); // 403 Forbidden
    }
}
