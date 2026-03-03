<?php

namespace App\Http\Resources\Bookings;

use App\Http\Resources\Students\StudentResource;
use App\Http\Resources\Users\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'student' => new StudentResource($this->whenLoaded('student')),
            'user' => new UserResource($this->whenLoaded('user')),
        ];
    }
}
