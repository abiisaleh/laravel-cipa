<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectGuest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!in_array(url()->current(), [
            filament()->getLogoutUrl(),
            filament()->getProfileUrl(),
            filament()->getVerifyEmailUrl(
                auth()->user()
            ),
            filament()->getEmailVerificationPromptUrl()
        ]))
            if (auth()->user()->role == 'pelanggan')
                return redirect(url('order/new'));

        return $next($request);
    }
}
