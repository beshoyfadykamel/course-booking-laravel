<?php

namespace App\Http\Resources\Courses;

use App\Http\Resources\Users\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'title'          => $this->title,
            'description'    => $this->description,
            'status'         => $this->status,
            'created_at'     => $this->created_at,
            'updated_at'     => $this->updated_at,
            'deleted_at'     => $this->whenNotNull($this->deleted_at),
            'bookings_count' => $this->whenCounted('bookings'),
            'owner'          => new UserResource($this->whenLoaded('user')),
        ];
    }
}
