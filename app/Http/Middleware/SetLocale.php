<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $segments = explode('/', trim($request->path(), '/'));
        $first = $segments[0] ?? '';

        $codes = active_languages()->pluck('code')->toArray();

        if (in_array($first, $codes, true)) {
            App::setLocale($first);
            session(['locale' => $first]);
        } else {
            $locale = session('locale', default_locale());
            if (in_array($locale, $codes, true)) {
                App::setLocale($locale);
            }
        }

        return $next($request);
    }
}
