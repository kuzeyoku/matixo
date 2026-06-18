<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;

class SettingService
{
    /**
     * Anahtar bazlı toplu kayıt.
     * @param array<string, mixed> $values  ['key' => 'value', ...]
     */
    public function save(array $values): void
    {
        foreach ($values as $key => $value) {
            $row = Setting::where('key', $key)->first();
            if (!$row)
                continue;

            // Resim alanları için MediaService kullan
            if ($row->type === 'image' && request()->hasFile($key)) {
                $value = app(MediaService::class)->handle(
                    request()->file($key),
                    $row->value,
                    config('matixo.media.setting_path')
                );
            } elseif ($row->type === 'image' && request()->boolean($key . '_remove')) {
                app(MediaService::class)->delete($row->value);
                $value = null;
            } elseif ($row->type === 'image' && !request()->hasFile($key)) {
                $value = $row->value; // değişiklik yok
            } elseif ($row->type === 'password' && empty($value)) {
                $value = $row->value; // şifre boş gönderildiyse eski değeri koru
            } elseif (is_array($value)) {
                $value = json_encode($value, JSON_UNESCAPED_UNICODE);
            } elseif (is_bool($value)) {
                $value = $value ? '1' : '0';
            }

            $row->update(['value' => $value]);
        }

        Cache::forget('matixo.settings');
        ActivityLogger::log('update', null, [], 'Sistem ayarları güncellendi');
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return setting($key, $default);
    }

    /**
     * SMTP test maili gönderir.
     */
    public function testSmtp(string $toEmail): array
    {
        try {
            \Illuminate\Support\Facades\Mail::raw(
                "MATIXO panel - SMTP test maili.\n\nBu mail başarıyla gönderildi, SMTP ayarlarınız doğru çalışıyor.",
                function ($m) use ($toEmail) {
                    $m->to($toEmail)->subject('MATIXO - SMTP Test');
                }
            );
            return ['success' => true, 'message' => 'Test maili başarıyla gönderildi: ' . $toEmail];
        } catch (\Throwable $e) {
            return ['success' => false, 'message' => 'SMTP hatası: ' . $e->getMessage()];
        }
    }
}
