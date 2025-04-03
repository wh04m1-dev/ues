<?php

use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\EducationController;
use App\Http\Controllers\Api\ExamController;
use App\Http\Controllers\Api\InformationRegisterController;
use App\Http\Controllers\Api\ParentsController;
use App\Http\Controllers\api\PersonalController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [UserController::class, 'userProfile']);
    Route::post('/logout', [UserController::class, 'logout']);

//   Route for personal data
    Route::post('/personal', [PersonalController::class, 'store']);
    Route::get('/personal', [PersonalController::class, 'index']);

    // Route for parent data 
    Route::get('/parents', [ParentsController::class, 'index']);
    Route::post('/parents', [ParentsController::class, 'store']);

    //Rpute for education data 
    Route::post('education', [EducationController::class, 'store']);
    Route::get('education', [EducationController::class, 'index']);

    // Route for register information 
    Route::get('information', [InformationRegisterController::class, 'index']);
    Route::post('information', [InformationRegisterController::class, 'store']);

    Route::post('/department', [DepartmentController::class, 'store']);
    Route::get('/department', [DepartmentController::class, 'index']);
    Route::put('/department/{id}', [DepartmentController::class, 'update']);
    Route::delete('/department/{id}', [DepartmentController::class, 'destroy']);



    Route::post('/exam', [ExamController::class, 'store']);
    Route::get('/exam', [ExamController::class, 'index']);



});

// Route::middleware(['auth:sanctum', 'admin'])->group(function () {
//     Route::post('/department', [DepartmentController::class, 'store']);
//     Route::put('/department/{id}', [DepartmentController::class, 'update']);
//     Route::delete('/department/{id}', [DepartmentController::class, 'destroy']);
// });

