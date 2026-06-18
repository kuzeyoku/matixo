<?php

use Illuminate\Support\Facades\Cache;
use App\Models\Setting;

if (!function_exists('setting')) {
    /**
     * DB'den ayar değerini cache ile getirir.
     */
    function setting(string $key, mixed $default = null): mixed
    {
        $settings = Cache::remember('matixo.settings', 3600, function () {
            try {
                return Setting::pluck('value', 'key')->toArray();
            } catch (\Throwable $e) {
                return [];
            }
        });

        $value = $settings[$key] ?? $default;

        // JSON ise decode et
        if (is_string($value) && (str_starts_with($value, '{') || str_starts_with($value, '['))) {
            $decoded = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                return $decoded;
            }
        }

        return $value;
    }
}

if (!function_exists('clear_settings_cache')) {
    function clear_settings_cache(): void
    {
        Cache::forget('matixo.settings');
    }
}

if (!function_exists('active_languages')) {
    /**
     * Aktif diller listesini cache ile getirir.
     */
    function active_languages(): \Illuminate\Support\Collection
    {
        return Cache::remember('matixo.languages', 3600, function () {
            try {
                return \App\Models\Language::where('is_active', true)->orderBy('sort_order')->get();
            } catch (\Throwable $e) {
                return collect();
            }
        });
    }
}

if (!function_exists('default_locale')) {
    function default_locale(): string
    {
        $lang = active_languages()->firstWhere('is_default', true);
        return $lang->code ?? config('app.locale', 'tr');
    }
}

if (!function_exists('admin_asset')) {
    /**
     * Admin panel asset (cache-busted version).
     */
    function admin_asset(string $path): string
    {
        $full = public_path($path);
        $v = file_exists($full) ? filemtime($full) : time();
        return asset($path) . '?v=' . $v;
    }
}

if (!function_exists('gt')) {
    /**
     * Modelin aktif dildeki çevirisini getirir, yoksa varsayılan dile (veya ilk bulduğuna) düşer.
     */
    function gt($model, string $field): string
    {
        if (!$model) {
            return '';
        }
        if (method_exists($model, 'getTranslation')) {
            $locale = app()->getLocale();
            $val = $model->getTranslation($field, $locale);
            if ($val !== null && $val !== '') {
                return (string) $val;
            }
            $def = default_locale();
            if ($locale !== $def) {
                $val = $model->getTranslation($field, $def);
                if ($val !== null && $val !== '') {
                    return (string) $val;
                }
            }
            // Hala boşsa ilk mevcut çeviriyi döndür
            $translations = $model->getTranslations($field);
            if (!empty($translations)) {
                $first = reset($translations);
                if ($first !== null && $first !== '') {
                    return (string) $first;
                }
            }
        }
        return (string) ($model->$field ?? '');
    }
}
