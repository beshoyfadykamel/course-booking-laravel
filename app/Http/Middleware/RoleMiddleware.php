<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Supports single or multiple roles: role:admin  or  role:admin,user
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, string ...$roles): Response
    {
        if (!Auth::check() || !in_array(Auth::user()->role, $roles)) {
            return redirect()->route('welcome');
        }

        return $next($request);
    }
}
