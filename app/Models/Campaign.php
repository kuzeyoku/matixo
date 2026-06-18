<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Campaign extends Model
{
    use HasTranslations;

    protected $fillable = [
        'type', 'title', 'highlight_word', 'description', 'image',
        'button_text', 'button_url', 'perks', 'valid_until', 'is_active',
        'show_delay_seconds', 'hide_days',
    ];

    public array $translatable = ['title', 'highlight_word', 'description', 'button_text'];

    protected $casts = [
        'perks'              => 'array',
        'valid_until'        => 'date',
        'is_active'          => 'boolean',
        'show_delay_seconds' => 'integer',
        'hide_days'          => 'integer',
    ];

    public function scopeActive($q)  { return $q->where('is_active', true); }
    public function scopeModal($q)   { return $q->where('type', 'modal'); }
    public function scopeSection($q) { return $q->where('type', 'section'); }
}
