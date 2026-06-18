<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\BaseService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

abstract class BaseAdminController extends Controller
{
    protected BaseService $service;
    protected string $view;          // örn: 'admin.products'
    protected string $route;         // örn: 'admin.products'
    protected string $requestClass;  // FormRequest sınıfı
    protected int $perPage = 20;

    public function index(Request $request)
    {
        $items = $this->service->paginate(
            $request->only(['search', 'is_active', 'category_id', 'status']),
            $this->perPage
        );
        return view("{$this->view}.index", array_merge(
            ['items' => $items, 'filters' => $request->all()],
            $this->indexData()
        ));
    }

    public function create()
    {
        return view("{$this->view}.create", $this->formData());
    }

    public function store(): RedirectResponse
    {
        $data = app($this->requestClass)->validated();
        $this->service->create($data);
        return redirect()->route("{$this->route}.index")
            ->with('success', 'Kayıt başarıyla oluşturuldu.');
    }

    public function edit(int $id)
    {
        $item = $this->service->find($id);
        return view("{$this->view}.edit", array_merge(['item' => $item], $this->formData($item)));
    }

    public function update(int $id): RedirectResponse
    {
        $data = app($this->requestClass)->validated();
        $this->service->update($id, $data);
        return redirect()->route("{$this->route}.index")
            ->with('success', 'Kayıt başarıyla güncellendi.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->service->delete($id);
        return back()->with('success', 'Kayıt silindi.');
    }

    public function toggle(int $id): RedirectResponse
    {
        $this->service->toggleStatus($id);
        return back()->with('success', 'Durum güncellendi.');
    }

    public function reorder(Request $request): Response
    {
        $ids = $request->validate(['ids' => 'required|array'])['ids'];
        $this->service->reorder($ids);
        return response()->noContent();
    }

    /** Alt sınıflar override eder. */
    protected function indexData(): array { return []; }
    protected function formData($item = null): array { return []; }
}
