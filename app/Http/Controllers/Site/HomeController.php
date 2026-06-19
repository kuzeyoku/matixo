<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\Category;
use App\Models\Product;
use App\Models\Campaign;
use App\Models\Reference;
use App\Models\Review;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::running()->ordered()->get();
        $categories = Category::active()->roots()->onHome()->withCount(['products' => fn($q) => $q->active()])->ordered()->get();
        $featured = Product::active()->featured()->with('category', 'images')->ordered()->take((int) setting('home_featured_count', 8))->get();
        $references = Reference::active()->ordered()->get();
        $campaign = Campaign::active()->section()->first();
        $reviews = Review::approved()->with('product')->latest('reviewed_at')->take(6)->get();

        return view('site.home', compact(
            'sliders',
            'categories',
            'featured',
            'references',
            'campaign',
            'reviews'
        ));
    }
}
