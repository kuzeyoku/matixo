<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = [
        'key', 'value', 'type', 'group', 'label', 'description', 'is_translatable', 'sort_order',
    ];

    protected $casts = [
        'is_translatable' => 'boolean',
        'sort_order'      => 'integer',
    ];

    protected static function booted(): void
    {
        static::saved(fn() => Cache::forget('matixo.settings'));
        static::deleted(fn() => Cache::forget('matixo.settings'));
    }

    /**
     * Ayar değerini güncelle veya oluştur.
     */
    public static function set(string $key, mixed $value, string $type = 'text', string $group = 'general'): static
    {
        $val = is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE) : $value;

        return static::updateOrCreate(
            ['key' => $key],
            ['value' => $val, 'type' => $type, 'group' => $group]
        );
    }
}
