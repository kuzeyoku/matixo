<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Mail\NewContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * İletişim sayfasını göster.
     */
    public function index()
    {
        $faqs = \App\Models\Faq::whereNull('product_id')
            ->where('is_active', true)
            ->ordered()
            ->get();

        return view('site.contact', compact('faqs'));
    }

    /**
     * İletişim formunu gönder.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'                 => 'required|string|max:100',
            'email'                => 'required|email|max:150',
            'phone'                => 'nullable|string|max:30',
            'subject'              => 'required|string|max:200',
            'message'              => 'required|string|max:5000',
            'g-recaptcha-response' => 'nullable|string',
        ]);

        // ── reCAPTCHA v3 doğrulaması (key varsa) ─────────────────────
        $siteKey   = env('RECAPTCHA_SITE_KEY');
        $secretKey = env('RECAPTCHA_SECRET_KEY');

        if ($siteKey && $secretKey) {
            $token = $request->input('g-recaptcha-response');
            if (!$token) {
                return back()->withInput()->withErrors(['g-recaptcha-response' => __('Güvenlik doğrulaması başarısız. Lütfen tekrar deneyin.')]);
            }

            try {
                $response = \Illuminate\Support\Facades\Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                    'secret'   => $secretKey,
                    'response' => $token,
                    'remoteip' => $request->ip()
                ]);

                $resData = $response->json();

                if (!$response->successful() || !($resData['success'] ?? false) || ($resData['score'] ?? 0) < 0.5) {
                    return back()->withInput()->withErrors(['g-recaptcha-response' => __('Güvenlik skoru düşük. Lütfen tekrar deneyin.')]);
                }
            } catch (\Throwable $e) {
                // reCAPTCHA servisine ulaşılamıyorsa devam et (ağ hatası vb.)
                \Illuminate\Support\Facades\Log::warning('reCAPTCHA check failed: ' . $e->getMessage());
            }
        }

        $messageInstance = ContactMessage::create(array_merge($validated, [
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]));

        // SMTP Bildirim Gönderimi
        if (setting('notify_new_message', '1') == '1') {
            $emailsStr = setting('notify_emails');
            if ($emailsStr) {
                $emails = array_filter(array_map('trim', explode(',', $emailsStr)));
                if (!empty($emails)) {
                    try {
                        Mail::to($emails)->send(new NewContactMessage($messageInstance));
                    } catch (\Throwable $e) {
                        \Illuminate\Support\Facades\Log::error('SMTP Notification Error: ' . $e->getMessage());
                    }
                }
            }
        }

        return back()->with('success', __('Mesajınız başarıyla gönderildi. En kısa sürede dönüş yapacağız.'));
    }
}
