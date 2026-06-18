<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

class CategoryService extends BaseService
{
    protected string $modelClass = Category::class;
    protected array $searchable = ['name', 'slug', 'description'];

    protected function beforeSave(array $data): array
    {
        $media = app(MediaService::class);

        $existingImage = $data['image'] ?? null;
        $categoryId = request()->route('category') ?? request()->route('id');
        if ($categoryId && $existingImage === null && !request()->hasFile('image')) {
            $existingImage = Category::find($categoryId)?->image;
        }

        $data['image'] = $media->handle(
            request()->file('image'),
            $existingImage,
            config('matixo.media.category_path'),
            config('matixo.media.sizes')
        );

        if (request()->boolean('image_remove')) {
            $media->delete($data['image'] ?? null, config('matixo.media.sizes'));
            $data['image'] = null;
        }
        return $data;
    }

    protected function beforeDelete(Model $model): void
    {
        app(MediaService::class)->delete($model->image, config('matixo.media.sizes'));
    }
}
