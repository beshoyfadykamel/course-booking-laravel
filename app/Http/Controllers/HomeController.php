<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Course;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $studentsCount = Student::forCurrentUser()->count();
        $coursesCount  = Course::forCurrentUser()->count();
        $bookingsCount = Booking::forCurrentUser()->count();
        $usersCount    = Auth::user()->isAdmin() ? User::count() : null;

        return view('home', compact('studentsCount', 'coursesCount', 'bookingsCount', 'usersCount'));
    }
}
