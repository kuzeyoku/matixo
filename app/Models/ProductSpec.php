<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

class ProductSpec extends Model
{
    use HasTranslations;

    protected $fillable = ['product_id', 'spec_key', 'spec_value', 'sort_order'];

    public array $translatable = ['spec_key', 'spec_value'];

    protected $casts = ['sort_order' => 'integer'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function scopeOrdered($q)
    {
        return $q->orderBy('sort_order')->orderBy('id');
    }
}
