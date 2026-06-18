<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Review;
use App\Models\ContactMessage;
use App\Models\ActivityLog;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'products_count'         => Product::count(),
            'active_products_count'  => Product::where('is_active', true)->count(),
            'categories_count'       => Category::count(),
            'pending_reviews_count'  => Review::pending()->count(),
            'unread_messages_count'  => ContactMessage::unread()->count(),
        ];

        $recent_messages = ContactMessage::latest()->limit(5)->get();
        $recent_reviews  = Review::with('product')->latest()->limit(5)->get();
        $recent_logs     = ActivityLog::with('user')->latest('created_at')->limit(10)->get();

        return view('admin.dashboard.index', compact('stats', 'recent_messages', 'recent_reviews', 'recent_logs'));
    }

    public function clearCache()
    {
        \Illuminate\Support\Facades\Artisan::call('cache:clear');
        \Illuminate\Support\Facades\Artisan::call('view:clear');
        \Illuminate\Support\Facades\Artisan::call('config:clear');
        \Illuminate\Support\Facades\Artisan::call('route:clear');

        // Ayrıca özel cache anahtarlarını da temizleyelim
        \Illuminate\Support\Facades\Cache::forget('matixo.settings');
        \Illuminate\Support\Facades\Cache::forget('matixo.languages');
        \Illuminate\Support\Facades\Cache::forget('matixo.headerMenus');
        \Illuminate\Support\Facades\Cache::forget('matixo.footerCategories');
        \Illuminate\Support\Facades\Cache::forget('matixo.footerPages');

        return redirect()->back()->with('success', 'Tüm sistem ve uygulama önbelleği başarıyla temizlendi.');
    }
}
