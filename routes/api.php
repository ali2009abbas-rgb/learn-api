<?php


use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\LessonController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\InstructorDashboardController;
use Illuminate\Support\Facades\Route;

// مسارات عامة
Route::get('/courses', [CourseController::class, 'index']);

// مسارات محمية بمصادقة Sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/courses', [CourseController::class, 'store']);
    Route::put('/courses/{course}', [CourseController::class, 'update']);

    Route::post('/lessons', [LessonController::class, 'store']);
    Route::post('/comments', [CommentController::class, 'store']);

    // لوحة تحكم المدرس (آخر التعليقات)
    Route::get('/instructor/comments/latest', [InstructorDashboardController::class, 'latestComments']);
});
