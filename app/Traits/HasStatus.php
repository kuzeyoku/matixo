<?php

namespace App\Traits;

trait HasStatus
{
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    public function toggleStatus(): bool
    {
        $this->is_active = !$this->is_active;
        return $this->save();
    }
}
