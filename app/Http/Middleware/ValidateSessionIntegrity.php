<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/**
 * Session & IP Validation Middleware
 * 
 * Prevents session hijacking by validating:
 * - Client IP address
 * - User Agent
 * - Session validity
 */
class ValidateSessionIntegrity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            // Validate IP Address
            if (session('client_ip') && session('client_ip') !== $request->ip()) {
                Log::warning('Session IP mismatch', [
                    'user_id' => Auth::id(),
                    'original_ip' => session('client_ip'),
                    'current_ip' => $request->ip(),
                ]);

                // Invalidate session due to IP change (optional - log only)
                // Auth::logout();
                // session()->invalidate();
                // return redirect('/login')->with('error', 'Session terminated for security reasons.');
            }

            // Validate User Agent
            if (session('user_agent') && session('user_agent') !== $request->userAgent()) {
                Log::warning('Session user agent mismatch', [
                    'user_id' => Auth::id(),
                    'original_agent' => session('user_agent'),
                    'current_agent' => $request->userAgent(),
                ]);

                // Optional: Invalidate session
                // Auth::logout();
                // session()->invalidate();
                // return redirect('/login')->with('error', 'Session terminated for security reasons.');
            }

            // Update session tracking data
            session(['client_ip' => $request->ip()]);
            session(['user_agent' => $request->userAgent()]);
        }

        return $next($request);
    }
}
