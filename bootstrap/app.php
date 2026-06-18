<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\AdminAuth;
use App\Http\Middleware\EnsureAccountActive;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            $prefix = env('ADMIN_PREFIX', 'admin');

            \Illuminate\Support\Facades\Route::middleware('web')
                ->prefix($prefix)
                ->name('admin.')
                ->group(base_path('routes/admin.php'));

            \Illuminate\Support\Facades\Route::middleware('web')
                ->prefix($prefix)
                ->group(base_path('routes/auth.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin'           => AdminAuth::class,
            'account.active'  => EnsureAccountActive::class,
        ]);

        $middleware->web(append: [
            \App\Http\Middleware\SetLocale::class,
        ]);

        // Trust proxies for Kubernetes/CDN
        $middleware->trustProxies(at: '*');
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
