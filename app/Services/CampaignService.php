<?php

namespace App\Services;

use App\Models\Campaign;

/**
 * Kampanya — singleton (tek satır edit).
 */
class CampaignService
{
    public function getOrCreate(): Campaign
    {
        return Campaign::firstOrCreate(
            ['type' => 'modal'],
            [
                'title'        => ['tr' => 'Kampanya'],
                'is_active'    => false,
                'hide_days'    => 3,
                'show_delay_seconds' => 2,
            ]
        );
    }

    public function update(array $data): Campaign
    {
        $model = $this->getOrCreate();

        $media = app(MediaService::class);
        $data['image'] = $media->handle(
            request()->file('image'),
            $data['image'] ?? $model->image,
            config('matixo.media.campaign_path')
        );

        // Perks JSON normalize
        if (isset($data['perks']) && is_array($data['perks'])) {
            $data['perks'] = array_values(array_filter($data['perks'], function ($p) {
                return !empty($p['text']);
            }));
        }

        $model->update($data);
        ActivityLogger::log('update', $model);
        return $model->fresh();
    }
}
