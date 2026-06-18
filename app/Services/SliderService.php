<?php

namespace App\Services;

use App\Models\Slider;
use Illuminate\Database\Eloquent\Model;

class SliderService extends BaseService
{
    protected string $modelClass = Slider::class;
    protected array $searchable = ['title', 'link_url'];

    protected function beforeSave(array $data): array
    {
        $media = app(MediaService::class);

        $existingImage = $data['image'] ?? null;
        $sliderId = request()->route('slider') ?? request()->route('id');
        if ($sliderId && $existingImage === null && !request()->hasFile('image')) {
            $existingImage = Slider::find($sliderId)?->image;
        }

        $data['image'] = $media->handle(
            request()->file('image'),
            $existingImage,
            config('matixo.media.slider_path')
        );
        return $data;
    }

    protected function beforeDelete(Model $model): void
    {
        app(MediaService::class)->delete($model->image);
    }
}
