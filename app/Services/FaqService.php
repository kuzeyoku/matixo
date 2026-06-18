<?php

namespace App\Services;

use App\Models\Faq;

class FaqService extends BaseService
{
    protected string $modelClass = Faq::class;
    protected array $searchable = ['question', 'answer'];

    /**
     * SSS için ekstra filtreleri (örn. product_id veya genel filtre) buraya uygular.
     */
    protected function applyExtraFilters($query, array $filters): void
    {
        if (isset($filters['product_id']) && $filters['product_id'] !== '' && $filters['product_id'] !== null) {
            if ($filters['product_id'] == 'null') {
                $query->whereNull('product_id');
            } else {
                $query->where('product_id', (int) $filters['product_id']);
            }
        }
    }
}
