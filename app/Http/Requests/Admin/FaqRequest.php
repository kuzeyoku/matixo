<?php

namespace App\Http\Requests\Admin;

class FaqRequest extends BaseAdminRequest
{
    public function rules(): array
    {
        return array_merge(
            $this->translatableRule('question'),
            $this->translatableTextarea('answer', 5000),
            [
                'product_id' => ['nullable', 'integer', 'exists:products,id'],
                'is_active'  => ['nullable', 'boolean'],
                'sort_order' => ['nullable', 'integer'],
            ]
        );
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['is_active' => $this->boolean('is_active')]);
    }
}
