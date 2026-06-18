<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $r)
    {
        $items = Review::with('product')
            ->when($r->status, fn($q, $s) => $q->where('status', $s))
            ->when($r->search, fn($q, $s) => $q->where(fn($x) => $x
                ->where('reviewer_name', 'like', "%{$s}%")
                ->orWhere('reviewer_org', 'like', "%{$s}%")))
            ->latest()->paginate(25)->withQueryString();

        return view('admin.reviews.index', ['items' => $items, 'filters' => $r->all()]);
    }

    public function show(int $id)
    {
        $item = Review::with('product')->findOrFail($id);
        return view('admin.reviews.show', ['item' => $item]);
    }

    public function approve(int $id)
    {
        $r = Review::findOrFail($id);
        $r->approve();
        ActivityLogger::log('approve', $r);
        return back()->with('success', 'Yorum onaylandı.');
    }

    public function reject(int $id)
    {
        $r = Review::findOrFail($id);
        $r->reject();
        ActivityLogger::log('reject', $r);
        return back()->with('success', 'Yorum reddedildi.');
    }

    public function destroy(int $id)
    {
        $r = Review::findOrFail($id);
        ActivityLogger::log('delete', $r);
        $r->delete();
        return back()->with('success', 'Yorum silindi.');
    }
}
