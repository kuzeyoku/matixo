<?php

namespace Database\Seeders;

use App\Models\Slider;
use App\Models\Campaign;
use App\Models\Reference;
use Illuminate\Database\Seeder;

class DemoContentSeeder extends Seeder
{
    public function run(): void
    {
        // Demo Slider
        $slider = Slider::withTrashed()->updateOrCreate(
            ['id' => 1],
            [
                'title'      => ['tr' => 'Eğitim Mekanlarını Tasarlıyoruz', 'en' => 'We Design Educational Spaces'],
                'subtitle'   => ['tr' => 'Bilim parkları, müze ekipmanları ve özel üretim projeler.', 'en' => 'Science parks, museum equipment and custom projects.'],
                'badge_text' => ['tr' => 'Özel Üretim Projeler',          'en' => 'Custom Projects'],
                'image'      => 'slider-placeholder.jpg',
                'link_url'   => '/kategoriler',
                'button_text'=> ['tr' => 'Keşfet',                          'en' => 'Discover'],
                'is_active'  => true,
                'sort_order' => 0,
            ]
        );
        if ($slider->trashed()) {
            $slider->restore();
        }

        // Kampanya Modal
        Campaign::updateOrCreate(
            ['type' => 'modal'],
            [
                'title'          => ['tr' => 'Yeni Eğitim Yılına',              'en' => 'For the New Academic Year'],
                'highlight_word' => ['tr' => 'Özel Avantajlar',                  'en' => 'Special Advantages'],
                'description'    => ['tr' => 'Açık hava bilim parkları, matematik atölyeleri ve montessöri materyallerinde sezon başına özel avantajlardan yararlanın.', 'en' => 'Take advantage of season-special discounts on outdoor science parks, math workshops and Montessori materials.'],
                'perks'          => [
                    ['text' => ['tr' => 'Ücretsiz keşif ve 3D yerleşim planı', 'en' => 'Free survey and 3D layout plan']],
                    ['text' => ['tr' => 'Toplu projelerde özel iskonto',        'en' => 'Bulk project discounts']],
                    ['text' => ['tr' => '2 yıl yapısal garanti + kurulum dahil','en' => '2-year structural warranty + installation']],
                ],
                'button_text' => ['tr' => "WhatsApp'tan Teklif Al", 'en' => 'Get Quote on WhatsApp'],
                'button_url'  => 'https://wa.me/905555555555',
                'valid_until' => '2026-03-31',
                'is_active'   => true,
            ]
        );

        // Referanslar
        $refs = ['İstanbul Büyükşehir', 'Ankara Büyükşehir', 'Bilim Lisesi A.Ş.', 'TÜBİTAK', 'Türk Telekom', 'MEB'];
        foreach ($refs as $i => $name) {
            Reference::updateOrCreate(
                ['name' => $name],
                ['logo' => null, 'sort_order' => $i, 'is_active' => true]
            );
        }
    }
}
