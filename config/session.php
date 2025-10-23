<?php
return [
    "driver" => env("SESSION_DRIVER", "database"),
    "lifetime" => (int) env("SESSION_LIFETIME", 1440), // 24 hours for mobile
    "expire_on_close" => env("SESSION_EXPIRE_ON_CLOSE", false),
    "cookie_lifetime" => (int) env("SESSION_LIFETIME", 1440),
    "encrypt" => false,
    "files" => storage_path("framework/sessions"),
    "connection" => env("SESSION_CONNECTION", null),
    "table" => "sessions",
    "store" => env("SESSION_STORE", null),
    "lottery" => [2, 100],
    "cookie" => env("SESSION_COOKIE", "laravel_session"),
    "path" => "/",
    "domain" => env("SESSION_DOMAIN", null),
    "secure" => env("SESSION_SECURE_COOKIE", false),
    "http_only" => false, // Allow JS access for mobile
    "same_site" => "lax",
    "raw" => false,
    "serialize" => "php",
];