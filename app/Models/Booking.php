<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Pivot
{
    use SoftDeletes;

    protected $table = 'bookings';
    public $timestamps = true;
    public $incrementing = true;

    protected $fillable = [
        'student_id',
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
}
