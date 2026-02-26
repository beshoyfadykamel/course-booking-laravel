<?php

namespace App\Http\Resources\Courses;

use App\Http\Resources\Bookings\BookingResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseShowResource extends JsonResource
{
    private $bookings;

    public function __construct($resource, $bookings = null)
    {
        parent::__construct(is_array($resource) ? ($resource['course'] ?? null) : $resource);
        $this->bookings = $bookings ?? (is_array($resource) ? ($resource['bookings'] ?? null) : null);
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $bookingsResponse = BookingResource::collection($this->bookings)
            ->response($request)
            ->getData(true);

        return [
            'course' => new CourseResource($this->resource),
            'bookings' => $bookingsResponse,
            'studentsCount' => $this->bookings_count,
        ];
    }
}
