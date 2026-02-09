<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $studentsCount = Student::count();
        $coursesCount =  Course::count();
        $bookingsCount = Booking::count();
        return view('home', compact('studentsCount', 'coursesCount', 'bookingsCount'));
    }
}
