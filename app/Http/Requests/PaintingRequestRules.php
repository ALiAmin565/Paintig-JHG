<?php

namespace App\Http\Requests;

class PaintingRequestRules
{
    public const MAX_DIMENSION = 999999.99;

    public static function rules(bool $photoRequired = true): array
    {
        $dimensionRule = ['required', 'numeric', 'min:0', 'max:'.self::MAX_DIMENSION];

        return [
            'hotel_id' => ['required', 'exists:hotels,id'],
            'title' => ['required', 'string', 'max:255'],
            'media' => ['required', 'string', 'max:255'],
            'production_year' => ['required', 'integer', 'min:1000', 'max:'.date('Y')],
            'dimensions_with_frame' => $dimensionRule,
            'dimensions_without_frame' => $dimensionRule,
            'owned_by' => ['required', 'string', 'max:255'],
            'purchased_by' => ['required', 'string', 'max:255'],
            'purchased_from' => ['required', 'string', 'max:255'],
            'paid_by' => ['required', 'string', 'max:255'],
            'certificate_of_authenticity' => ['required', 'string', 'max:255'],
            'photo' => array_merge(
                [$photoRequired ? 'required' : 'nullable'],
                ['image', 'mimes:jpeg,jpg,png,webp', 'max:5120']
            ),
        ];
    }

    public static function messages(): array
    {
        return [
            'dimensions_with_frame.max' => 'Dimensions with frame may not exceed '.number_format(self::MAX_DIMENSION, 2).'.',
            'dimensions_without_frame.max' => 'Dimensions without frame may not exceed '.number_format(self::MAX_DIMENSION, 2).'.',
            'dimensions_with_frame.numeric' => 'Dimensions with frame must be a valid number.',
            'dimensions_without_frame.numeric' => 'Dimensions without frame must be a valid number.',
        ];
    }
}
