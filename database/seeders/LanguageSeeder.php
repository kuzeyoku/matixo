<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    public function run(): void
    {
        foreach (config('matixo.languages_default', []) as $i => $lang) {
            Language::updateOrCreate(
                ['code' => $lang['code']],
                array_merge($lang, ['is_active' => true, 'sort_order' => $i])
            );
        }
    }
}
