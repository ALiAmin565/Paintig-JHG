<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaintingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = PaintingRequestRules::rules(true);
        $rules['certificate_file'] = ['required_if:certificate_type,file', 'file', 'mimes:pdf,jpg,jpeg,png,webp', 'max:10240'];

        return $rules;
    }

    public function messages(): array
    {
        return PaintingRequestRules::messages();
    }
}
