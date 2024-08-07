<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::user();

                if ($user->role == 'Admin') {
                    return redirect()->route('admin.home');
                } elseif ($user->role == 'Customer') {
                    return redirect()->route('shop.index');
                } elseif ($user->role == 'Courier') {
                    return redirect()->route('courier.home');
                } elseif ($user->role == 'SuperAdmin') {
                    return redirect()->route('superAdmin.home');
                }

                return redirect('/');
            }
        }

        return $next($request);
    }
}
