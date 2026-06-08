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
        return PaintingRequestRules::rules(false);
    }

    public function messages(): array
    {
        return PaintingRequestRules::messages();
    }
}
