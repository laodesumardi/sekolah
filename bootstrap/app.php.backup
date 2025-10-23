<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// EMERGENCY FIX: Manually load DomPDF ServiceProvider
$dompdfServiceProviderPath = __DIR__.'/../vendor/barryvdh/laravel-dompdf/src/ServiceProvider.php';
if (file_exists($dompdfServiceProviderPath)) {
    require_once $dompdfServiceProviderPath;
}

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'student.registered' => \App\Http\Middleware\EnsureStudentRegistered::class,
            'ppdb.approved' => \App\Http\Middleware\EnsurePPDBApproved::class,
            'student.ppdb.approved' => \App\Http\Middleware\EnsureStudentPPDBApproved::class,
            // Tambahkan alias middleware untuk CSRF mobile
            'mobile.csrf' => \App\Http\Middleware\MobileCSRFMiddleware::class,
            'hosting.mobile.csrf' => \App\Http\Middleware\HostingMobileCSRFMiddleware::class,
            'mobile.no.cookie' => \App\Http\Middleware\MobileNoCookieMiddleware::class,
            'mobile.cookie.fix' => \App\Http\Middleware\MobileCookieSessionFix::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
