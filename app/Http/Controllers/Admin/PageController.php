<?php

namespace App\Http\Controllers\Admin;

use App\Services\PageService;
use App\Http\Requests\Admin\PageRequest;

class PageController extends BaseAdminController
{
    protected string $view = 'admin.pages';
    protected string $route = 'admin.pages';
    protected string $requestClass = PageRequest::class;

    public function __construct(PageService $service)
    {
        $this->service = $service;
    }
}
