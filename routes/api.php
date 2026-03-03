<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\Auth\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);

/*
|--------------------------------------------------------------------------
| Courses
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function 
() {
Route::prefix('auth')->group(function () {
    Route::post('/logout', [LogoutController::class, 'logout']);
});



    Route::prefix('courses')->group(function () {

        // Collection
        Route::get('/',        [CourseController::class, 'index']);
        Route::get('/recycle', [CourseController::class, 'recycle']);

        // CRUD
        Route::post('/store',         [CourseController::class, 'store']);
        Route::get('/{course}',  [CourseController::class, 'show'])->withTrashed();
        Route::put('/{course}/update',  [CourseController::class, 'update']);
        Route::delete('/{course}/delete', [CourseController::class, 'destroy']);

        // Soft-delete actions
        Route::patch('/{course}/restore',  [CourseController::class, 'restore'])->withTrashed();
        Route::delete('/{course}/force',   [CourseController::class, 'deletePermanently'])->withTrashed();
    });
});
