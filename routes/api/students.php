<?php

use App\Http\Controllers\Api\AssignmentController;
use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\ExamScheduleController;
use App\Http\Controllers\Api\MarkController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\SectionScheduleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StudentController;
use Illuminate\Routing\RouteRegistrar;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('students/login', [StudentController::class, 'login']);

Route::middleware(['auth:sanctum', 'abilities:student'])
    ->prefix('students')->group(function(){
    Route::get('profile', [StudentController::class, 'profile']);

    Route::get('courses', [CourseController::class, 'index']);
Route::get('courses/about', [CourseController::class, 'show']);

    Route::get('assignments', [AssignmentController::class, 'index']);
    Route::get('assignments/homepage', [AssignmentController::class, 'homePageIndex']);
    Route::put('assignments/{id}', [AssignmentController::class, 'check']);

    Route::get('posts', [PostController::class, 'index']);

    Route::get('marks', [MarkController::class, 'index']);
    Route::get('totals', [MarkController::class, 'total']);

    Route::get('schedules', [SectionScheduleController::class , 'index']);
    Route::get('examschedule', [ExamScheduleController::class, 'index']);
    Route::get('attendances', [AttendanceController::class, 'attendanceCount']);

    Route::get('years', [MarkController::class, 'getYears']);
});
