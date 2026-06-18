<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Site\{
    HomeController, CategoryController, ProductController,
    PageController, ContactController, ReviewController, SitemapController
};

/*
|--------------------------------------------------------------------------
| Site (Public) Rotaları
|--------------------------------------------------------------------------
*/

// ── Anasayfa ──────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');

// ── Ürünler ───────────────────────────────────────
Route::get('/urunler',        [ProductController::class, 'index'])->name('products.index');
Route::get('/urun/{slug}',    [ProductController::class, 'show'])->name('products.show');

// ── Kategoriler ───────────────────────────────────
Route::get('/kategoriler',        [CategoryController::class, 'index'])->name('categories.index');
Route::get('/kategori/{slug}',    [CategoryController::class, 'show'])->name('categories.show');

// ── İletişim ──────────────────────────────────────
Route::get('/iletisim',  [ContactController::class, 'index'])->name('contact');
Route::post('/iletisim', [ContactController::class, 'store'])->name('contact.store');

// ── Yorum gönder ──────────────────────────────────
Route::post('/yorum/{product}', [ReviewController::class, 'store'])->name('reviews.store');

// ── Sitemap ───────────────────────────────────────
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// ── AI LLM Guide ──────────────────────────────────
Route::get('/llms.txt', [SitemapController::class, 'llms'])->name('llms');

// ── Dil Değiştirme Rotaları ───────────────────────
Route::get('/lang/{locale}', function ($locale) {
    $codes = active_languages()->pluck('code')->toArray();
    if (in_array($locale, $codes, true)) {
        session(['locale' => $locale]);
        app()->setLocale($locale);
    }
    return redirect()->back();
})->name('lang.switch');

// ── Dinamik Sayfalar (Hakkımızda, Gizlilik vb.) ──
// Bu rota en sonda olmalı, slug catch-all gibi davranır.
Route::get('/sayfa/{slug}', [PageController::class, 'show'])->name('pages.show');
