<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['icon' => 'bi-palette',             'tr' => 'Proje Grafik & Tasarım',         'en' => 'Project Graphic & Design',     'bento' => 'lg', 'home' => true],
            ['icon' => 'bi-tree',                'tr' => 'Açık Hava Bilim Parkları',       'en' => 'Outdoor Science Parks',        'bento' => 'lg', 'home' => true],
            ['icon' => 'bi-puzzle',              'tr' => 'Montessöri Materyalleri',        'en' => 'Montessori Materials',         'bento' => 'md', 'home' => true],
            ['icon' => 'bi-buildings',           'tr' => 'Kent Ekipmanları',               'en' => 'Urban Equipment',              'bento' => 'md', 'home' => true],
            ['icon' => 'bi-sign-stop',           'tr' => 'Müze Tabela / Totem',            'en' => 'Museum Signage / Totem',       'bento' => 'sm', 'home' => false],
            ['icon' => 'bi-calculator',          'tr' => 'Açık Hava Matematik Parkları',   'en' => 'Outdoor Math Parks',           'bento' => 'sm', 'home' => true],
            ['icon' => 'bi-building',            'tr' => 'Müze Binaları',                  'en' => 'Museum Buildings',             'bento' => 'sm', 'home' => false],
            ['icon' => 'bi-123',                 'tr' => 'Matematik Müzeleri',             'en' => 'Math Museums',                 'bento' => 'sm', 'home' => false],
            ['icon' => 'bi-layout-text-window',  'tr' => 'Maket Müzeler',                  'en' => 'Model Museums',                'bento' => 'sm', 'home' => false],
            ['icon' => 'bi-tools',               'tr' => 'Matematik Atölyeleri',           'en' => 'Math Workshops',               'bento' => 'sm', 'home' => false],
            ['icon' => 'bi-box',                 'tr' => 'Ahşap Dekoratif Ürünler',        'en' => 'Wooden Decorative Products',   'bento' => 'sm', 'home' => false],
        ];

        foreach ($categories as $i => $c) {
            $category = Category::withTrashed()->updateOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($c['tr'])],
                [
                    'name'         => ['tr' => $c['tr'], 'en' => $c['en']],
                    'icon'         => $c['icon'],
                    'sort_order'   => $i,
                    'is_active'    => true,
                    'show_on_home' => $c['home'],
                    'bento_size'   => $c['bento'],
                ]
            );
            if ($category->trashed()) {
                $category->restore();
            }
        }
    }
}
