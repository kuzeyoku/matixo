<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;

class ReviewController extends Controller
{
    /**
     * Ürün yorumu gönder.
     */
    public function store(Request $request, int $productId)
    {
        $product = Product::active()->findOrFail($productId);

        // ── Rate Limiting: aynı IP'den 5 dakikada 3 yorum ──────────────
        $key = 'review:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            return back()
                ->withInput()
                ->withErrors(['rate_limit' => "Çok fazla yorum gönderdiniz. {$seconds} saniye sonra tekrar deneyin."]);
        }
        RateLimiter::hit($key, 300); // 5 dakika

        // ── Doğrulama ─────────────────────────────────────────────────
        $validated = $request->validate([
            'reviewer_name'  => 'required|string|max:100',
            'reviewer_org'   => 'nullable|string|max:150',
            'reviewer_email' => 'required|email|max:150',
            'rating'         => 'required|integer|min:1|max:5',
            'review_text'    => 'required|string|min:10|max:2000',
            'g-recaptcha-response' => 'nullable|string',
        ], [
            'reviewer_name.required'  => 'Ad Soyad alanı zorunludur.',
            'reviewer_email.required' => 'E-posta alanı zorunludur.',
            'reviewer_email.email'    => 'Geçerli bir e-posta adresi girin.',
            'rating.required'         => 'Lütfen bir puan seçin.',
            'review_text.required'    => 'Yorum alanı boş bırakılamaz.',
            'review_text.min'         => 'Yorum en az 10 karakter olmalıdır.',
        ]);

        // ── reCAPTCHA v3 doğrulaması (key varsa) ─────────────────────
        $siteKey   = env('RECAPTCHA_SITE_KEY');
        $secretKey = env('RECAPTCHA_SECRET_KEY');

        if ($siteKey && $secretKey) {
            $token = $request->input('g-recaptcha-response');
            if (!$token) {
                return back()->withInput()->withErrors(['recaptcha' => 'Güvenlik doğrulaması başarısız. Lütfen tekrar deneyin.']);
            }

            try {
                $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                    'secret'   => $secretKey,
                    'response' => $token,
                    'remoteip' => $request->ip(),
                ]);

                $result = $response->json();

                // v3: score < 0.5 ise bot olarak değerlendir
                if (!($result['success'] ?? false) || ($result['score'] ?? 0) < 0.5) {
                    return back()->withInput()->withErrors(['recaptcha' => 'Güvenlik skoru düşük. Lütfen tekrar deneyin.']);
                }
            } catch (\Throwable $e) {
                // reCAPTCHA servisine ulaşılamıyorsa devam et (ağ hatası)
                \Illuminate\Support\Facades\Log::warning('reCAPTCHA check failed: ' . $e->getMessage());
            }
        }

        // ── Kaydet ───────────────────────────────────────────────────
        Review::create([
            'product_id'     => $product->id,
            'reviewer_name'  => $validated['reviewer_name'],
            'reviewer_org'   => $validated['reviewer_org'] ?? null,
            'reviewer_email' => $validated['reviewer_email'],
            'rating'         => $validated['rating'],
            'review_text'    => $validated['review_text'],
            'ip_address'     => $request->ip(),
            'status'         => 'pending',
        ]);

        return back()->with('review_success', __('Yorumunuz alındı. Onaylandıktan sonra yayınlanacaktır.'));
    }
}
