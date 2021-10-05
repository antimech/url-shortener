<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLinkRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'link' => ['required', 'url'],
            'custom_alias' => ['nullable', 'string', 'alpha_dash', 'unique:links,hash', 'min:8', 'max:16'],
            'expired_at' => ['nullable', 'date']
        ];
    }
}
