<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'is_active', 'avatar', 'must_change_password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at'    => 'datetime',
            'password'             => 'hashed',
            'is_active'            => 'boolean',
            'must_change_password' => 'boolean',
            'last_login_at'        => 'datetime',
            'locked_until'         => 'datetime',
            'failed_login_count'   => 'integer',
        ];
    }

    public function isLocked(): bool
    {
        return $this->locked_until && $this->locked_until->isFuture();
    }

    public function recordSuccessfulLogin(string $ip): void
    {
        $this->update([
            'last_login_at'      => now(),
            'last_login_ip'      => $ip,
            'failed_login_count' => 0,
            'locked_until'       => null,
        ]);
    }

    public function recordFailedLogin(): void
    {
        $this->increment('failed_login_count');
        $max = config('matixo.login.max_attempts', 5);

        if ($this->failed_login_count >= $max) {
            $this->update([
                'locked_until' => Carbon::now()->addMinutes(
                    config('matixo.login.lockout_minutes', 15)
                ),
            ]);
        }
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
