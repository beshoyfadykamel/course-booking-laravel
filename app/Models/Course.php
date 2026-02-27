<?php

namespace App\Models;

use App\Traits\OwnedByUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory, OwnedByUser, SoftDeletes;

    protected $fillable = [
        'title',
        'user_id',
        'description',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    public function scopeForApiIndex(Builder $query, array $extraColumns = []): Builder
    {
        return $query->select(array_merge([
            'id',
            'title',
            'description',
            'status',
            'user_id',
            'created_at',
            'updated_at'
        ], $extraColumns))
            ->with('user:id,name,email');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
