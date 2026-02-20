<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

require __DIR__ . '/auth.php';

Route::post('/lang', function (\Illuminate\Http\Request $request) {
    $locale = $request->input('locale');

    if (! in_array($locale, ['ar', 'en'])) {
        abort(400);
    }

    session(['locale' => $locale]);

    return redirect()->back();
})->name('lang.set');

/*
|--------------------------------------------------------------------------
| Shared Routes (used by both admin and normal user)
|--------------------------------------------------------------------------
| Defined once, registered twice — with and without the /admin prefix.
| Admin sees all data; user sees only their own (handled by OwnedByUser trait).
*/
$sharedRoutes = function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Courses
    Route::prefix('courses')->group(function () {
        Route::get('/', [CourseController::class, 'index'])->name('courses.index');
        Route::get('/search', [CourseController::class, 'search'])->name('courses.search');
        Route::get('/enrollment-search', [CourseController::class, 'enrollmentSearch'])->name('courses.enrollment.search');
        Route::get('/create', [CourseController::class, 'create'])->name('courses.create');
        Route::post('/store', [CourseController::class, 'store'])->name('courses.store');
        Route::get('/show/{id}', [CourseController::class, 'show'])->name('courses.show');
        Route::get('/edit/{id}', [CourseController::class, 'edit'])->name('courses.edit');
        Route::put('/update/{id}', [CourseController::class, 'update'])->name('courses.update');
        Route::delete('/destroy/{id}', [CourseController::class, 'destroy'])->name('courses.destroy');
        Route::get('/recycle', [CourseController::class, 'recycle'])->name('courses.recycle');
        Route::get('/recycle-search', [CourseController::class, 'recycleSearch'])->name('courses.recycle.search');
        Route::post('/restore/{id}', [CourseController::class, 'restore'])->name('courses.restore');
        Route::delete('/delete-permanently/{id}', [CourseController::class, 'deletePermanently'])->name('courses.delete-permanently');
    });

    // Students
    Route::prefix('students')->group(function () {
        Route::get('/', [StudentController::class, 'index'])->name('students.index');
        Route::get('/search', [StudentController::class, 'search'])->name('students.search');
        Route::get('/enrollment-search', [StudentController::class, 'enrollmentSearch'])->name('students.enrollment.search');
        Route::get('/create', [StudentController::class, 'create'])->name('students.create');
        Route::post('/store', [StudentController::class, 'store'])->name('students.store');
        Route::get('/show/{id}', [StudentController::class, 'show'])->name('students.show');
        Route::get('/edit/{id}', [StudentController::class, 'edit'])->name('students.edit');
        Route::put('/update/{id}', [StudentController::class, 'update'])->name('students.update');
        Route::delete('/destroy/{id}', [StudentController::class, 'destroy'])->name('students.destroy');
        Route::get('/recycle', [StudentController::class, 'recycle'])->name('students.recycle');
        Route::get('/recycle-search', [StudentController::class, 'recycleSearch'])->name('students.recycle.search');
        Route::post('/restore/{id}', [StudentController::class, 'restore'])->name('students.restore');
        Route::delete('/delete-permanently/{id}', [StudentController::class, 'deletePermanently'])->name('students.delete-permanently');
    });

    // Bookings
    Route::prefix('bookings')->group(function () {
        Route::get('/', [BookingController::class, 'index'])->name('bookings.index');
        Route::get('/search', [BookingController::class, 'search'])->name('bookings.search');
        Route::get('/create', [BookingController::class, 'create'])->name('bookings.create');
        Route::post('/store', [BookingController::class, 'store'])->name('bookings.store');
        Route::get('/show/{id}', [BookingController::class, 'show'])->name('bookings.show');
        Route::get('/edit/{id}', [BookingController::class, 'edit'])->name('bookings.edit');
        Route::put('/update/{id}', [BookingController::class, 'update'])->name('bookings.update');
        Route::delete('/destroy/{id}', [BookingController::class, 'destroy'])->name('bookings.destroy');
        Route::get('/recycle', [BookingController::class, 'recycle'])->name('bookings.recycle');
        Route::get('/recycle-search', [BookingController::class, 'recycleSearch'])->name('bookings.recycle.search');
        Route::post('/restore/{id}', [BookingController::class, 'restore'])->name('bookings.restore');
        Route::delete('/delete-permanently/{id}', [BookingController::class, 'deletePermanently'])->name('bookings.delete-permanently');
    });
};

// Normal user routes: /home, /courses, /students, /bookings
Route::middleware(['auth', 'role:user'])->group($sharedRoutes);

// Admin routes: /admin/home, /admin/courses, /admin/students, /admin/bookings
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group($sharedRoutes);
