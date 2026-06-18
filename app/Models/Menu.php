<?php

namespace App\Models;

use Spatie\Translatable\HasTranslations;

class Menu extends BaseModel
{
    use HasTranslations;

    protected $fillable = [
        'parent_id', 'title', 'url', 'link_type',
        'link_target', 'icon', 'is_active', 'sort_order',
    ];

    public array $translatable = ['title'];

    protected $casts = [
        'parent_id'  => 'integer',
        'is_active'  => 'boolean',
        'sort_order' => 'integer',
    ];

    /* ── İlişkiler ──────────────────────────────── */

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id')->ordered();
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /* ── Scope'lar ──────────────────────────────── */

    /** Sadece ana (root) menü öğeleri */
    public function scopeRoots($query)
    {
        return $query->where('parent_id', 0);
    }

    /* ── Accessor ───────────────────────────────── */

    /**
     * link_type'a göre gerçek URL'i çözümler.
     */
    public function getResolvedUrlAttribute(): string
    {
        return match ($this->link_type) {
            'route'    => $this->url ? (route($this->url, [], false) ?? '#') : '#',
            'page'     => $this->url ? url('/sayfa/' . $this->url) : '#',
            'category' => $this->url ? url('/kategori/' . $this->url) : '#',
            default    => $this->url ?: '#',
        };
    }

    /** Alt menüsü var mı? */
    public function getHasChildrenAttribute(): bool
    {
        return $this->children->isNotEmpty();
    }
}
