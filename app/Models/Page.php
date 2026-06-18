<?php

namespace App\Models;

use Spatie\Translatable\HasTranslations;

class Page extends BaseModel
{
    use HasTranslations;

    protected $fillable = [
        'slug', 'title', 'content', 'cover_image',
        'meta_title', 'meta_description',
        'sort_order', 'is_active', 'show_in_footer',
    ];

    public array $translatable = ['title', 'content', 'meta_title', 'meta_description'];

    protected $casts = [
        'is_active'      => 'boolean',
        'show_in_footer' => 'boolean',
        'sort_order'     => 'integer',
    ];

    protected string $slugFrom = 'title';
    protected bool $autoSlug = true;

    public function scopeInFooter($q)
    {
        return $q->where('show_in_footer', true);
    }
}
