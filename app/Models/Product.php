<?php

namespace App\Models;

use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends BaseModel
{
    use HasTranslations;

    protected $fillable = [
        'category_id', 'title', 'slug', 'code', 'short_description', 'description',
        'material', 'age_range', 'certification', 'production_time', 'warranty',
        'price', 'cover_image', 'is_active', 'is_featured', 'badge', 'sort_order',
        'meta_title', 'meta_description', 'og_image',
    ];

    public array $translatable = [
        'title', 'short_description', 'description', 'meta_title', 'meta_description',
    ];

    protected $casts = [
        'price'       => 'decimal:2',
        'is_active'   => 'boolean',
        'is_featured' => 'boolean',
        'sort_order'  => 'integer',
        'view_count'  => 'integer',
    ];

    protected string $slugFrom = 'title';
    protected bool $autoSlug = true;

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->ordered();
    }

    public function features(): HasMany
    {
        return $this->hasMany(ProductFeature::class)->ordered();
    }

    public function specs(): HasMany
    {
        return $this->hasMany(ProductSpec::class)->ordered();
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function approvedReviews(): HasMany
    {
        return $this->hasMany(Review::class)->where('status', 'approved');
    }

    public function scopeFeatured($q)
    {
        return $q->where('is_featured', true);
    }

    public function getAverageRatingAttribute(): float
    {
        return round((float) $this->approvedReviews()->avg('rating'), 1);
    }

    public function faqs(): HasMany
    {
        return $this->hasMany(Faq::class)->ordered();
    }

    public function activeFaqs(): HasMany
    {
        return $this->hasMany(Faq::class)->where('is_active', true)->ordered();
    }
}
