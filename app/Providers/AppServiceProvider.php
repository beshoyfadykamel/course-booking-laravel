<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Course;
use App\Models\Student;
use App\Models\Booking;
use App\Policies\UserPolicy;
use App\Policies\CoursePolicy;
use App\Policies\StudentPolicy;
use App\Policies\BookingPolicy;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Course::class => CoursePolicy::class,
        Student::class => StudentPolicy::class,
        Booking::class => BookingPolicy::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useTailwind();

        Gate::define('access-admin', function (User $user) {
            return $user->role === 'admin';
        });
    }
}
