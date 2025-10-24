<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class HostingMobileCSRFMiddleware
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
        
        // Check if we're in hosting environment
        $isHosting = $this->isHostingEnvironment($request);

        if ($isMobile && $isHosting) {
            // Hosting-specific mobile settings
            $this->configureHostingMobileSession($request);
            
            // Set hosting-specific headers
            $response = $next($request);
            
            if ($response instanceof \Illuminate\Http\Response) {
                $this->setHostingMobileHeaders($response, $request);
            }
            
            // Log hosting mobile requests
            Log::info('Hosting mobile request processed', [
                'user_agent' => $userAgent,
                'ip' => $request->ip(),
                'real_ip' => $request->header('X-Real-IP'),
                'forwarded_for' => $request->header('X-Forwarded-For'),
                'url' => $request->url(),
                'method' => $request->method(),
                'csrf_token' => $request->session()->token(),
                'session_id' => $request->session()->getId(),
                'hosting_provider' => $this->detectHostingProvider($request)
            ]);
            
            return $response;
        }

        return $next($request);
    }

    /**
     * Configure session for hosting mobile environment
     */
    private function configureHostingMobileSession(Request $request)
    {
        // More aggressive settings for hosting
        config(['session.lifetime' => 1440]); // 24 hours
        config(['session.expire_on_close' => false]);
        config(['session.cookie_lifetime' => 1440]);
        config(['session.cookie_secure' => $request->isSecure()]);
        config(['session.cookie_httponly' => false]); // Allow JS access for mobile
        config(['session.cookie_same_site' => 'lax']); // More permissive for mobile
        
        // Force session regeneration for hosting mobile
        if (!$request->session()->has('_token')) {
            $request->session()->regenerateToken();
        }
        
        // Always regenerate token for hosting mobile
        $request->session()->regenerateToken();
        
        // Store mobile session info in cache
        $sessionKey = 'mobile_session_' . $request->session()->getId();
        Cache::put($sessionKey, [
            'token' => $request->session()->token(),
            'timestamp' => time(),
            'user_agent' => $request->header('User-Agent'),
            'ip' => $request->ip()
        ], 1440); // 24 hours
    }

    /**
     * Set hosting-specific mobile headers
     */
    private function setHostingMobileHeaders($response, Request $request)
    {
        $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0, private');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', '0');
        $response->headers->set('X-Mobile-Optimized', 'true');
        $response->headers->set('X-Hosting-Mobile', 'true');
        $response->headers->set('X-CSRF-Token', csrf_token());
        $response->headers->set('X-Session-ID', $request->session()->getId());
        
        // CDN/Proxy headers
        $response->headers->set('Vary', 'User-Agent, X-Forwarded-For');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
    }

    /**
     * Check if we're in hosting environment
     */
    private function isHostingEnvironment(Request $request)
    {
        $host = $request->getHost();
        $serverName = $request->server('SERVER_NAME');
        
        // Check for common hosting indicators
        $hostingIndicators = [
            'cpanel', 'plesk', 'hostinger', 'niagahoster', 'rumahweb',
            'jagoanhosting', 'qwords', 'domaiNesia', 'idwebhost',
            '000webhost', 'infinityfree', 'awardspace', 'x10hosting',
            'heroku', 'vercel', 'netlify', 'github.io', 'firebase'
        ];
        
        foreach ($hostingIndicators as $indicator) {
            if (stripos($host, $indicator) !== false || 
                stripos($serverName, $indicator) !== false) {
                return true;
            }
        }
        
        // Check for cloudflare or other CDN
        if ($request->header('CF-Ray') || 
            $request->header('X-Forwarded-For') ||
            $request->header('X-Real-IP')) {
            return true;
        }
        
        // Check if not localhost
        return !in_array($host, ['localhost', '127.0.0.1', '::1']);
    }

    /**
     * Detect hosting provider
     */
    private function detectHostingProvider(Request $request)
    {
        $host = $request->getHost();
        $serverName = $request->server('SERVER_NAME');
        
        if (stripos($host, 'hostinger') !== false) return 'Hostinger';
        if (stripos($host, 'niagahoster') !== false) return 'Niagahoster';
        if (stripos($host, 'rumahweb') !== false) return 'Rumahweb';
        if (stripos($host, 'jagoanhosting') !== false) return 'Jagoanhosting';
        if (stripos($host, 'qwords') !== false) return 'Qwords';
        if (stripos($host, 'domaiNesia') !== false) return 'DomaiNesia';
        if (stripos($host, 'idwebhost') !== false) return 'IDwebhost';
        if (stripos($host, 'heroku') !== false) return 'Heroku';
        if (stripos($host, 'vercel') !== false) return 'Vercel';
        if (stripos($host, 'netlify') !== false) return 'Netlify';
        if ($request->header('CF-Ray')) return 'Cloudflare';
        
        return 'Unknown';
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
