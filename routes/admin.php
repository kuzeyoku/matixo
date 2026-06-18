<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
    DashboardController, CategoryController, ProductController, SliderController,
    CampaignController, ReferenceController, ReviewController, PageController,
    MessageController, SettingController, UserController, LanguageController,
    ActivityLogController, MenuController, TranslationController, FaqController
};

Route::middleware(['admin'])->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('cache/clear', [DashboardController::class, 'clearCache'])->name('cache.clear');

    /* ── Katalog ─────────────────────────────────────── */
    Route::patch('categories/reorder', [CategoryController::class, 'reorder'])->name('categories.reorder');
    Route::patch('categories/{id}/toggle', [CategoryController::class, 'toggle'])->name('categories.toggle');
    Route::resource('categories', CategoryController::class)->except(['show']);

    Route::patch('products/reorder', [ProductController::class, 'reorder'])->name('products.reorder');
    Route::patch('products/{id}/toggle', [ProductController::class, 'toggle'])->name('products.toggle');
    Route::resource('products', ProductController::class)->except(['show']);

    Route::patch('faqs/reorder', [FaqController::class, 'reorder'])->name('faqs.reorder');
    Route::patch('faqs/{id}/toggle', [FaqController::class, 'toggle'])->name('faqs.toggle');
    Route::resource('faqs', FaqController::class)->except(['show']);

    /* ── Yorumlar ────────────────────────────────────── */
    Route::get('reviews',                [ReviewController::class, 'index'])->name('reviews.index');
    Route::get('reviews/{id}',           [ReviewController::class, 'show'])->name('reviews.show');
    Route::patch('reviews/{id}/approve', [ReviewController::class, 'approve'])->name('reviews.approve');
    Route::patch('reviews/{id}/reject',  [ReviewController::class, 'reject'])->name('reviews.reject');
    Route::delete('reviews/{id}',        [ReviewController::class, 'destroy'])->name('reviews.destroy');

    /* ── Anasayfa ────────────────────────────────────── */
    Route::patch('sliders/reorder',      [SliderController::class, 'reorder'])->name('sliders.reorder');
    Route::patch('sliders/{id}/toggle',  [SliderController::class, 'toggle'])->name('sliders.toggle');
    Route::resource('sliders', SliderController::class)->except(['show']);

    Route::get('campaign',  [CampaignController::class, 'edit'])->name('campaign.edit');
    Route::put('campaign',  [CampaignController::class, 'update'])->name('campaign.update');

    Route::patch('references/reorder',     [ReferenceController::class, 'reorder'])->name('references.reorder');
    Route::patch('references/{id}/toggle', [ReferenceController::class, 'toggle'])->name('references.toggle');
    Route::resource('references', ReferenceController::class)->except(['show']);

    /* ── İçerik ──────────────────────────────────────── */
    Route::patch('pages/{id}/toggle', [PageController::class, 'toggle'])->name('pages.toggle');
    Route::resource('pages', PageController::class)->except(['show']);

    Route::patch('menus/reorder', [MenuController::class, 'reorder'])->name('menus.reorder');
    Route::patch('menus/{id}/toggle', [MenuController::class, 'toggle'])->name('menus.toggle');
    Route::resource('menus', MenuController::class)->except(['show']);

    Route::get('messages',               [MessageController::class, 'index'])->name('messages.index');
    Route::get('messages/{id}',          [MessageController::class, 'show'])->name('messages.show');
    Route::post('messages/{id}/reply',   [MessageController::class, 'reply'])->name('messages.reply');
    Route::delete('messages/{id}',       [MessageController::class, 'destroy'])->name('messages.destroy');

    /* ── Yönetim ─────────────────────────────────────── */
    Route::get('settings',           [SettingController::class, 'edit'])->name('settings.edit');
    Route::put('settings',           [SettingController::class, 'update'])->name('settings.update');
    Route::post('settings/test-smtp',[SettingController::class, 'testSmtp'])->name('settings.test-smtp');

    Route::patch('users/{id}/toggle', [UserController::class, 'toggle'])->name('users.toggle');
    Route::patch('users/{id}/unlock', [UserController::class, 'unlock'])->name('users.unlock');
    Route::resource('users', UserController::class)->except(['show']);

    /* ── Sistem Seçenekleri ──────────────────────────── */
    Route::post('translations/import', [TranslationController::class, 'import'])->name('translations.import');
    Route::resource('translations', TranslationController::class)->except(['show']);
    Route::resource('languages', LanguageController::class)->except(['show']);

    Route::get('activity', [ActivityLogController::class, 'index'])->name('activity.index');
});
