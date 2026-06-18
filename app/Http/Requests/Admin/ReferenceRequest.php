<?php

namespace App\Http\Requests\Admin;

class ReferenceRequest extends BaseAdminRequest
{
    public function rules(): array
    {
        return [
            'name'       => ['required', 'string', 'max:191'],
            'logo'       => $this->imageRule(),
            'link_url'   => ['nullable', 'string', 'max:500'],
            'is_active'  => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['is_active' => $this->boolean('is_active')]);
    }
}
