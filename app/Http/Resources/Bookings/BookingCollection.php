<?php

namespace App\Http\Resources\Bookings;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BookingCollection extends ResourceCollection
{
    public $collects = BookingResource::class;

    /**
     * Transform the resource collection into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Laravel تتولى meta & links تلقائي للـ Paginator
        // بس نرجع البيانات، والـ framework يضيف الباقي
        return [
            'data' => $this->collection,
        ];
    }
}
