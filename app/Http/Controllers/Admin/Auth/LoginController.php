<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        // Honeypot — bot doldurduysa hata göster
        if ($request->filled('website')) {
            return back()->withErrors(['email' => 'Bir hata oluştu.']);
        }

        $data = $request->validate([
            'email'                => ['required', 'string', 'email', 'max:191'],
            'password'             => ['required', 'string', 'min:6'],
            'remember'             => ['nullable', 'boolean'],
            'g-recaptcha-response' => ['nullable', 'string'],
        ], [], [
            'email'    => 'E-posta',
            'password' => 'Şifre',
        ]);

        // reCAPTCHA v3 validation if keys exist
        $siteKey   = env('RECAPTCHA_SITE_KEY');
        $secretKey = env('RECAPTCHA_SECRET_KEY');
        if ($siteKey && $secretKey) {
            $token = $request->input('g-recaptcha-response');
            if (!$token) {
                ActivityLogger::failedLogin($data['email']);
                throw ValidationException::withMessages([
                    'email' => 'Güvenlik doğrulaması başarısız. Lütfen tekrar deneyin.',
                ]);
            }
            try {
                $response = \Illuminate\Support\Facades\Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                    'secret'   => $secretKey,
                    'response' => $token,
                    'remoteip' => $request->ip()
                ]);
                $resData = $response->json();
                if (!$response->successful() || !($resData['success'] ?? false) || ($resData['score'] ?? 0) < 0.5) {
                    ActivityLogger::failedLogin($data['email']);
                    throw ValidationException::withMessages([
                        'email' => 'Güvenlik doğrulaması başarısız. Bot koruma skoru düşük.',
                    ]);
                }
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::warning('reCAPTCHA login check failed: ' . $e->getMessage());
            }
        }

        $key = mb_strtolower($data['email']) . '|' . $request->ip();
        $maxAttempts = config('matixo.login.max_attempts', 5);

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);
            ActivityLogger::failedLogin($data['email']);
            throw ValidationException::withMessages([
                'email' => sprintf('Çok fazla deneme. %d saniye sonra tekrar deneyin.', $seconds),
            ]);
        }

        $user = User::where('email', $data['email'])->first();

        if (!$user) {
            RateLimiter::hit($key, 60);
            ActivityLogger::failedLogin($data['email']);
            throw ValidationException::withMessages(['email' => 'Geçersiz e-posta veya şifre.']);
        }

        if (!$user->is_active) {
            ActivityLogger::failedLogin($data['email']);
            throw ValidationException::withMessages(['email' => 'Hesabınız devre dışı bırakılmış.']);
        }

        if ($user->isLocked()) {
            ActivityLogger::failedLogin($data['email']);
            $mins = (int) now()->diffInMinutes($user->locked_until, false);
            throw ValidationException::withMessages([
                'email' => "Hesabınız {$mins} dakika boyunca kilitli. Daha sonra tekrar deneyin.",
            ]);
        }

        if (!Hash::check($data['password'], $user->password)) {
            RateLimiter::hit($key, 60);
            $user->recordFailedLogin();
            ActivityLogger::failedLogin($data['email']);
            throw ValidationException::withMessages(['email' => 'Geçersiz e-posta veya şifre.']);
        }

        if (!$user->isAdmin()) {
            throw ValidationException::withMessages(['email' => 'Bu alana erişim yetkiniz yok.']);
        }

        // Başarılı giriş
        RateLimiter::clear($key);
        Auth::login($user, (bool) $request->boolean('remember'));
        $request->session()->regenerate();
        $user->recordSuccessfulLogin($request->ip());
        ActivityLogger::login($user->id);

        return redirect()->intended(route('admin.dashboard'))
            ->with('success', 'Hoş geldiniz, ' . $user->name . '!');
    }

    public function logout(Request $request): RedirectResponse
    {
        $userId = Auth::id();
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        ActivityLogger::logout($userId);
        return redirect()->route('login')->with('success', 'Çıkış yapıldı.');
    }
}
