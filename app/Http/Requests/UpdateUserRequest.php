<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        $userId = $this->route('user')?->id;

        return [
            'full_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'alpha_dash', Rule::unique('users', 'username')->ignore($userId)],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => ['required', Rule::in(['admin', 'user'])],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ];
    }
}
