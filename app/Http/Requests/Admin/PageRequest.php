<?php

namespace App\Http\Requests\Admin;

class PageRequest extends BaseAdminRequest
{
    public function rules(): array
    {
        return array_merge(
            $this->translatableRule('title'),
            $this->translatableTextarea('content', 100000),
            $this->translatableNullableRule('meta_title'),
            $this->translatableNullableRule('meta_description', ['string', 'max:500']),
            [
                'cover_image'    => $this->imageRule(),
                'is_active'      => ['nullable', 'boolean'],
                'show_in_footer' => ['nullable', 'boolean'],
                'sort_order'     => ['nullable', 'integer'],
            ]
        );
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active'      => $this->boolean('is_active'),
            'show_in_footer' => $this->boolean('show_in_footer'),
        ]);
    }
}
