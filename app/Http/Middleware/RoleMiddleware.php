<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }
        $user = auth()->user();
        $allowedRoles = is_array($roles) ? $roles : [$roles];
        if (!in_array($user->role, $allowedRoles)) {
            abort(403, 'Unauthorized action. You need one of these roles: ' . implode(', ', $allowedRoles));
        }
        return $next($request);
    }
}
