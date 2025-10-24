<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class MobileNoCookieMiddleware
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
            // Configure session for mobile without cookies
            $this->configureMobileSession($request);
            
            // Set mobile-specific headers
            $response = $next($request);
            
            if ($response instanceof \Illuminate\Http\Response) {
                $this->setMobileHeaders($response, $request);
            }
            
            // Log mobile requests
            Log::info('Mobile no-cookie request processed', [
                'user_agent' => $userAgent,
                'ip' => $request->ip(),
                'url' => $request->url(),
                'method' => $request->method(),
                'session_id' => $request->session()->getId(),
                'csrf_token' => $request->session()->token()
            ]);
            
            return $response;
        }

        return $next($request);
    }

    /**
     * Configure session for mobile without cookies
     */
    private function configureMobileSession(Request $request)
    {
        // Force database session for mobile
        config(['session.driver' => 'database']);
        config(['session.lifetime' => 1440]); // 24 hours
        config(['session.expire_on_close' => false]);
        config(['session.cookie_lifetime' => 0]); // No cookie
        config(['session.cookie_secure' => false]);
        config(['session.cookie_httponly' => false]);
        config(['session.cookie_same_site' => 'none']); // Most permissive
        
        // Generate session ID if not exists
        if (!$request->session()->getId()) {
            $request->session()->regenerate();
        }
        
        // Always regenerate token for mobile
        $request->session()->regenerateToken();
        
        // Store mobile session in cache with IP-based key
        $mobileSessionKey = 'mobile_session_' . $request->ip() . '_' . md5($request->header('User-Agent'));
        Cache::put($mobileSessionKey, [
            'session_id' => $request->session()->getId(),
            'csrf_token' => $request->session()->token(),
            'timestamp' => time(),
            'ip' => $request->ip(),
            'user_agent' => $request->header('User-Agent')
        ], 1440); // 24 hours
    }

    /**
     * Set mobile-specific headers
     */
    private function setMobileHeaders($response, Request $request)
    {
        $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0, private');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', '0');
        $response->headers->set('X-Mobile-Optimized', 'true');
        $response->headers->set('X-No-Cookie-Session', 'true');
        $response->headers->set('X-CSRF-Token', csrf_token());
        $response->headers->set('X-Session-ID', $request->session()->getId());
        
        // Disable cookie headers
        $response->headers->remove('Set-Cookie');
    }

    /**
     * Check if user agent is mobile
     */
    private function isMobile($userAgent)
    {
        $mobileKeywords = [
            'Mobile', 'Android', 'iPhone', 'iPad', 'iPod', 
            'BlackBerry', 'Windows Phone', 'Opera Mini', 'IEMobile',
            'Mobile Safari', 'Mobile Chrome', 'Mobile Firefox'
        ];

        foreach ($mobileKeywords as $keyword) {
            if (stripos($userAgent, $keyword) !== false) {
                return true;
            }
        }

        return false;
    }
}
