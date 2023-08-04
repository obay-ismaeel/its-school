<?php

use App\Http\Controllers\Api\AssignmentController;
use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\GradeController;
use App\Http\Controllers\Api\MarkController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\StudentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TeacherController;
use App\Http\Controllers\Api\TeacherGradesController;
use App\Http\Controllers\Api\TeacherSchedule;
use PHPUnit\Framework\Attributes\PostCondition;

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
Route::post('teachers/login', [TeacherController::class, 'login']);
Route::middleware(['auth:sanctum', 'abilities:teacher'])
    ->prefix('teachers')->group(function(){
        Route::get('profile', [TeacherController::class, 'profile'])
            ->middleware(['auth:sanctum', 'abilities:teacher']);
        Route::get('logout', [TeacherController::class, 'logout']);
        Route::get('schedule', [TeacherSchedule::class, 'index']);
        Route::get('sections/{section}/students', [StudentController::class, 'bySection']);
        Route::get('grades', [TeacherGradesController::class, 'index']);
        Route::get('grades/{grade}/sections', [TeacherGradesController::class, 'sections']);
        Route::post('attendance', [AttendanceController::class, 'store']);
        Route::post('assignments', [AssignmentController::class, 'store']);
        Route::post('students/{student}/marks', [MarkController::class, 'teacherStore']);
        Route::get('sections/{section}/courses', [GradeController::class, 'teacherIndex']);
        Route::get('schedule/days', [TeacherSchedule::class, 'getDays']);
        Route::post('students/{student}/marks', [MarkController::class, 'teacherStore']);
        Route::get('marks/types', [MarkController::class, 'getTypes']);
        Route::post('posts', [PostController::class, 'store']);
    });
