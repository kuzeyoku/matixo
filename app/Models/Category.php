<?php

namespace App\Models;

use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends BaseModel
{
    use HasTranslations;

    protected $fillable = [
        'parent_id', 'name', 'slug', 'icon', 'description', 'image',
        'meta_title', 'meta_description', 'sort_order',
        'is_active', 'show_on_home', 'bento_size',
    ];

    public array $translatable = [
        'name', 'description', 'meta_title', 'meta_description',
    ];

    protected $casts = [
        'is_active'    => 'boolean',
        'show_on_home' => 'boolean',
        'sort_order'   => 'integer',
    ];

    protected string $slugFrom = 'name';
    protected bool $autoSlug = true;

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->ordered();
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function scopeRoots($q)
    {
        return $q->whereNull('parent_id');
    }

    public function scopeOnHome($q)
    {
        return $q->where('show_on_home', true);
    }
}
