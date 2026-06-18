<?php

namespace App\Http\Controllers\Admin;

use App\Services\SliderService;
use App\Http\Requests\Admin\SliderRequest;

class SliderController extends BaseAdminController
{
    protected string $view = 'admin.sliders';
    protected string $route = 'admin.sliders';
    protected string $requestClass = SliderRequest::class;

    public function __construct(SliderService $service)
    {
        $this->service = $service;
    }
}
