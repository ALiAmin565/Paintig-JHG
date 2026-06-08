<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Painting extends Model
{
    protected $fillable = [
        'hotel_id',
        'photo',
        'photo_mime',
        'title',
        'media',
        'production_year',
        'dimensions_with_frame',
        'dimensions_without_frame',
        'owned_by',
        'purchased_by',
        'purchased_from',
        'paid_by',
        'certificate_of_authenticity',
    ];

    protected $hidden = [
        'photo',
    ];

    protected function casts(): array
    {
        return [
            'production_year' => 'integer',
            'dimensions_with_frame' => 'decimal:2',
            'dimensions_without_frame' => 'decimal:2',
        ];
    }

    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    public function hasPhoto(): bool
    {
        return ! empty($this->photo);
    }

    public function photoUrl(): ?string
    {
        if (! $this->hasPhoto()) {
            return null;
        }

        return route('paintings.photo', $this);
    }
}
