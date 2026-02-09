<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',

    ];

    public function students()
    {
        return $this->belongsToMany(Student::class, 'bookings')
            ->using(Booking::class)
            ->withPivot('status', 'id')
            ->withTimestamps();
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
