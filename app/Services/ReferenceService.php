<?php

namespace App\Services;

use App\Models\Reference;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Reference için minimal BaseService benzeri implementasyon
 * (Reference, BaseModel'i extend etmiyor; sade Model)
 */
class ReferenceService
{
    public function paginate(array $filters = [], int $perPage = 20): LengthAwarePaginator
    {
        $q = Reference::query();

        if (!empty($filters['search'])) {
            $q->where('name', 'like', '%' . $filters['search'] . '%');
        }
        if (isset($filters['is_active']) && $filters['is_active'] !== '' && $filters['is_active'] !== null) {
            $q->where('is_active', (bool) $filters['is_active']);
        }

        return $q->ordered()->paginate($perPage)->withQueryString();
    }

    public function find(int $id): Reference  { return Reference::findOrFail($id); }

    public function create(array $data): Reference
    {
        $data = $this->handleImage($data);
        $model = Reference::create($data);
        ActivityLogger::log('create', $model);
        return $model;
    }

    public function update(int $id, array $data): Reference
    {
        $model = $this->find($id);
        $data = $this->handleImage($data, $model->logo);
        $model->update($data);
        ActivityLogger::log('update', $model);
        return $model->fresh();
    }

    public function delete(int $id): bool
    {
        $model = $this->find($id);
        ActivityLogger::log('delete', $model);
        app(MediaService::class)->delete($model->logo);
        return (bool) $model->delete();
    }

    public function toggleStatus(int $id): Reference
    {
        $model = $this->find($id);
        $model->toggleStatus();
        return $model;
    }

    public function reorder(array $ids): void
    {
        foreach ($ids as $order => $id) {
            Reference::where('id', $id)->update(['sort_order' => (int) $order]);
        }
    }

    protected function handleImage(array $data, ?string $existing = null): array
    {
        $media = app(MediaService::class);
        $data['logo'] = $media->handle(
            request()->file('logo'),
            $existing ?? ($data['logo'] ?? null),
            config('matixo.media.reference_path')
        );
        return $data;
    }
}
