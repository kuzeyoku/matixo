<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $r)
    {
        $items = ActivityLog::with('user')
            ->when($r->user_id, fn($q, $u) => $q->where('user_id', $u))
            ->when($r->action,  fn($q, $a) => $q->where('action', $a))
            ->when($r->search,  fn($q, $s) => $q->where('description', 'like', "%{$s}%"))
            ->latest('created_at')
            ->paginate(50)
            ->withQueryString();

        return view('admin.activity.index', ['items' => $items, 'filters' => $r->all()]);
    }

    public function clear()
    {
        ActivityLog::truncate();
        return redirect()->route('admin.activity.index')->with('success', 'Tüm aktivite logları başarıyla temizlendi.');
    }
}
