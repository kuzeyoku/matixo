<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Lütfen önce giriş yapın.');
        }

        $user = Auth::user();

        if (!$user->isAdmin()) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Bu alana erişim yetkiniz yok.');
        }

        if (!$user->is_active) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Hesabınız devre dışı bırakılmış.');
        }

        if ($user->must_change_password && !$request->routeIs('admin.password.*')) {
            return redirect()->route('admin.password.change')
                ->with('warning', 'Devam etmeden önce şifrenizi değiştirmelisiniz.');
        }

        return $next($request);
    }
}
