<?php

namespace App\Traits;

trait Sortable
{
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy($this->getKeyName(), 'desc');
    }

    public static function reorder(array $ids): void
    {
        foreach ($ids as $order => $id) {
            static::where('id', $id)->update(['sort_order' => $order]);
        }
    }
}
