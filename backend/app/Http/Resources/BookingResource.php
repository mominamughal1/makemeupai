<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class BookingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'beautician' => [
                'name' => $this->beautician->name,
                'photo' => $this->beautician->profile_photo
                    ? Storage::disk('public')->url($this->beautician->profile_photo)
                    : null,
            ],
            'service_type' => $this->service_type,
            'booking_date' => $this->booking_date->toDateString(),
            'booking_time' => substr((string) $this->booking_time, 0, 5),
            'status' => $this->status,
            'price' => $this->price,
        ];
    }
}
