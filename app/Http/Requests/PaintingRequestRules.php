<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class PaintingRequestRules
{
    public const MAX_DIMENSION = 999999.99;

    public const CURRENCIES = ['USD', 'EUR', 'GBP', 'EGP', 'AED', 'SAR'];

    public static function rules(bool $photoRequired = true): array
    {
        $dimensionRule = ['required', 'numeric', 'min:0', 'max:'.self::MAX_DIMENSION];

        return [
            'location_type' => ['required', Rule::in(['hotel', 'location', 'none'])],
            'hotel_id' => ['nullable', 'required_if:location_type,hotel', 'exists:hotels,id'],
            'location_id' => ['nullable', 'required_if:location_type,location', 'exists:locations,id'],
            'new_location_name' => ['nullable', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'painter_name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', Rule::in(self::CURRENCIES)],
            'media' => ['required', 'string', 'max:255'],
            'production_year' => ['required', 'integer', 'min:1000', 'max:'.date('Y')],
            'width_with_frame' => $dimensionRule,
            'height_with_frame' => $dimensionRule,
            'width_without_frame' => $dimensionRule,
            'height_without_frame' => $dimensionRule,
            'owned_by' => ['required', 'string', 'max:255'],
            'purchased_by' => ['required', 'string', 'max:255'],
            'purchased_from' => ['required', 'string', 'max:255'],
            'paid_by' => ['required', 'string', 'max:255'],
            'certificate_type' => ['required', Rule::in(['text', 'file'])],
            'certificate_text' => ['nullable', 'required_if:certificate_type,text', 'string', 'max:5000'],
            'certificate_file' => array_merge(
                [$photoRequired ? 'nullable' : 'nullable'],
                ['file', 'mimes:pdf,jpg,jpeg,png,webp', 'max:10240']
            ),
            'photo' => array_merge(
                [$photoRequired ? 'required' : 'nullable'],
                ['image', 'mimes:jpeg,jpg,png,webp', 'max:5120']
            ),
        ];
    }

    public static function messages(): array
    {
        return [
            'width_with_frame.max' => 'Width with frame may not exceed '.number_format(self::MAX_DIMENSION, 2).'.',
            'height_with_frame.max' => 'Height with frame may not exceed '.number_format(self::MAX_DIMENSION, 2).'.',
            'width_without_frame.max' => 'Width without frame may not exceed '.number_format(self::MAX_DIMENSION, 2).'.',
            'height_without_frame.max' => 'Height without frame may not exceed '.number_format(self::MAX_DIMENSION, 2).'.',
            'hotel_id.required_if' => 'Please select a hotel when location type is Hotel.',
            'location_id.required_if' => 'Please select or create a location when location type is Other Location.',
            'certificate_text.required_if' => 'Certificate text is required when using text mode.',
            'price.required' => 'Price is required.',
            'currency.required' => 'Currency is required.',
        ];
    }
}
