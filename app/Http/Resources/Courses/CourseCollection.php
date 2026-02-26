<?php

namespace App\Http\Resources\Courses;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CourseCollection extends ResourceCollection
{
    public $collects = CourseResource::class;

    /**
     * Transform the resource collection into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Laravel تتولى meta (pagination) و links تلقائي
        // بس نرجع البيانات + أي meta إضافي عبر additional()
        return [
            'data' => $this->collection,
        ];
    }
}
