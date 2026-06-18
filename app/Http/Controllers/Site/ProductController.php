<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Tüm ürünler — arama, kategori filtresi ve sıralama desteği.
     */
    public function index(Request $request)
    {
        $query = Product::active()->with('category', 'images');

        // Arama
        if ($search = $request->input('q')) {
            $query->search($search, ['title', 'short_description', 'code']);
        }

        // Kategori filtresi
        if ($categorySlug = $request->input('category')) {
            $category = Category::where('slug', $categorySlug)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        // Sıralama
        $sort = $request->input('sort', 'default');
        $query = match ($sort) {
            'newest'      => $query->latest(),
            'name-asc'    => $query->orderBy('title'),
            'name-desc'   => $query->orderByDesc('title'),
            'popular'     => $query->orderByDesc('view_count'),
            default       => $query->ordered(),
        };

        $products   = $query->paginate(12)->withQueryString();
        $categories = Category::active()->roots()->ordered()->get();

        return view('site.products.index', compact('products', 'categories', 'sort'));
    }

    /**
     * Ürün detay sayfası.
     */
    public function show(string $slug)
    {
        $product = Product::active()
            ->where('slug', $slug)
            ->with([
                'category',
                'images',
                'features',
                'specs',
                'approvedReviews' => fn($q) => $q->latest('reviewed_at')->take(10),
            ])
            ->firstOrFail();

        // Görüntülenme sayısını artır
        $product->increment('view_count');

        // Aynı kategorideki benzer ürünler
        $related = Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->with(['category', 'images'])
            ->ordered()
            ->take(4)
            ->get();

        // Genel aktif SSS'ler (Ürüne bağlı olmayan)
        $generalFaqs = \App\Models\Faq::whereNull('product_id')
            ->where('is_active', true)
            ->ordered()
            ->get();

        return view('site.products.show', compact('product', 'related', 'generalFaqs'));
    }
}
