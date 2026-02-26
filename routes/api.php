<?php

use App\Http\Controllers\Api\CourseController;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/courses', [CourseController::class, 'index']);

Route::get('/courses/{course}', [CourseController::class, 'show']);



Route::post('/courses/store', [CourseController::class, 'store']);


Route::put('/courses/update/{course}', [CourseController::class, 'update']);



Route::delete('/courses/delete/{course}', [CourseController::class, 'destroy']);


Route::delete('/courses/delete-permanently/{course}', [CourseController::class, 'deletePermanently']);