<?php

namespace App\Http\Resources\Courses;

use App\Http\Resources\Users\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseCollectionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'title'          => $this->title,
            'status'         => $this->status,
            'deleted_at'     => $this->whenNotNull($this->deleted_at),
            'owner'          => new UserResource($this->whenLoaded('user')),
            'bookings_count' => $this->whenCounted('bookings'),
        ];
    }
}
