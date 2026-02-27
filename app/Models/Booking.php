<?php

namespace App\Models;

use App\Traits\OwnedByUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory, OwnedByUser, SoftDeletes;


    protected $fillable = [
        'student_id',
        'user_id',
        'course_id',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    public function scopeForCourseShow(Builder $query): Builder
    {
        return $query->select(['id', 'course_id', 'student_id', 'user_id', 'status', 'created_at'])
            ->with([
                'student:id,name',
                'user:id,name,email',
            ]);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
