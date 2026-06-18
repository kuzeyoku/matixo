<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\SettingService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function __construct(protected SettingService $service) {}

    public function edit(Request $r)
    {
        $group = $r->get('group', 'site');
        $groups = Setting::query()->orderBy('group')->orderBy('sort_order')->get()->groupBy('group');

        return view('admin.settings.edit', [
            'group'   => $group,
            'groups'  => $groups,
            'sidebar' => $this->groupLabels(),
        ]);
    }

    public function update(Request $r)
    {
        $values = $r->except(['_token', '_method', 'group']);
        $this->service->save($values);
        return back()
            ->with('success', 'Ayarlar kaydedildi.')
            ->withInput(['group' => $r->get('group', 'site')]);
    }

    public function testSmtp(Request $r)
    {
        $r->validate(['email' => 'required|email']);
        $result = $this->service->testSmtp($r->email);
        return back()->with($result['success'] ? 'success' : 'error', $result['message']);
    }

    protected function groupLabels(): array
    {
        return [
            'site'         => ['label' => 'Site',          'icon' => 'bi-globe'],
            'contact'      => ['label' => 'İletişim',      'icon' => 'bi-telephone'],
            'social'       => ['label' => 'Sosyal Medya',  'icon' => 'bi-share'],
            'smtp'         => ['label' => 'SMTP / Mail',   'icon' => 'bi-envelope-gear'],
            'notification' => ['label' => 'Bildirimler',   'icon' => 'bi-bell'],
            'seo'          => ['label' => 'SEO',           'icon' => 'bi-search'],
            'homepage'     => ['label' => 'Anasayfa',      'icon' => 'bi-house'],
        ];
    }
}
