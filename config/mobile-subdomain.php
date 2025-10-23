<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Mobile & Subdomain CSRF Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration untuk mengatasi error 419 di mobile dan subdomain
    |
    */

    'mobile_csrf_fix' => env('MOBILE_CSRF_FIX', true),
    'subdomain_csrf_fix' => env('SUBDOMAIN_CSRF_FIX', true),
    
    'cookie_settings' => [
        'secure' => env('COOKIE_SECURE', false),
        'http_only' => env('COOKIE_HTTP_ONLY', false),
        'same_site' => env('COOKIE_SAME_SITE', 'lax'),
        'domain' => env('SESSION_DOMAIN', null),
        'path' => '/',
        'lifetime' => env('SESSION_LIFETIME', 1440),
    ],
    
    'mobile_browsers' => [
        'Mobile', 'Android', 'iPhone', 'iPad', 'iPod', 
        'BlackBerry', 'Windows Phone', 'Opera Mini', 'IEMobile',
        'Mobile Safari', 'Mobile Chrome', 'Mobile Firefox'
    ],
    
    'subdomain_domains' => [
        'admin', 'www', 'api', 'app', 'mobile', 'm'
    ],
    
    'third_party_contexts' => [
        'WhatsApp', 'Instagram', 'Facebook', 'Twitter', 'Telegram',
        'Line', 'WeChat', 'TikTok', 'Snapchat'
    ],
];

