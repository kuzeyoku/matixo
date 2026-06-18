<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\TranslationLoader\LanguageLine;

class TranslationController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $query = LanguageLine::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('group', 'like', "%{$search}%")
                  ->orWhere('key', 'like', "%{$search}%")
                  ->orWhere('text', 'like', "%{$search}%");
            });
        }

        $translations = $query->orderBy('group')->orderBy('key')->paginate(20)->withQueryString();
        
        return view('admin.translations.index', compact('translations', 'search'));
    }

    public function create()
    {
        return view('admin.translations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'group' => 'required|string|max:255',
            'key' => 'required|string|max:255',
            'text' => 'required|array',
        ]);

        LanguageLine::create([
            'group' => $validated['group'] ?? '*',
            'key' => $validated['key'],
            'text' => $validated['text'],
        ]);

        return redirect()->route('admin.translations.index')->with('success', 'Çeviri başarıyla eklendi.');
    }

    public function edit(LanguageLine $translation)
    {
        return view('admin.translations.edit', compact('translation'));
    }

    public function update(Request $request, LanguageLine $translation)
    {
        $validated = $request->validate([
            'group' => 'required|string|max:255',
            'key' => 'required|string|max:255',
            'text' => 'required|array',
        ]);

        $translation->update([
            'group' => $validated['group'] ?? '*',
            'key' => $validated['key'],
            'text' => $validated['text'],
        ]);

        return redirect()->route('admin.translations.index')->with('success', 'Çeviri başarıyla güncellendi.');
    }

    public function destroy(LanguageLine $translation)
    {
        $translation->delete();
        return redirect()->route('admin.translations.index')->with('success', 'Çeviri başarıyla silindi.');
    }

    public function import(Request $request)
    {
        \Illuminate\Support\Facades\Artisan::call('matixo:import-translations', [
            '--overwrite' => true,
        ]);

        return redirect()->route('admin.translations.index')->with('success', 'Dosya çevirileri başarıyla veritabanına aktarıldı/güncellendi.');
    }
}
