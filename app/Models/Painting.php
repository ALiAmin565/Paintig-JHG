<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Painting extends Model
{
    protected $fillable = [
        'hotel_id',
        'location_id',
        'location_type',
        'photo',
        'photo_mime',
        'title',
        'painter_name',
        'price',
        'currency',
        'media',
        'production_year',
        'width_with_frame',
        'height_with_frame',
        'width_without_frame',
        'height_without_frame',
        'owned_by',
        'purchased_by',
        'purchased_from_type',
        'gallery_id',
        'purchased_from_person',
        'paid_by',
        'certificate_type',
        'certificate_text',
        'certificate_file_path',
    ];

    protected $hidden = [
        'photo',
    ];

    protected function casts(): array
    {
        return [
            'production_year' => 'integer',
            'width_with_frame' => 'decimal:2',
            'height_with_frame' => 'decimal:2',
            'width_without_frame' => 'decimal:2',
            'height_without_frame' => 'decimal:2',
            'price' => 'decimal:2',
        ];
    }

    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function gallery(): BelongsTo
    {
        return $this->belongsTo(Gallery::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(PaintingNote::class)->latest();
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

    public function locationLabel(): string
    {
        return match ($this->location_type) {
            'hotel' => $this->hotel?->name ?? 'Unknown Hotel',
            'location' => $this->location?->name ?? 'Unknown Location',
            default => 'N/A',
        };
    }

    public function formattedPrice(): string
    {
        return number_format((float) $this->price, 2).' '.$this->currency;
    }

    public function locationTypeLabel(): string
    {
        return match ($this->location_type) {
            'hotel' => 'Hotel',
            'location' => 'Other Location',
            default => 'N/A',
        };
    }

    public function purchasedFromLabel(): string
    {
        return match ($this->purchased_from_type) {
            'gallery' => $this->gallery?->name ?? 'Unknown Gallery',
            'person' => $this->purchased_from_person ?? '—',
            default => '—',
        };
    }

    public function purchasedFromTypeLabel(): string
    {
        return match ($this->purchased_from_type) {
            'gallery' => 'Gallery',
            'person' => 'Person',
            default => 'N/A',
        };
    }

    public function dimensionsWithFrameLabel(): string
    {
        return $this->formatDimensions($this->width_with_frame, $this->height_with_frame);
    }

    public function dimensionsWithoutFrameLabel(): string
    {
        return $this->formatDimensions($this->width_without_frame, $this->height_without_frame);
    }

    public function printDimensionsPair($width, $height): string
    {
        if ($width === null || $height === null) {
            return '';
        }

        return number_format((float) $width, 0).' cm x '.number_format((float) $height, 0).' cm';
    }

    public function printPriceLabel(): string
    {
        return $this->currency.' '.number_format((float) $this->price, 0);
    }

    public function hasCertificate(): bool
    {
        if ($this->certificate_type === 'file') {
            return ! empty($this->certificate_file_path);
        }

        return ! empty($this->certificate_text);
    }

    public function certificateUrl(): ?string
    {
        if ($this->certificate_type !== 'file' || ! $this->certificate_file_path) {
            return null;
        }

        return asset('storage/'.$this->certificate_file_path);
    }

    public function deleteCertificateFile(): void
    {
        if ($this->certificate_file_path && Storage::disk('public')->exists($this->certificate_file_path)) {
            Storage::disk('public')->delete($this->certificate_file_path);
        }
    }

    private function formatDimensions($width, $height): string
    {
        if ($width === null || $height === null) {
            return '—';
        }

        return number_format((float) $width, 2).' × '.number_format((float) $height, 2).' cm';
    }
}
