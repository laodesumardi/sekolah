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
            // Extend session lifetime for mobile
            $sessionLifetime = config('session.lifetime', 480);
            config(['session.lifetime' => $sessionLifetime * 2]); // Double for mobile

            // Set mobile-specific session settings
            config(['session.expire_on_close' => false]); // Don't expire on browser close for mobile
            
            // Regenerate CSRF token more frequently for mobile
            if ($request->isMethod('POST') || $request->isMethod('PUT') || $request->isMethod('DELETE')) {
                $request->session()->regenerateToken();
            }

            // Log mobile requests for debugging
            Log::info('Mobile request detected', [
                'user_agent' => $userAgent,
                'ip' => $request->ip(),
                'url' => $request->url(),
                'method' => $request->method(),
                'csrf_token' => $request->session()->token()
            ]);
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
