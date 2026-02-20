<?php

namespace App\Models;

use App\Models\Traits\OwnedByUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Pivot
{
    use SoftDeletes, OwnedByUser;

    protected $table = 'bookings';
    public $timestamps = true;
    public $incrementing = true;

    protected $fillable = [
        'student_id',
        'user_id',
        'course_id',
        'status',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
