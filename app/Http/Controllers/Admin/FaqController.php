<?php

namespace App\Http\Controllers\Admin;

use App\Services\FaqService;
use App\Http\Requests\Admin\FaqRequest;
use App\Models\Product;

class FaqController extends BaseAdminController
{
    protected string $view = 'admin.faqs';
    protected string $route = 'admin.faqs';
    protected string $requestClass = FaqRequest::class;

    public function __construct(FaqService $service)
    {
        $this->service = $service;
    }

    /**
     * Index sayfasında filtreleme dropdown'ı için ürünleri gönderir.
     */
    protected function indexData(): array
    {
        return [
            'products' => Product::orderBy('sort_order')->get(),
        ];
    }

    /**
     * Ekleme/düzenleme sayfalarında ürün seçebilmek için listeyi gönderir.
     */
    protected function formData($item = null): array
    {
        return [
            'products' => Product::orderBy('sort_order')->get(),
        ];
    }
}
