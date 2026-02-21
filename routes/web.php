<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

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
| Authenticated Routes (Admin + User)
|--------------------------------------------------------------------------
| Controllers use forCurrentUser() scope to filter data per role.
| Policies handle authorization. No route duplication needed.
*/
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Courses
    Route::prefix('courses')->name('courses.')->group(function () {
        Route::get('/', [CourseController::class, 'index'])->name('index');
        Route::get('/search', [CourseController::class, 'search'])->name('search');
        Route::get('/enrollment-search', [CourseController::class, 'enrollmentSearch'])->name('enrollment.search');
        Route::get('/create', [CourseController::class, 'create'])->name('create');
        Route::post('/', [CourseController::class, 'store'])->name('store');
        Route::get('/archive/list', [CourseController::class, 'recycle'])->name('recycle');
        Route::get('/archive/search', [CourseController::class, 'recycleSearch'])->name('recycle.search');
        Route::get('/{id}', [CourseController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [CourseController::class, 'edit'])->name('edit');
        Route::put('/{id}', [CourseController::class, 'update'])->name('update');
        Route::delete('/{id}', [CourseController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/restore', [CourseController::class, 'restore'])->name('restore');
        Route::delete('/{id}/permanent', [CourseController::class, 'deletePermanently'])->name('delete-permanently');
    });

    // Students
    Route::prefix('students')->name('students.')->group(function () {
        Route::get('/', [StudentController::class, 'index'])->name('index');
        Route::get('/search', [StudentController::class, 'search'])->name('search');
        Route::get('/enrollment-search', [StudentController::class, 'enrollmentSearch'])->name('enrollment.search');
        Route::get('/create', [StudentController::class, 'create'])->name('create');
        Route::post('/', [StudentController::class, 'store'])->name('store');
        Route::get('/archive/list', [StudentController::class, 'recycle'])->name('recycle');
        Route::get('/archive/search', [StudentController::class, 'recycleSearch'])->name('recycle.search');
        Route::get('/{id}', [StudentController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [StudentController::class, 'edit'])->name('edit');
        Route::put('/{id}', [StudentController::class, 'update'])->name('update');
        Route::delete('/{id}', [StudentController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/restore', [StudentController::class, 'restore'])->name('restore');
        Route::delete('/{id}/permanent', [StudentController::class, 'deletePermanently'])->name('delete-permanently');
    });

    // Bookings
    Route::prefix('bookings')->name('bookings.')->group(function () {
        Route::get('/', [BookingController::class, 'index'])->name('index');
        Route::get('/search', [BookingController::class, 'search'])->name('search');
        Route::get('/create', [BookingController::class, 'create'])->name('create');
        Route::post('/', [BookingController::class, 'store'])->name('store');
        Route::get('/archive/list', [BookingController::class, 'recycle'])->name('recycle');
        Route::get('/archive/search', [BookingController::class, 'recycleSearch'])->name('recycle.search');
        Route::get('/{id}', [BookingController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [BookingController::class, 'edit'])->name('edit');
        Route::put('/{id}', [BookingController::class, 'update'])->name('update');
        Route::delete('/{id}', [BookingController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/restore', [BookingController::class, 'restore'])->name('restore');
        Route::delete('/{id}/permanent', [BookingController::class, 'deletePermanently'])->name('delete-permanently');
    });

    /*
    |----------------------------------------------------------------------
    | Admin-Only Routes
    |----------------------------------------------------------------------
    */
    Route::middleware('role:admin')->prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/search', [UserController::class, 'search'])->name('search');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/archive/list', [UserController::class, 'recycle'])->name('recycle');
        Route::get('/archive/search', [UserController::class, 'recycleSearch'])->name('recycle.search');
        Route::get('/{id}', [UserController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/restore', [UserController::class, 'restore'])->name('restore');
        Route::delete('/{id}/permanent', [UserController::class, 'deletePermanently'])->name('delete-permanently');
    });
});
