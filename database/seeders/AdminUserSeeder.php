<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::withTrashed()->updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@matixo.com')],
            [
                'name'                 => 'Sistem Yöneticisi',
                'password'             => Hash::make(env('ADMIN_PASSWORD', 'Matixo!2026Admin')),
                'role'                 => 'admin',
                'is_active'            => true,
                'must_change_password' => false,
                'email_verified_at'    => now(),
            ]
        );
        if ($user->trashed()) {
            $user->restore();
        }
    }
}
