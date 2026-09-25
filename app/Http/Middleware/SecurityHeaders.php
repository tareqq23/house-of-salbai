<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Add essential HTTP security headers to protect against common web attacks.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Anti-Clickjacking: prevent site from being embedded in malicious iframes
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // Anti-MIME sniffing: prevent browsers from guessing MIME types
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // XSS Filter Header (legacy browser support)
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // Referrer Privacy
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        return $response;
    }
}
