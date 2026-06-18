<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $r)
    {
        $items = User::query()
            ->when($r->search, fn($q, $s) => $q->where(fn($x) => $x
                ->where('name', 'like', "%{$s}%")
                ->orWhere('email', 'like', "%{$s}%")))
            ->latest()->paginate(20)->withQueryString();

        return view('admin.users.index', ['items' => $items, 'filters' => $r->all()]);
    }

    public function create() { return view('admin.users.create'); }

    public function store(Request $r)
    {
        $data = $this->validateData($r);
        $data['password'] = Hash::make($data['password']);
        $data['email_verified_at'] = now();
        $user = User::create($data);
        ActivityLogger::log('create', $user);
        return redirect()->route('admin.users.index')->with('success', 'Kullanıcı eklendi.');
    }

    public function edit(int $id)
    {
        return view('admin.users.edit', ['item' => User::findOrFail($id)]);
    }

    public function update(Request $r, int $id)
    {
        $user = User::findOrFail($id);
        $data = $this->validateData($r, $id);
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        $user->update($data);
        ActivityLogger::log('update', $user);
        return redirect()->route('admin.users.index')->with('success', 'Kullanıcı güncellendi.');
    }

    public function destroy(int $id)
    {
        if ((int) auth()->id() === $id) {
            return back()->with('error', 'Kendi hesabınızı silemezsiniz.');
        }
        $user = User::findOrFail($id);
        ActivityLogger::log('delete', $user);
        $user->delete();
        return back()->with('success', 'Kullanıcı silindi.');
    }

    public function toggle(int $id)
    {
        if ((int) auth()->id() === $id) {
            return back()->with('error', 'Kendi hesabınızı kapatamazsınız.');
        }
        $user = User::findOrFail($id);
        $user->update(['is_active' => !$user->is_active]);
        ActivityLogger::log('toggle_status', $user);
        return back()->with('success', 'Kullanıcı durumu güncellendi.');
    }

    public function unlock(int $id)
    {
        $user = User::findOrFail($id);
        $user->update(['locked_until' => null, 'failed_login_count' => 0]);
        ActivityLogger::log('unlock', $user, null, 'Hesap kilidi açıldı');
        return back()->with('success', 'Hesap kilidi açıldı.');
    }

    protected function validateData(Request $r, ?int $userId = null): array
    {
        $passwordRules = $userId
            ? ['nullable', 'string', 'min:10']
            : ['required', 'string', 'min:10'];

        return $r->validate([
            'name'      => ['required', 'string', 'max:191'],
            'email'     => ['required', 'email', 'max:191', Rule::unique('users')->ignore($userId)->whereNull('deleted_at')],
            'password'  => $passwordRules,
            'role'      => ['required', 'in:admin'],
            'is_active' => ['nullable', 'boolean'],
        ], [], [
            'name' => 'Ad Soyad', 'email' => 'E-posta', 'password' => 'Şifre',
        ]);
    }
}
