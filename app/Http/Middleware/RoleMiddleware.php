<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login');
        }

        // Roles come as an array now: ['admin', 'provider']
        $allowedRoles = array_map('trim', $roles);

        // Special rule: moderators can access admin routes
        if (in_array('admin', $allowedRoles) && $user->hasAnyRole(['admin', 'moderator'])) {
            return $next($request);
        }

        if ($user->hasAnyRole($allowedRoles)) {
            return $next($request);
        }

        // If user doesn't have required role, redirect to their dashboard
        return $this->redirectToDashboard($user);
    }

    /**
     * Redirect user to their appropriate dashboard based on role
     */
    private function redirectToDashboard($user)
    {
        if ($user->hasRole('admin') || $user->hasRole('moderator')) {
            return redirect()->route('admin-home');
        }

        if ($user->hasRole('cleaner')) {
            return redirect()->route('cleaner-home');
        }

        if ($user->hasRole('customer')) {
            return redirect()->route('customer-home');
        }

        // Fallback to home or login
        return redirect()->route('login');
    }
}