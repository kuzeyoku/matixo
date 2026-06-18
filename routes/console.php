<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Aktivite log temizliği — her gün gece yarısı 90 günden eski logları sil
Schedule::command('activity:prune')->dailyAt('02:00');
