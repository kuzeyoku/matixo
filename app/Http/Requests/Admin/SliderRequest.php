<?php

namespace App\Http\Requests\Admin;

class SliderRequest extends BaseAdminRequest
{
    public function rules(): array
    {
        return array_merge(
            $this->translatableRule('title'),
            $this->translatableTextarea('subtitle', 500),
            $this->translatableRule('badge_text', ['nullable', 'string', 'max:100']),
            $this->translatableRule('button_text', ['nullable', 'string', 'max:100']),
            [
                'image'      => $this->imageRule(),
                'link_url'   => ['nullable', 'string', 'max:500'],
                'is_active'  => ['nullable', 'boolean'],
                'sort_order' => ['nullable', 'integer'],
                'starts_at'  => ['nullable', 'date'],
                'ends_at'    => ['nullable', 'date', 'after_or_equal:starts_at'],
            ]
        );
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['is_active' => $this->boolean('is_active')]);
    }
}
