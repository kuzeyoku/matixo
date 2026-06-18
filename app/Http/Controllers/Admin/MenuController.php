<?php

namespace App\Http\Controllers\Admin;

use App\Services\MenuService;
use App\Http\Requests\Admin\MenuRequest;
use App\Models\Menu;
use App\Models\Page;
use App\Models\Category;

class MenuController extends BaseAdminController
{
    protected string $view = 'admin.menus';
    protected string $route = 'admin.menus';
    protected string $requestClass = MenuRequest::class;
    protected int $perPage = 50;

    public function __construct(MenuService $service)
    {
        $this->service = $service;
    }

    protected function formData($item = null): array
    {
        return [
            'parents'    => Menu::roots()->ordered()->when($item, fn($q) => $q->where('id', '!=', $item->id))->get(),
            'pages'      => Page::active()->ordered()->get(),
            'categories' => Category::active()->ordered()->get(),
        ];
    }
}
