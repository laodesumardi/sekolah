<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class MobileCookieSessionFix
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
            // Fix mobile cookie/session issues
            $this->fixMobileCookieSession($request);
            
            // Set mobile-specific headers
            $response = $next($request);
            
            if ($response instanceof \Illuminate\Http\Response) {
                $this->setMobileCookieHeaders($response, $request);
            }
            
            // Log mobile requests
            Log::info('Mobile cookie/session fix applied', [
                'user_agent' => $userAgent,
                'ip' => $request->ip(),
                'url' => $request->url(),
                'method' => $request->method(),
                'session_id' => $request->session()->getId(),
                'csrf_token' => $request->session()->token(),
                'cookies' => $request->cookies->all()
            ]);
            
            return $response;
        }

        return $next($request);
    }

    /**
     * Fix mobile cookie/session issues
     */
    private function fixMobileCookieSession(Request $request)
    {
        // Force session configuration for mobile
        config(['session.driver' => 'database']);
        config(['session.lifetime' => 1440]); // 24 hours
        config(['session.expire_on_close' => false]);
        config(['session.cookie_lifetime' => 1440]);
        config(['session.cookie_secure' => false]); // Disable secure for mobile
        config(['session.cookie_httponly' => false]); // Allow JS access
        config(['session.cookie_same_site' => 'none']); // Most permissive
        config(['session.cookie_path' => '/']);
        config(['session.cookie_domain' => null]); // No domain restriction
        
        // Force session regeneration for mobile
        if (!$request->session()->getId()) {
            $request->session()->regenerate();
        }
        
        // Always regenerate token for mobile
        $request->session()->regenerateToken();
        
        // Store mobile session in multiple ways for redundancy
        $this->storeMobileSessionRedundantly($request);
    }

    /**
     * Store mobile session redundantly
     */
    private function storeMobileSessionRedundantly(Request $request)
    {
        $sessionId = $request->session()->getId();
        $csrfToken = $request->session()->token();
        $ip = $request->ip();
        $userAgent = $request->header('User-Agent');
        
        // Store in cache with multiple keys
        $keys = [
            'mobile_session_' . $sessionId,
            'mobile_session_ip_' . $ip,
            'mobile_session_ua_' . md5($userAgent),
            'mobile_session_combined_' . md5($ip . $userAgent)
        ];
        
        $sessionData = [
            'session_id' => $sessionId,
            'csrf_token' => $csrfToken,
            'timestamp' => time(),
            'ip' => $ip,
            'user_agent' => $userAgent,
            'created_at' => now()
        ];
        
        foreach ($keys as $key) {
            Cache::put($key, $sessionData, 1440); // 24 hours
        }
    }

    /**
     * Set mobile-specific cookie headers
     */
    private function setMobileCookieHeaders($response, Request $request)
    {
        $sessionId = $request->session()->getId();
        $csrfToken = $request->session()->token();
        
        // Set multiple cookie headers for mobile
        $response->headers->set('Set-Cookie', [
            'laravel_session=' . $sessionId . '; Path=/; Max-Age=518400; SameSite=None; Secure=false; HttpOnly=false',
            'XSRF-TOKEN=' . $csrfToken . '; Path=/; Max-Age=518400; SameSite=None; Secure=false; HttpOnly=false',
            'mobile_session=' . $sessionId . '; Path=/; Max-Age=518400; SameSite=None; Secure=false; HttpOnly=false'
        ]);
        
        // Set mobile-specific headers
        $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0, private');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', '0');
        $response->headers->set('X-Mobile-Optimized', 'true');
        $response->headers->set('X-Mobile-Session-Fix', 'true');
        $response->headers->set('X-CSRF-Token', $csrfToken);
        $response->headers->set('X-Session-ID', $sessionId);
        
        // Set additional mobile headers
        $response->headers->set('X-Mobile-Cookie-Fix', 'true');
        $response->headers->set('X-Mobile-Session-Lifetime', '1440');
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
