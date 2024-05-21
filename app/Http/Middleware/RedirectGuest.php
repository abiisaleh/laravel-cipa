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
        //kalau mau verifikasi langsung saja lewati pengecekan
        if (str_contains(url()->current(), url('admin/email-verification/verify/')))
            return $next($request);

        //kalau user mau ke panel selain logout, profile dan promp email
        if (!in_array(url()->current(), [
            filament()->getLogoutUrl(),
            filament()->getProfileUrl(),
            filament()->getEmailVerificationPromptUrl()
        ])) {
            if (auth()->user()->role == 'pelanggan')
                if (auth()->user()->email_verified_at == null)
                    return redirect(filament()->getEmailVerificationPromptUrl());
                else
                    return redirect(url('order/new'));
        }

        return $next($request);
    }
}
