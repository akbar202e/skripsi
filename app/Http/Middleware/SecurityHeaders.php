<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Security Headers Middleware
 * 
 * Adds security headers to all HTTP responses to prevent:
 * - Clickjacking attacks (X-Frame-Options)
 * - MIME type sniffing (X-Content-Type-Options)
 * - XSS attacks (X-XSS-Protection, Content-Security-Policy)
 * - Referrer leakage (Referrer-Policy)
 * - Unintended permission usage (Permissions-Policy)
 */
class SecurityHeaders
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
        $response = $next($request);

        // Get security headers from config
        $headers = config('security.headers', []);

        // Add all security headers to response
        // Skip for StreamedResponse and BinaryFileResponse as they handle headers differently
        if ($response instanceof StreamedResponse || get_class($response) === 'Symfony\Component\HttpFoundation\BinaryFileResponse') {
            return $response;
        }

        foreach ($headers as $key => $value) {
            if (method_exists($response, 'header')) {
                $response->header($key, $value);
            } else {
                // Fallback for responses that don't have header() method
                $response->headers->set($key, $value);
            }
        }

        return $response;
    }
}
