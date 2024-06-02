<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ShareNotifications
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (Auth::check()) {
            $user = Auth::user();
            $notifications = $user->notifications;
            $unreadNotifications = $user->unreadNotifications;

            view()->share('notifications', $notifications);
            view()->share('unreadNotifications', $unreadNotifications);
        }
        return $next($request);
    }
}
