<?php

namespace App\Http\Requests\Admin;

class MenuRequest extends BaseAdminRequest
{
    public function rules(): array
    {
        return array_merge(
            $this->translatableRule('title'),
            [
                'parent_id'   => ['required', 'integer', 'min:0'],
                'url'         => ['nullable', 'string', 'max:500'],
                'link_type'   => ['required', 'in:url,route,page,category'],
                'link_target' => ['required', 'in:_self,_blank'],
                'icon'        => ['nullable', 'string', 'max:60'],
                'is_active'   => ['nullable', 'boolean'],
                'sort_order'  => ['nullable', 'integer'],
            ]
        );
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'parent_id' => (int) ($this->parent_id ?? 0),
            'is_active'  => $this->boolean('is_active'),
        ]);
    }
}
