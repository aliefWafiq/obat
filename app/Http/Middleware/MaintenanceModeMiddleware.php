<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MaintenanceModeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $isMaintenance = setting('modePemeliharaan', 'false') === 'true' || setting('modePemeliharaan', 'false') === '1';

        if ($isMaintenance) {
            // 1. Allow login/logout actions and routes
            if ($request->routeIs('login') || $request->is('/') || $request->is('login/action') || $request->is('logOut') || $request->routeIs('logOut')) {
                return $next($request);
            }

            // 2. Check if user is logged in
            if (auth()->check()) {
                $role = auth()->user()->role;

                // SuperAdmin passes through normally
                if ($role === 'SuperAdmin') {
                    return $next($request);
                }

                // Others (Admin, User) can ONLY access the maintenance page
                if ($request->routeIs('maintenance') || $request->is('maintenance') || $request->is('maintenance/*')) {
                    return $next($request);
                }

                return redirect()->route('maintenance');
            }

            // 3. If guest (not logged in), redirect any other page requests to the login page
            return redirect()->route('login');
        }

        // If not in maintenance mode, redirect away from the maintenance page
        if ($request->routeIs('maintenance') || $request->is('maintenance') || $request->is('maintenance/*')) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
