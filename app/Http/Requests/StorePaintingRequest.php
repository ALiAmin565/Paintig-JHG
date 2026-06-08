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
        return PaintingRequestRules::rules(true);
    }

    public function messages(): array
    {
        return PaintingRequestRules::messages();
    }
}
