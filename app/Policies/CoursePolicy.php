<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;

class CoursePolicy
{
    /**
     * Any authenticated user can list courses.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Admin can view any course; user can only view their own.
     */
    public function view(User $user, Course $course): bool
    {
        return $user->role === 'admin' || $course->user_id === $user->id;
    }

    /**
     * Any authenticated user can create courses.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Admin can update any course; user can only update their own.
     */
    public function update(User $user, Course $course): bool
    {
        return $user->role === 'admin' || $course->user_id === $user->id;
    }

    /**
     * Admin can delete any course; user can only delete their own.
     */
    public function delete(User $user, Course $course): bool
    {
        return $user->role === 'admin' || $course->user_id === $user->id;
    }

    /**
     * Admin can restore any course; user can only restore their own.
     */
    public function restore(User $user, Course $course): bool
    {
        return $user->role === 'admin' || $course->user_id === $user->id;
    }

    /**
     * Admin can force-delete any course; user can only force-delete their own.
     */
    public function forceDelete(User $user, Course $course): bool
    {
        return $user->role === 'admin' || $course->user_id === $user->id;
    }
}
