<?php

namespace App\Models\Traits;

trait OwnedByUser
{
    /**
     * Scope query to current user's ownership.
     * Admin sees all records; normal user sees only their own.
     */
    public function scopeForCurrentUser($query)
    {
        if (auth()->user()->role !== 'admin') {
            return $query->where($this->getTable() . '.user_id', auth()->id());
        }

        return $query;
    }
}
