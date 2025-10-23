<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class MobileCSRFMiddleware
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
        // Check if request is from mobile
        $userAgent = $request->header('User-Agent');
        $isMobile = $this->isMobile($userAgent);

        if ($isMobile) {
            // More aggressive mobile settings
            $sessionLifetime = config('session.lifetime', 480);
            config(['session.lifetime' => $sessionLifetime * 3]); // Triple for mobile
            config(['session.expire_on_close' => false]);
            config(['session.cookie_lifetime' => $sessionLifetime * 3]);
            
            // Always regenerate token for mobile to prevent 419
            if (!$request->session()->has('_token')) {
                $request->session()->regenerateToken();
            }
            
            // Force token refresh on every mobile request
            $request->session()->regenerateToken();
            
            // Set mobile-specific headers
            $response = $next($request);
            
            if ($response instanceof \Illuminate\Http\Response) {
                $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
                $response->headers->set('Pragma', 'no-cache');
                $response->headers->set('Expires', '0');
                $response->headers->set('X-Mobile-Optimized', 'true');
                $response->headers->set('X-CSRF-Token', csrf_token());
            }

            // Log mobile requests for debugging
            Log::info('Mobile request processed', [
                'user_agent' => $userAgent,
                'ip' => $request->ip(),
                'url' => $request->url(),
                'method' => $request->method(),
                'csrf_token' => $request->session()->token(),
                'session_id' => $request->session()->getId()
            ]);
            
            return $response;
        }

        return $next($request);
    }

    /**
     * Check if user agent is mobile
     */
    private function isMobile($userAgent)
    {
        $mobileKeywords = [
            'Mobile',
            'Android',
            'iPhone',
            'iPad',
            'iPod',
            'BlackBerry',
            'Windows Phone',
            'Opera Mini',
            'IEMobile'
        ];

        foreach ($mobileKeywords as $keyword) {
            if (stripos($userAgent, $keyword) !== false) {
                return true;
            }
        }

        return false;
    }
}
