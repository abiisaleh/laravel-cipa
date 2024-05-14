<?php

namespace App\Http\Middleware;

use Closure;
use Filament\Notifications\Livewire\DatabaseNotifications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class DatabaseNotification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $notification = new DatabaseNotifications;

        try {
            View::share('notificationCount', $notification->getUnreadNotificationsCount());
        } catch (\Throwable $th) {
            //throw $th;
        }


        return $next($request);
    }
}
