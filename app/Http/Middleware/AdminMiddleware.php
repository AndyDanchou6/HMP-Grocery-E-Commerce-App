<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if user is authenticated and has 'Admin' role
        if (Auth::check() && $request->user()->role === 'Admin') {
            return $next($request);
        }

        // If not authenticated or not admin, return unauthorized response
        return redirect()->route('error')->with('error', 'Unauthorized. You do not have permission to access this resource.');
    }
}
