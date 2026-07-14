<?php

namespace App\Http\Requests;

use App\Models\Hotel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateHotelRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('hotel'));
    }

    public function rules(): array
    {
        $hotel = $this->route('hotel');
        
        return [
            'name' => ['required', 'string', 'max:255'],
            'pms_code' => ['required', 'string', 'max:50', Rule::unique('hotels', 'pms_code')->ignore($hotel->id)],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'hotel name',
            'pms_code' => 'PMS code',
            'status' => 'status',
        ];
    }
}