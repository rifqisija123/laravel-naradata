<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RestrictAccessByEmail
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user) {
            return $next($request);
        }

        $email = strtolower($user->email ?? '');

        // Allow full access for naradata@example.com
        if ($email === 'naradata@example.com') {
            return $next($request);
        }

        // For other users, only allow specific named routes and paths
        $allowedRouteNames = [
            'home',
            'dashboard',
            // Filters page and result
            'riwayat.filter',
            'filter.result',
            // Chat page and APIs
            'chat',
            'chat.users',
            'chat.messages',
            'chat.send',
            'chat.update-last-seen',
            'chat.mark-read',
        ];

        $route = $request->route();
        $routeName = $route ? $route->getName() : null;

        if ($routeName && in_array($routeName, $allowedRouteNames, true)) {
            return $next($request);
        }

        // Also allow direct paths for home and dashboard if accessed without names
        $allowedPaths = [
            '/',
            '/dashboard',
            '/riwayat/filter',
            '/riwayat/filter/result',
            '/chat',
            '/api/chat/users',
            '/api/chat/messages',
            '/api/chat/send',
            '/api/chat/update-last-seen',
            '/api/chat/mark-read',
        ];

        $path = '/' . ltrim($request->path(), '/');
        if (in_array($path, $allowedPaths, true)) {
            return $next($request);
        }

        // Deny with 403 for unauthorized routes
        abort(403, 'Akses ditolak: Hubungi admin untuk akses fitur ini.');
    }
}

