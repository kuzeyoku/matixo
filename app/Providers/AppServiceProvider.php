<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useBootstrapFive();

        // HTTP isteklerinde base URL'den /public segmentini temizle (shared hosting / alt dizin koruması)
        if (!app()->runningInConsole()) {
            $baseUrl = request()->getBaseUrl();
            if (str_contains($baseUrl, '/public')) {
                request()->server->set('SCRIPT_NAME', str_replace('/public/index.php', '/index.php', request()->server->get('SCRIPT_NAME')));
                request()->server->set('SCRIPT_FILENAME', str_replace('/public/index.php', '/index.php', request()->server->get('SCRIPT_FILENAME')));
            }
        }

        // Admin component'lerini <x-...> ile çağırabilmek için
        Blade::anonymousComponentPath(resource_path('views/admin/components'));

        // Site header menüsü — tüm site layout'larına paylaş
        \Illuminate\Support\Facades\View::composer('site.layouts.header', function ($view) {
            $view->with('headerMenus', \Illuminate\Support\Facades\Cache::remember('matixo.headerMenus', 3600, function () {
                return \App\Models\Menu::roots()
                    ->active()
                    ->ordered()
                    ->with(['children' => fn($q) => $q->active()->ordered()])
                    ->get();
            }));
        });

        // Site footer verileri — tüm site layout'larına paylaş
        \Illuminate\Support\Facades\View::composer('site.layouts.footer', function ($view) {
            $view->with('footerCategories', \Illuminate\Support\Facades\Cache::remember('matixo.footerCategories', 3600, function () {
                return \App\Models\Category::active()
                    ->roots() // Sadece ana kategoriler
                    ->ordered()
                    ->take(6)
                    ->get();
            }));
            
            $view->with('footerPages', \Illuminate\Support\Facades\Cache::remember('matixo.footerPages', 3600, function () {
                return \App\Models\Page::active()
                    ->inFooter() // Sadece footer'da gösterilecek sayfalar
                    ->ordered()
                    ->get();
            }));
        });
    }
}
