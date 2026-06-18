<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // ── Site ────────────────────────────────────────────
            ['key' => 'site_name',          'value' => 'MATIXO',                                    'type' => 'text',     'group' => 'site',    'label' => 'Site Adı'],
            ['key' => 'site_tagline',       'value' => 'Eğitim & Müze Ekipmanları',                 'type' => 'text',     'group' => 'site',    'label' => 'Slogan'],
            ['key' => 'site_logo',          'value' => null,                                         'type' => 'image',    'group' => 'site',    'label' => 'Logo'],
            ['key' => 'site_favicon',       'value' => null,                                         'type' => 'image',    'group' => 'site',    'label' => 'Favicon'],
            ['key' => 'footer_about',       'value' => 'Eğitim mekanlarını tasarlayan, bilim ve matematik parkları üreten öncü firma.', 'type' => 'textarea', 'group' => 'site', 'label' => 'Footer Hakkında Metni'],
            ['key' => 'copyright',          'value' => '© 2026 MATIXO. Tüm hakları saklıdır.',      'type' => 'text',     'group' => 'site',    'label' => 'Copyright'],
            ['key' => 'maintenance_mode',   'value' => '0',                                          'type' => 'boolean',  'group' => 'site',    'label' => 'Bakım Modu'],

            // ── İletişim ────────────────────────────────────────
            ['key' => 'contact_phone',      'value' => '+90 555 555 55 55',                          'type' => 'text',     'group' => 'contact', 'label' => 'Telefon'],
            ['key' => 'contact_whatsapp',   'value' => '905555555555',                               'type' => 'text',     'group' => 'contact', 'label' => 'WhatsApp Numarası'],
            ['key' => 'contact_email',      'value' => 'info@matixo.com',                            'type' => 'text',     'group' => 'contact', 'label' => 'E-posta'],
            ['key' => 'contact_address',    'value' => 'İstanbul / Türkiye',                         'type' => 'textarea', 'group' => 'contact', 'label' => 'Adres'],
            ['key' => 'working_hours',      'value' => 'Pzt–Cum: 09:00–18:00',                       'type' => 'text',     'group' => 'contact', 'label' => 'Çalışma Saatleri'],
            ['key' => 'google_maps_iframe', 'value' => null,                                          'type' => 'textarea', 'group' => 'contact', 'label' => 'Google Maps Embed'],

            // ── Sosyal Medya ────────────────────────────────────
            ['key' => 'social_instagram',   'value' => 'https://instagram.com/matixo',               'type' => 'text',     'group' => 'social',  'label' => 'Instagram'],
            ['key' => 'social_facebook',    'value' => null,                                          'type' => 'text',     'group' => 'social',  'label' => 'Facebook'],
            ['key' => 'social_linkedin',    'value' => 'https://linkedin.com/company/matixo',        'type' => 'text',     'group' => 'social',  'label' => 'LinkedIn'],
            ['key' => 'social_twitter',     'value' => null,                                          'type' => 'text',     'group' => 'social',  'label' => 'Twitter/X'],
            ['key' => 'social_youtube',     'value' => null,                                          'type' => 'text',     'group' => 'social',  'label' => 'YouTube'],

            // ── SMTP ────────────────────────────────────────────
            ['key' => 'smtp_host',          'value' => null, 'type' => 'text',     'group' => 'smtp', 'label' => 'SMTP Host'],
            ['key' => 'smtp_port',          'value' => '587','type' => 'text',     'group' => 'smtp', 'label' => 'SMTP Port'],
            ['key' => 'smtp_encryption',    'value' => 'tls','type' => 'text',     'group' => 'smtp', 'label' => 'Şifreleme (tls/ssl)'],
            ['key' => 'smtp_username',      'value' => null, 'type' => 'text',     'group' => 'smtp', 'label' => 'SMTP Kullanıcı'],
            ['key' => 'smtp_password',      'value' => null, 'type' => 'password', 'group' => 'smtp', 'label' => 'SMTP Şifre'],
            ['key' => 'smtp_from_email',    'value' => 'noreply@matixo.com', 'type' => 'text', 'group' => 'smtp', 'label' => 'Gönderen E-posta'],
            ['key' => 'smtp_from_name',     'value' => 'MATIXO',             'type' => 'text', 'group' => 'smtp', 'label' => 'Gönderen Ad'],

            // ── Bildirim ────────────────────────────────────────
            ['key' => 'notify_emails',       'value' => 'admin@matixo.com', 'type' => 'text',    'group' => 'notification', 'label' => 'Bildirim Alacak E-postalar'],
            ['key' => 'notify_new_message',  'value' => '1',                'type' => 'boolean', 'group' => 'notification', 'label' => 'Yeni Mesaj Bildirimi'],
            ['key' => 'notify_new_review',   'value' => '1',                'type' => 'boolean', 'group' => 'notification', 'label' => 'Yeni Yorum Bildirimi'],

            // ── SEO ─────────────────────────────────────────────
            ['key' => 'seo_meta_title',         'value' => 'MATIXO | Açık Hava Bilim & Matematik Parkları', 'type' => 'text',     'group' => 'seo', 'label' => 'Varsayılan Meta Başlık'],
            ['key' => 'seo_meta_description',   'value' => 'MATIXO - Açık Hava Bilim Parkları, Montessöri Materyalleri, Müze Ekipmanları.', 'type' => 'textarea', 'group' => 'seo', 'label' => 'Varsayılan Meta Açıklama'],
            ['key' => 'seo_og_image',           'value' => null, 'type' => 'image', 'group' => 'seo', 'label' => 'Varsayılan OG Image'],
            ['key' => 'seo_google_verification','value' => null, 'type' => 'text',  'group' => 'seo', 'label' => 'Google Site Verification'],
            ['key' => 'seo_ga4_id',             'value' => null, 'type' => 'text',  'group' => 'seo', 'label' => 'Google Analytics 4 ID'],
            ['key' => 'seo_gtm_id',             'value' => null, 'type' => 'text',  'group' => 'seo', 'label' => 'Google Tag Manager ID'],

            // ── Anasayfa Düzeni ─────────────────────────────────
            ['key' => 'home_show_slider',     'value' => '1', 'type' => 'boolean', 'group' => 'homepage', 'label' => 'Slider'],
            ['key' => 'home_show_categories', 'value' => '1', 'type' => 'boolean', 'group' => 'homepage', 'label' => 'Kategoriler (Bento)'],
            ['key' => 'home_show_featured',   'value' => '1', 'type' => 'boolean', 'group' => 'homepage', 'label' => 'Öne Çıkan Ürünler'],
            ['key' => 'home_show_campaign',   'value' => '1', 'type' => 'boolean', 'group' => 'homepage', 'label' => 'Kampanya Bölümü'],
            ['key' => 'home_show_why',        'value' => '1', 'type' => 'boolean', 'group' => 'homepage', 'label' => 'Neden Biz'],
            ['key' => 'home_show_stats',      'value' => '1', 'type' => 'boolean', 'group' => 'homepage', 'label' => 'İstatistikler'],
            ['key' => 'home_show_references', 'value' => '1', 'type' => 'boolean', 'group' => 'homepage', 'label' => 'Referanslar'],
            ['key' => 'home_featured_count',  'value' => '8', 'type' => 'text',    'group' => 'homepage', 'label' => 'Öne Çıkan Ürün Adedi'],

            // İstatistikler 4 sayısı
            ['key' => 'stat_1_number', 'value' => '120', 'type' => 'text', 'group' => 'homepage', 'label' => 'İstatistik 1 - Sayı'],
            ['key' => 'stat_1_label',  'value' => 'Tamamlanan Proje', 'type' => 'text', 'group' => 'homepage', 'label' => 'İstatistik 1 - Etiket'],
            ['key' => 'stat_2_number', 'value' => '85',  'type' => 'text', 'group' => 'homepage', 'label' => 'İstatistik 2 - Sayı'],
            ['key' => 'stat_2_label',  'value' => 'Mutlu Müşteri',    'type' => 'text', 'group' => 'homepage', 'label' => 'İstatistik 2 - Etiket'],
            ['key' => 'stat_3_number', 'value' => '15',  'type' => 'text', 'group' => 'homepage', 'label' => 'İstatistik 3 - Sayı'],
            ['key' => 'stat_3_label',  'value' => 'Yıllık Tecrübe',   'type' => 'text', 'group' => 'homepage', 'label' => 'İstatistik 3 - Etiket'],
            ['key' => 'stat_4_number', 'value' => '50',  'type' => 'text', 'group' => 'homepage', 'label' => 'İstatistik 4 - Sayı'],
            ['key' => 'stat_4_label',  'value' => 'Şehir',            'type' => 'text', 'group' => 'homepage', 'label' => 'İstatistik 4 - Etiket'],
        ];

        $i = 0;
        foreach ($settings as $s) {
            Setting::updateOrCreate(
                ['key' => $s['key']],
                array_merge($s, ['sort_order' => $i++])
            );
        }
    }
}
