<?php

namespace App\Console\Commands;

use App\Models\ActivityLog;
use Illuminate\Console\Command;

class PruneActivityLogs extends Command
{
    protected $signature = 'activity:prune {--days= : Saklama günü}';

    protected $description = 'Eski aktivite loglarını siler (varsayılan: 90 gün)';

    public function handle(): int
    {
        $days = (int) ($this->option('days') ?: config('matixo.activity_log_retention_days', 90));
        $cutoff = now()->subDays($days);

        $count = ActivityLog::where('created_at', '<', $cutoff)->delete();

        $this->info("{$count} aktivite logu silindi (>{$days} günden eski).");
        return self::SUCCESS;
    }
}
