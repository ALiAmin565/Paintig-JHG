<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaintingNote extends Model
{
    protected $fillable = [
        'painting_id',
        'user_id',
        'body',
    ];

    public function painting(): BelongsTo
    {
        return $this->belongsTo(Painting::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
