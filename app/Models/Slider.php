<?php

namespace App\Models;

use Spatie\Translatable\HasTranslations;

class Slider extends BaseModel
{
    use HasTranslations;

    protected $fillable = [
        'title', 'subtitle', 'badge_text', 'image', 'link_url', 'button_text',
        'sort_order', 'is_active', 'starts_at', 'ends_at',
    ];

    public array $translatable = ['title', 'subtitle', 'badge_text', 'button_text'];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order'=> 'integer',
        'starts_at' => 'datetime',
        'ends_at'   => 'datetime',
    ];

    public function scopeRunning($q)
    {
        $now = now();
        return $q->where('is_active', true)
            ->where(fn($x) => $x->whereNull('starts_at')->orWhere('starts_at', '<=', $now))
            ->where(fn($x) => $x->whereNull('ends_at')->orWhere('ends_at', '>=', $now));
    }
}
