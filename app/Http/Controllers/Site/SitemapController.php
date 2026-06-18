<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Page;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * XML Sitemap çıktısı verir.
     */
    public function index(): Response
    {
        $urls = [];

        // 1. Anasayfa
        $urls[] = [
            'loc' => route('home'),
            'lastmod' => now()->startOfDay()->toAtomString(),
            'changefreq' => 'daily',
            'priority' => '1.0',
        ];

        // 2. Kategoriler Liste Sayfası
        $urls[] = [
            'loc' => route('categories.index'),
            'lastmod' => now()->startOfDay()->toAtomString(),
            'changefreq' => 'weekly',
            'priority' => '0.8',
        ];

        // 3. Ürünler Liste Sayfası
        $urls[] = [
            'loc' => route('products.index'),
            'lastmod' => now()->startOfDay()->toAtomString(),
            'changefreq' => 'weekly',
            'priority' => '0.8',
        ];

        // 4. İletişim Sayfası
        $urls[] = [
            'loc' => route('contact'),
            'lastmod' => now()->startOfDay()->toAtomString(),
            'changefreq' => 'monthly',
            'priority' => '0.5',
        ];

        // 5. Dinamik Kategoriler
        $categories = Category::active()->get();
        foreach ($categories as $category) {
            $urls[] = [
                'loc' => route('categories.show', $category->slug),
                'lastmod' => $category->updated_at->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ];
        }

        // 6. Dinamik Ürünler
        $products = Product::active()->get();
        foreach ($products as $product) {
            $urls[] = [
                'loc' => route('products.show', $product->slug),
                'lastmod' => $product->updated_at->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.9',
            ];
        }

        // 7. Dinamik Sayfalar
        $pages = Page::active()->get();
        foreach ($pages as $page) {
            $urls[] = [
                'loc' => route('pages.show', $page->slug),
                'lastmod' => $page->updated_at->toAtomString(),
                'changefreq' => 'monthly',
                'priority' => '0.6',
            ];
        }

        $xml = view('site.sitemap', compact('urls'))->render();

        return response($xml, 200)
            ->header('Content-Type', 'application/xml');
    }

    /**
     * AI LLMs için llms.txt çıktısı verir.
     */
    public function llms(): Response
    {
        $categories = Category::active()->get();
        $products = Product::active()->get();
        $pages = Page::active()->get();

        $content = view('site.llms', compact('categories', 'products', 'pages'))->render();

        return response($content, 200)
            ->header('Content-Type', 'text/plain; charset=UTF-8');
    }
}
