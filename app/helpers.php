<?php

if (!function_exists('get_correct_asset_url')) {
    /**
     * Get the correct asset URL regardless of APP_URL configuration
     */
    function get_correct_asset_url($path)
    {
        // Force the correct port for development
        $scheme = request()->getScheme();
        $host = request()->getHost();
        $port = request()->getPort();
        
        // Override port for development
        if ($host === 'localhost' && $port !== 8000) {
            $port = 8000;
        }
        
        $baseUrl = $scheme . '://' . $host . ':' . $port;
        return $baseUrl . '/' . ltrim($path, '/');
    }
}
