<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reference;
use App\Services\ReferenceService;
use App\Http\Requests\Admin\ReferenceRequest;
use Illuminate\Http\Request;

class ReferenceController extends Controller
{
    public function __construct(protected ReferenceService $service) {}

    public function index(Request $r)
    {
        $items = $this->service->paginate($r->only(['search', 'is_active']));
        return view('admin.references.index', ['items' => $items, 'filters' => $r->all()]);
    }

    public function create() { return view('admin.references.create'); }

    public function store(ReferenceRequest $r)
    {
        $this->service->create($r->validated());
        return redirect()->route('admin.references.index')->with('success', 'Referans eklendi.');
    }

    public function edit(int $id)
    {
        return view('admin.references.edit', ['item' => $this->service->find($id)]);
    }

    public function update(ReferenceRequest $r, int $id)
    {
        $this->service->update($id, $r->validated());
        return redirect()->route('admin.references.index')->with('success', 'Referans güncellendi.');
    }

    public function destroy(int $id)
    {
        $this->service->delete($id);
        return back()->with('success', 'Referans silindi.');
    }

    public function toggle(int $id)
    {
        $this->service->toggleStatus($id);
        return back();
    }

    public function reorder(Request $r)
    {
        $this->service->reorder($r->validate(['ids' => 'required|array'])['ids']);
        return response()->noContent();
    }
}
