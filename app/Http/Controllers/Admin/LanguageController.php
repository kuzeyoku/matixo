<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class LanguageController extends Controller
{
    public function index()
    {
        $items = Language::orderBy('sort_order')->get();
        return view('admin.languages.index', ['items' => $items]);
    }

    public function create() { return view('admin.languages.create'); }

    public function store(Request $r)
    {
        $data = $this->validateData($r);
        DB::transaction(function () use ($data) {
            if (!empty($data['is_default'])) {
                Language::query()->update(['is_default' => false]);
            }
            $lang = Language::create($data);
            ActivityLogger::log('create', $lang);
        });
        return redirect()->route('admin.languages.index')->with('success', 'Dil eklendi.');
    }

    public function edit(int $id)
    {
        return view('admin.languages.edit', ['item' => Language::findOrFail($id)]);
    }

    public function update(Request $r, int $id)
    {
        $lang = Language::findOrFail($id);
        $data = $this->validateData($r, $id);
        DB::transaction(function () use ($data, $lang) {
            if (!empty($data['is_default'])) {
                Language::where('id', '!=', $lang->id)->update(['is_default' => false]);
            }
            $lang->update($data);
            ActivityLogger::log('update', $lang);
        });
        return redirect()->route('admin.languages.index')->with('success', 'Dil güncellendi.');
    }

    public function destroy(int $id)
    {
        $lang = Language::findOrFail($id);
        if ($lang->is_default) {
            return back()->with('error', 'Varsayılan dil silinemez.');
        }
        ActivityLogger::log('delete', $lang);
        $lang->delete();
        return back()->with('success', 'Dil silindi.');
    }

    protected function validateData(Request $r, ?int $id = null): array
    {
        return $r->validate([
            'code'       => ['required', 'string', 'max:5', Rule::unique('languages')->ignore($id)],
            'name'       => ['required', 'string', 'max:50'],
            'flag'       => ['nullable', 'string', 'max:10'],
            'direction'  => ['required', 'in:ltr,rtl'],
            'is_default' => ['nullable', 'boolean'],
            'is_active'  => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer'],
        ]);
    }
}
