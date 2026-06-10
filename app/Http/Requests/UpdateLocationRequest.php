<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLocationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        $locationId = $this->route('location')?->id;

        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('locations', 'name')->ignore($locationId)],
            'description' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
