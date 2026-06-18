<?php

namespace App\Http\Controllers\Admin;

use App\Services\CategoryService;
use App\Http\Requests\Admin\CategoryRequest;
use App\Models\Category;

class CategoryController extends BaseAdminController
{
    protected string $view = 'admin.categories';
    protected string $route = 'admin.categories';
    protected string $requestClass = CategoryRequest::class;
    protected int $perPage = 30;

    public function __construct(CategoryService $service)
    {
        $this->service = $service;
    }

    protected function formData($item = null): array
    {
        return [
            'parents' => Category::query()
                ->when($item, fn($q) => $q->where('id', '!=', $item->id))
                ->ordered()->get(),
        ];
    }
}
