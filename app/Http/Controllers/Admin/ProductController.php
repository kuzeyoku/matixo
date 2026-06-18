<?php

namespace App\Http\Controllers\Admin;

use App\Services\ProductService;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Category;

class ProductController extends BaseAdminController
{
    protected string $view = 'admin.products';
    protected string $route = 'admin.products';
    protected string $requestClass = ProductRequest::class;
    protected int $perPage = 25;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    protected function indexData(): array
    {
        return ['categories' => Category::ordered()->get()];
    }

    protected function formData($item = null): array
    {
        return [
            'categories' => Category::ordered()->get(),
            'badgeOptions' => [
                ''          => '— Etiketi yok —',
                'new'       => 'Yeni',
                'campaign'  => 'Kampanya',
                'popular'   => 'Popüler',
            ],
        ];
    }
}
