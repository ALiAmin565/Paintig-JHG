<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePaintingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = PaintingRequestRules::rules(false);
        $rules['certificate_file'] = ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,webp', 'max:10240'];

        return $rules;
    }

    public function messages(): array
    {
        return PaintingRequestRules::messages();
    }
}
