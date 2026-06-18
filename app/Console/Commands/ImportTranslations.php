<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\TranslationLoader\LanguageLine;

class ImportTranslations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'matixo:import-translations {--overwrite : Overwrite existing translations in the database}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import PHP translation files under the lang directory into the database';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $langPath = base_path('lang');
        if (!is_dir($langPath)) {
            $this->error("Lang directory not found at: {$langPath}");
            return 1;
        }

        $overwrite = $this->option('overwrite');
        $importedCount = 0;

        // Scan locale folders (e.g., tr, en)
        $locales = array_filter(glob($langPath . '/*'), 'is_dir');

        foreach ($locales as $localeDir) {
            $locale = basename($localeDir);
            
            // Find all PHP files in this locale directory
            $files = glob($localeDir . '/*.php');
            
            foreach ($files as $file) {
                $group = pathinfo($file, PATHINFO_FILENAME);
                
                // Exclude some built-in laravel files if we don't want them, but actually importing them is fine.
                // Let's import everything, or we can focus on 'site' or any custom groups.
                // Importing everything under lang/ is cleaner and more complete.
                try {
                    $translations = include $file;
                    if (!is_array($translations)) {
                        continue;
                    }
                    
                    foreach ($translations as $key => $value) {
                        // We only import string translations for now (nested array translation files are not used in Matixo site)
                        if (!is_string($value)) {
                            continue;
                        }
                        
                        $languageLine = LanguageLine::firstOrNew([
                            'group' => $group,
                            'key' => $key,
                        ]);
                        
                        $text = $languageLine->text ?? [];
                        
                        // If overwrite is false and this locale already has a translation, skip
                        if (isset($text[$locale]) && !$overwrite) {
                            continue;
                        }
                        
                        $text[$locale] = $value;
                        $languageLine->text = $text;
                        $languageLine->save();
                        $importedCount++;
                    }
                } catch (\Throwable $e) {
                    $this->error("Failed to import file: {$file}. Error: {$e->getMessage()}");
                }
            }
        }

        $this->info("Successfully imported/updated {$importedCount} translation strings into the database.");
        return 0;
    }
}
