<?php

namespace App\Models;

use App\Models\Traits\OwnedByUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes, HasFactory, OwnedByUser;

    protected $fillable = [
        'title',
        'user_id',
        'description',
        'status',
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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
