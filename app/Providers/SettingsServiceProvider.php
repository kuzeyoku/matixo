<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Setting;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class SettingsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Don't run during migrations
        if ($this->app->runningInConsole()) {
            $cmd = $_SERVER['argv'][1] ?? '';
            if (str_starts_with($cmd, 'migrate')) {
                return;
            }
        }

        if (!Schema::hasTable('settings')) {
            return;
        }

        try {
            $settings = Cache::remember('matixo.settings', 3600, function () {
                return Setting::pluck('value', 'key')->toArray();
            });
        } catch (\Throwable $e) {
            return;
        }

        // SMTP override (DB → config)
        if (!empty($settings['smtp_host'])) {
            Config::set('mail.default', 'smtp');
            Config::set('mail.mailers.smtp.host',       $settings['smtp_host']);
            Config::set('mail.mailers.smtp.port',       $settings['smtp_port']       ?? 587);
            Config::set('mail.mailers.smtp.username',   $settings['smtp_username']   ?? null);
            Config::set('mail.mailers.smtp.password',   $settings['smtp_password']   ?? null);
            Config::set('mail.mailers.smtp.encryption', $settings['smtp_encryption'] ?? 'tls');
            Config::set('mail.from.address',            $settings['smtp_from_email'] ?? config('mail.from.address'));
            Config::set('mail.from.name',               $settings['smtp_from_name']  ?? config('mail.from.name'));
        }
    }
}
