<?php

namespace App\Services;

use App\Models\Page;
use Illuminate\Database\Eloquent\Model;

class PageService extends BaseService
{
    protected string $modelClass = Page::class;
    protected array $searchable = ['title', 'slug', 'content'];

    protected function beforeSave(array $data): array
    {
        $media = app(MediaService::class);
        $data['cover_image'] = $media->handle(
            request()->file('cover_image'),
            $data['cover_image'] ?? null,
            config('matixo.media.page_path')
        );
        return $data;
    }

    protected function beforeDelete(Model $model): void
    {
        app(MediaService::class)->delete($model->cover_image);
    }
}
