<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogger
{
    public static function log(string $action, ?Model $subject = null, array $properties = [], ?string $description = null): ActivityLog
    {
        return ActivityLog::create([
            'user_id'      => Auth::id(),
            'action'       => $action,
            'subject_type' => $subject ? get_class($subject) : null,
            'subject_id'   => $subject?->getKey(),
            'description'  => $description ?? static::describe($action, $subject),
            'properties'   => $properties ?: null,
            'ip_address'   => Request::ip(),
            'user_agent'   => substr((string) Request::userAgent(), 0, 500),
            'created_at'   => now(),
        ]);
    }

    public static function login(int $userId): void
    {
        ActivityLog::create([
            'user_id'    => $userId,
            'action'     => 'login',
            'description'=> 'Kullanıcı giriş yaptı',
            'ip_address' => Request::ip(),
            'user_agent' => substr((string) Request::userAgent(), 0, 500),
            'created_at' => now(),
        ]);
    }

    public static function logout(?int $userId): void
    {
        ActivityLog::create([
            'user_id'    => $userId,
            'action'     => 'logout',
            'description'=> 'Kullanıcı çıkış yaptı',
            'ip_address' => Request::ip(),
            'user_agent' => substr((string) Request::userAgent(), 0, 500),
            'created_at' => now(),
        ]);
    }

    public static function failedLogin(string $email): void
    {
        ActivityLog::create([
            'user_id'    => null,
            'action'     => 'failed_login',
            'description'=> 'Başarısız giriş denemesi: ' . $email,
            'properties' => ['email' => $email],
            'ip_address' => Request::ip(),
            'user_agent' => substr((string) Request::userAgent(), 0, 500),
            'created_at' => now(),
        ]);
    }

    protected static function describe(string $action, ?Model $subject): string
    {
        $type = $subject ? class_basename($subject) : '';
        return match ($action) {
            'create'        => "{$type} oluşturuldu",
            'update'        => "{$type} güncellendi",
            'delete'        => "{$type} silindi",
            'toggle_status' => "{$type} durumu değiştirildi",
            default         => $action,
        };
    }
}
