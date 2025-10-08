<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:sanctum');


// dosen

Route::middleware('auth:sanctum')->group(function () {

    Route::resource('/courses', CourseController::class)->only('index', 'store', 'update', 'destroy');

    Route::group(['prefix' => 'courses', 'as' => 'courses.'], function () {
        Route::post('/{id}/enroll', [CourseController::class, 'enroll'])->name('enroll');
    });
});
