<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ParentsController;
use App\Http\Controllers\Api\PersonalController;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\EducationController;
use App\Http\Controllers\Api\ExamController;
use App\Http\Controllers\Api\RegistrationController;
use App\Http\Controllers\Api\ResultController;

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::get('/departments', [DepartmentController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [UserController::class, 'userProfile']);
    Route::post('/logout', [UserController::class, 'logout']);

    Route::get('/parents', [ParentsController::class, 'index']);
    Route::get('/parents/{id}', [ParentsController::class, 'show']);
    Route::post('/parents', [ParentsController::class, 'store']);
    Route::put('/parents/{id}', [ParentsController::class, 'update']);
    Route::delete('/parents/{id}', [ParentsController::class, 'destroy']);

    Route::get('/personal', [PersonalController::class, 'index']);
    Route::get('/personal/{id}', [PersonalController::class, 'show']);
    Route::post('/personal', [PersonalController::class, 'store']);
    Route::put('/personal/{id}', [PersonalController::class, 'update']);
    Route::delete('/personal/{id}', [PersonalController::class, 'destroy']);

    Route::post('/departments', [DepartmentController::class, 'store']);
    Route::put('/departments/{id}', [DepartmentController::class, 'update']);
    Route::delete('/departments/{id}', [DepartmentController::class, 'destroy']);

    Route::get('/education', [EducationController::class, 'index']);
    Route::post('/education', [EducationController::class, 'store']);
    Route::put('/education/{id}', [EducationController::class, 'update']);
    Route::delete('/education/{id}', [EducationController::class, 'destroy']);

    Route::get('/exams', [ExamController::class, 'index']);
    Route::get('/exams/{id}', [ExamController::class, 'show']);
    Route::post('/exams', [ExamController::class, 'store']);
    Route::put('/exams/{id}', [ExamController::class, 'update']);
    Route::delete('/exams/{id}', [ExamController::class, 'destroy']);

    Route::get('/registrations', [RegistrationController::class, 'index']);
    Route::post('/registrations', [RegistrationController::class, 'store']);
    Route::delete('/registrations/{id}', [RegistrationController::class, 'destroy']);
    Route::put('/registrations/{id}', [RegistrationController::class, 'update']);

    Route::get('/results', [ResultController::class, 'index']);
    Route::post('/results', [ResultController::class, 'store']);
    Route::put('/results/{id}', [ResultController::class, 'update']);
    Route::delete('/results/{id}', [ResultController::class, 'destroy']);
});
