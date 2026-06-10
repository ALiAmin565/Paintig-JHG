<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class PaintingRequestRules
{
    public const MAX_DIMENSION = 999999.99;

    public const CURRENCIES = ['USD', 'EUR', 'GBP', 'EGP', 'AED', 'SAR'];

    public static function rules(bool $photoRequired = true): array
    {
        $optionalDimensionRule = ['nullable', 'numeric', 'min:0', 'max:'.self::MAX_DIMENSION];

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
            'width_with_frame' => array_merge($optionalDimensionRule, ['required_with:height_with_frame']),
            'height_with_frame' => array_merge($optionalDimensionRule, ['required_with:width_with_frame']),
            'width_without_frame' => array_merge($optionalDimensionRule, ['required_with:height_without_frame']),
            'height_without_frame' => array_merge($optionalDimensionRule, ['required_with:width_without_frame']),
            'owned_by' => ['required', 'string', 'max:255'],
            'purchased_by' => ['required', 'string', 'max:255'],
            'purchased_from_type' => ['required', Rule::in(['gallery', 'person'])],
            'gallery_id' => ['nullable', 'required_if:purchased_from_type,gallery', 'exists:galleries,id'],
            'new_gallery_name' => ['nullable', 'string', 'max:255'],
            'purchased_from_person' => ['nullable', 'required_if:purchased_from_type,person', 'string', 'max:255'],
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
            'width_with_frame.required_with' => 'Width with frame is required when height with frame is provided.',
            'height_with_frame.required_with' => 'Height with frame is required when width with frame is provided.',
            'width_without_frame.required_with' => 'Width without frame is required when height without frame is provided.',
            'height_without_frame.required_with' => 'Height without frame is required when width without frame is provided.',
            'hotel_id.required_if' => 'Please select a hotel when location type is Hotel.',
            'location_id.required_if' => 'Please select or create a location when location type is Other Location.',
            'gallery_id.required_if' => 'Please select or create a gallery when purchased from type is Gallery.',
            'purchased_from_person.required_if' => 'Please enter a person name when purchased from type is Person.',
            'certificate_text.required_if' => 'Certificate text is required when using text mode.',
            'price.required' => 'Price is required.',
            'currency.required' => 'Currency is required.',
        ];
    }
}
