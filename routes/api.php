<?php

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/students', function () {
    // إرجاع الطلاب مع حجوزاتهم (Bookings) والكورسات المرتبطة
    $students = Student::with(['bookings.course', 'bookings.user'])->get();
    return response()->json([
        'students' => $students
    ]);
});
