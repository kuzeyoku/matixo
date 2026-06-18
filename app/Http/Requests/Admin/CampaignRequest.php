<?php

namespace App\Http\Requests\Admin;

class CampaignRequest extends BaseAdminRequest
{
    public function rules(): array
    {
        return array_merge(
            $this->translatableRule('title'),
            $this->translatableRule('highlight_word', ['nullable', 'string', 'max:100']),
            $this->translatableTextarea('description', 2000),
            $this->translatableRule('button_text', ['nullable', 'string', 'max:100']),
            [
                'image'              => $this->imageRule(),
                'button_url'         => ['nullable', 'string', 'max:500'],
                'valid_until'        => ['nullable', 'date'],
                'is_active'          => ['nullable', 'boolean'],
                'show_delay_seconds' => ['required', 'integer', 'min:0', 'max:60'],
                'hide_days'          => ['required', 'integer', 'min:0', 'max:365'],
                'perks'              => ['nullable', 'array'],
            ]
        );
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['is_active' => $this->boolean('is_active')]);
    }
}
