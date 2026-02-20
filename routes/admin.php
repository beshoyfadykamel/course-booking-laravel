<?php

use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin-Only Routes
|--------------------------------------------------------------------------
| Routes here are EXCLUSIVELY for admins (e.g., user management, settings).
| Shared routes (courses, students, bookings) are registered in web.php
| using a shared closure for both admin and user roles.
*/

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    // Users Management
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('/search', [UserController::class, 'search'])->name('users.search');
        Route::get('/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/store', [UserController::class, 'store'])->name('users.store');
        Route::get('/show/{id}', [UserController::class, 'show'])->name('users.show');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/update/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/destroy/{id}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::get('/recycle', [UserController::class, 'recycle'])->name('users.recycle');
        Route::get('/recycle-search', [UserController::class, 'recycleSearch'])->name('users.recycle.search');
        Route::post('/restore/{id}', [UserController::class, 'restore'])->name('users.restore');
        Route::delete('/delete-permanently/{id}', [UserController::class, 'deletePermanently'])->name('users.delete-permanently');
    });
});
