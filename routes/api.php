<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    UserController,
    DepartmentController,
    ExamController,
    RegistrationController,
};

// Public Routes
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/departments', [DepartmentController::class, 'index']); // Allow public access to department list

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {

    // User actions
    Route::get('/profile', [UserController::class, 'userProfile']);
    Route::post('/logout', [UserController::class, 'logout']);

    // Full CRUD with apiResource
    Route::apiResource('exams', ExamController::class);
    Route::apiResource('registrations', RegistrationController::class);
});
