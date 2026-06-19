<?php

namespace App\Http\Requests\Admin;

class CategoryRequest extends BaseAdminRequest
{
    public function rules(): array
    {
        return array_merge(
            $this->translatableRule('name'),
            $this->translatableTextarea('description'),
            $this->translatableNullableRule('meta_title'),
            $this->translatableNullableRule('meta_description', ['string', 'max:500']),
            [
                'parent_id'    => ['nullable', 'integer', 'exists:categories,id'],
                'icon'         => ['nullable', 'string', 'max:50'],
                'image'        => $this->imageRule(),
                'bento_size'   => ['required', 'in:lg,md,sm'],
                'is_active'    => ['nullable', 'boolean'],
                'show_on_home' => ['nullable', 'boolean'],
                'sort_order'   => ['nullable', 'integer'],
            ]
        );
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active'    => $this->boolean('is_active'),
            'show_on_home' => $this->boolean('show_on_home'),
        ]);
    }
}
