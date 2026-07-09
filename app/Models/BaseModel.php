<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use App\Traits\HasStatus;
use App\Traits\Sortable;

abstract class BaseModel extends Model
{
    use SoftDeletes, HasStatus, Sortable;

    /**
     * Slug otomatik oluşturma için kullanılacak kaynak alan.
     * Subclass'lar override edebilir: protected string $slugFrom = 'name';
     */
    protected string $slugFrom = 'title';

    /**
     * Otomatik slug oluşturulsun mu? (false yaparak kapatılabilir)
     */
    protected bool $autoSlug = false;

    protected static function booted(): void
    {
        static::saving(function ($model) {
            if ($model->autoSlug && empty($model->slug)) {
                $source = $model->{$model->slugFrom} ?? '';
                if (is_array($source)) {
                    // translatable alansa default dili al
                    $source = $source[default_locale()] ?? array_values($source)[0] ?? '';
                }
                $model->slug = static::generateUniqueSlug($source, $model->id);
            }
        });
    }

    /**
     * Benzersiz slug üret.
     */
    public static function generateUniqueSlug(string $value, ?int $excludeId = null): string
    {
        $slug = Str::slug($value);
        if (empty($slug)) {
            $slug = 'item-' . time();
        }

        $original = $slug;
        $counter = 1;
        while (static::query()
            ->where('slug', $slug)
            ->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))
            ->exists()
        ) {
            $slug = $original . '-' . $counter++;
        }
        return $slug;
    }

    /**
     * Arama scope'u — alt sınıflar override edebilir veya bu generic kullanılabilir.
     */
    public function scopeSearch($query, ?string $term, array $columns = ['title'])
    {
        if (empty($term)) {
            return $query;
        }

        $locale = app()->getLocale();
        $driver = $query->getConnection()->getDriverName();

        return $query->where(function ($q) use ($term, $columns, $locale, $driver) {
            foreach ($columns as $col) {
                $colName = str_contains($col, '.') ? last(explode('.', $col)) : $col;

                if (method_exists($this, 'isTranslatableAttribute') && $this->isTranslatableAttribute($colName)) {
                    if ($driver === 'mysql') {
                        $q->orWhereRaw("CAST({$col}->>'$.{$locale}' AS CHAR) COLLATE utf8mb4_turkish_ci LIKE ?", ["%{$term}%"]);
                    } else {
                        $q->orWhere("{$col}->{$locale}", 'like', "%{$term}%");
                    }
                } else {
                    if ($driver === 'mysql') {
                        $q->orWhereRaw("{$col} COLLATE utf8mb4_turkish_ci LIKE ?", ["%{$term}%"]);
                    } else {
                        $q->orWhere($col, 'like', "%{$term}%");
                    }
                }
            }
        });
    }
}
