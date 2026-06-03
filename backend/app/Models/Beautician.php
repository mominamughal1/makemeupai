<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Beautician extends Model
{
    protected $fillable = [
        'name',
        'bio',
        'city',
        'specializations',
        'hourly_rate',
        'skill_badge',
        'profile_photo',
        'is_available',
        'avg_rating',
    ];

    protected function casts(): array
    {
        return [
            'specializations' => 'array',
            'is_available' => 'boolean',
            'hourly_rate' => 'decimal:2',
            'avg_rating' => 'decimal:2',
        ];
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
