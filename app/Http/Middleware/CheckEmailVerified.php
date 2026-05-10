<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckEmailVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Jika user sudah login dan belum verified, dan mencoba akses halaman non-auth
        if (auth()->check() && !auth()->user()->is_verified) {
            // Izinkan akses ke halaman verify-email
            if ($request->routeIs('filament.admin.auth.verify-email')) {
                return $next($request);
            }
            
            // Jika akses halaman lain, redirect ke verify-email
            if (!$this->isAuthPage($request)) {
                return redirect()->route('filament.admin.auth.verify-email');
            }
        }

        return $next($request);
    }

    /**
     * Check if the current request is an auth page
     */
    private function isAuthPage(Request $request): bool
    {
        $authPages = [
            'filament.auth.logout',
            'filament.admin.auth.logout',
            'filament.admin.auth.login',
            'filament.admin.auth.register',
            'filament.admin.auth.verify-email',
        ];

        return $request->routeIs($authPages);
    }
}
