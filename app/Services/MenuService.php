<?php

namespace App\Services;

use App\Models\Menu;

class MenuService extends BaseService
{
    protected string $modelClass = Menu::class;
    protected array $searchable = ['title', 'url'];

    /**
     * Sadece root öğeleri listele, children'ları eager-load et.
     */
    protected function applyExtraFilters($query, array $filters): void
    {
        $query->where('parent_id', 0)->with(['children' => fn($q) => $q->ordered()]);
    }
}
