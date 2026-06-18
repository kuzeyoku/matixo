<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class BaseService
{
    protected string $modelClass;

    /**
     * Aranabilir alanlar — alt sınıflar override eder.
     */
    protected array $searchable = ['title'];

    /**
     * Filtreli sayfalama.
     */
    public function paginate(array $filters = [], int $perPage = 20): LengthAwarePaginator
    {
        $q = $this->modelClass::query();

        if (!empty($filters['search'])) {
            $q->search($filters['search'], $this->searchable);
        }

        if (isset($filters['is_active']) && $filters['is_active'] !== '' && $filters['is_active'] !== null) {
            $q->where('is_active', (bool) $filters['is_active']);
        }

        if (!empty($filters['category_id'])) {
            $q->where('category_id', $filters['category_id']);
        }

        if (!empty($filters['status'])) {
            $q->where('status', $filters['status']);
        }

        $this->applyExtraFilters($q, $filters);

        return $q->ordered()->paginate($perPage)->withQueryString();
    }

    /**
     * Alt sınıflar ek filtreleri burada uygular.
     */
    protected function applyExtraFilters($query, array $filters): void
    {
        //
    }

    public function find(int $id): Model
    {
        return $this->modelClass::findOrFail($id);
    }

    public function create(array $data): Model
    {
        return DB::transaction(function () use ($data) {
            $model = $this->modelClass::create($this->beforeSave($data));
            $this->afterCreate($model, $data);
            ActivityLogger::log('create', $model);
            return $model;
        });
    }

    public function update(int $id, array $data): Model
    {
        return DB::transaction(function () use ($id, $data) {
            $model = $this->find($id);
            $old = $model->toArray();
            $model->update($this->beforeSave($data));
            $this->afterUpdate($model, $data);
            ActivityLogger::log('update', $model, ['old' => $old]);
            return $model->fresh();
        });
    }

    public function delete(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $model = $this->find($id);
            ActivityLogger::log('delete', $model);
            $this->beforeDelete($model);
            return (bool) $model->delete();
        });
    }

    public function toggleStatus(int $id): Model
    {
        $model = $this->find($id);
        $model->toggleStatus();
        ActivityLogger::log('toggle_status', $model);
        return $model;
    }

    public function reorder(array $ids): void
    {
        DB::transaction(function () use ($ids) {
            foreach ($ids as $order => $id) {
                $this->modelClass::where('id', $id)->update(['sort_order' => (int) $order]);
            }
        });
    }

    /* Hook'lar — alt sınıflar override eder */
    protected function beforeSave(array $data): array { return $data; }
    protected function afterCreate(Model $model, array $data): void {}
    protected function afterUpdate(Model $model, array $data): void {}
    protected function beforeDelete(Model $model): void {}
}
