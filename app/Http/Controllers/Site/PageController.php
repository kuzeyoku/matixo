<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Page;

class PageController extends Controller
{
    /**
     * Dinamik sayfa göster (Hakkımızda, Gizlilik Politikası vb.).
     */
    public function show(string $slug)
    {
        $page = Page::active()
            ->where('slug', $slug)
            ->firstOrFail();

        return view('site.pages.show', compact('page'));
    }
}
