<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            LanguageSeeder::class,
            TranslationSeeder::class,
            AdminUserSeeder::class,
            SettingSeeder::class,
            CategorySeeder::class,
            DemoContentSeeder::class,
            FaqSeeder::class,
        ]);
    }
}
