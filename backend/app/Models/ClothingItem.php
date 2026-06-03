<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClothingItem extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'category',
        'colors',
        'season',
        'occasion',
        'image_path',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'colors' => 'array',
            'season' => 'array',
            'occasion' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
