<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;

class ProductRequest extends BaseAdminRequest
{
    public function rules(): array
    {
        $productId = $this->route('product') ?? $this->route('id');
        return array_merge(
            $this->translatableRule('title'),
            $this->translatableTextarea('short_description', 1000),
            $this->translatableTextarea('description', 50000),
            $this->translatableNullableRule('meta_title'),
            $this->translatableNullableRule('meta_description', ['string', 'max:500']),
            [
                'category_id'      => ['required', 'integer', 'exists:categories,id'],
                'code'             => ['nullable', 'string', 'max:50', Rule::unique('products', 'code')->ignore($productId)->whereNull('deleted_at')],
                'material'         => ['nullable', 'string', 'max:191'],
                'age_range'        => ['nullable', 'string', 'max:50'],
                'certification'    => ['nullable', 'string', 'max:191'],
                'production_time'  => ['nullable', 'string', 'max:50'],
                'warranty'         => ['nullable', 'string', 'max:50'],
                'badge'            => ['nullable', 'in:new,campaign,popular'],
                'is_active'        => ['nullable', 'boolean'],
                'is_featured'      => ['nullable', 'boolean'],
                'cover_image'      => $this->imageRule(),
                'og_image'         => $this->imageRule(),
                'gallery_files.*'  => $this->imageRule(),
                'features'         => ['nullable', 'array'],
                'specs'            => ['nullable', 'array'],
            ]
        );
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active'   => $this->boolean('is_active'),
            'is_featured' => $this->boolean('is_featured'),
        ]);
    }
}
