<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\CampaignService;
use App\Http\Requests\Admin\CampaignRequest;

class CampaignController extends Controller
{
    public function __construct(protected CampaignService $service) {}

    public function edit()
    {
        return view('admin.campaign.edit', ['item' => $this->service->getOrCreate()]);
    }

    public function update(CampaignRequest $r)
    {
        $this->service->update($r->validated());
        return back()->with('success', 'Kampanya modalı güncellendi.');
    }
}
