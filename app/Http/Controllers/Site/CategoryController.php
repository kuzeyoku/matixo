<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Tüm kategorileri listele (katalog ana sayfası).
     */
    public function index()
    {
        $categories = Category::active()
            ->roots()
            ->with(['children' => fn($q) => $q->active()->ordered()])
            ->withCount(['products' => fn($q) => $q->active()])
            ->ordered()
            ->get();

        return view('site.categories.index', compact('categories'));
    }

    /**
     * Tek kategori ve ürünleri göster.
     */
    public function show(string $slug)
    {
        $category = Category::active()
            ->where('slug', $slug)
            ->with(['children' => fn($q) => $q->active()->withCount(['products' => fn($pq) => $pq->pqCountActive ?? $pq->active()])->ordered()])
            ->firstOrFail();

        $products = $category->products()
            ->active()
            ->with('images')
            ->ordered()
            ->paginate(12);

        $breadcrumbs = $this->buildBreadcrumbs($category);

        return view('site.categories.show', compact('category', 'products', 'breadcrumbs'));
    }

    /**
     * Kategori breadcrumb'larını oluştur.
     */
    private function buildBreadcrumbs(Category $category): array
    {
        $crumbs = [];
        $current = $category;

        while ($current) {
            array_unshift($crumbs, $current);
            $current = $current->parent;
        }

        return $crumbs;
    }
}
