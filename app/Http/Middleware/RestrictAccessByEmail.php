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
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user) {
            return $next($request);
        }

        $email = strtolower($user->email ?? '');

        if ($email === 'naradata@example.com') {
            return $next($request);
        }

        $allowedRouteNames = [
            'home',
            'dashboard',
            'riwayat.filter',
            'filter.result',
            'chat',
            'chat.users',
            'chat.messages',
            'chat.send',
            'chat.update-last-seen',
            'chat.mark-read',
            'chat.unread-count',
        ];

        $route = $request->route();
        $routeName = $route ? $route->getName() : null;

        if ($routeName && in_array($routeName, $allowedRouteNames, true)) {
            return $next($request);
        }

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
            '/api/chat/unread-count',
        ];

        $path = '/' . ltrim($request->path(), '/');
        if (in_array($path, $allowedPaths, true)) {
            return $next($request);
        }

        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }
}
