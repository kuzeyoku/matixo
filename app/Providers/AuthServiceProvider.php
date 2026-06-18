<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;

class AuthServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        RateLimiter::for('admin-login', function (Request $request) {
            $email = (string) $request->input('email');
            return Limit::perMinute(config('matixo.login.max_attempts', 5))
                ->by(mb_strtolower($email) . '|' . $request->ip());
        });

        RateLimiter::for('contact-form', function (Request $request) {
            return Limit::perMinute(3)->by($request->ip());
        });

        RateLimiter::for('review-form', function (Request $request) {
            return Limit::perMinute(2)->by($request->ip());
        });
    }
}
