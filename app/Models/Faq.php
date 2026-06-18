<?php

namespace App\Models;

use Spatie\Translatable\HasTranslations;

class Faq extends BaseModel
{
    use HasTranslations;

    protected $fillable = [
        'product_id', 'question', 'answer', 'is_active', 'sort_order',
    ];

    public array $translatable = ['question', 'answer'];

    protected $casts = [
        'product_id' => 'integer',
        'is_active'  => 'boolean',
        'sort_order' => 'integer',
    ];

    /* ── İlişkiler ──────────────────────────────── */

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
