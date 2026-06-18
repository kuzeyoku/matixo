<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseAdminRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    /**
     * Çevirilebilir alanlar için validation kuralı üretir.
     * Varsayılan dilde required, diğerlerinde nullable.
     */
    protected function translatableRule(string $field, array $extra = ['string', 'max:255']): array
    {
        $rules = [];
        $defaultCode = default_locale();
        foreach (active_languages() as $lang) {
            $required = $lang->code === $defaultCode ? 'required' : 'nullable';
            $rules["{$field}.{$lang->code}"] = array_merge([$required], $extra);
        }
        return $rules;
    }

    protected function translatableTextarea(string $field, int $max = 10000): array
    {
        return $this->translatableRule($field, ['string', "max:{$max}", 'nullable']);
    }

    /**
     * Image validation.
     */
    protected function imageRule(?int $maxKb = null): array
    {
        $max = $maxKb ?: config('matixo.media.max_size_kb', 5120);
        $mimes = implode(',', config('matixo.media.allowed_mimes', ['jpg','jpeg','png','webp']));
        return ['nullable', 'image', "mimes:{$mimes}", "max:{$max}"];
    }
}
