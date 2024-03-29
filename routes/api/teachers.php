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
use App\Models\Mark;
use App\Http\Controllers\Api\AlertController;
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
        Route::post('logout', [TeacherController::class, 'logout']);

        Route::get('schedule/days', [TeacherSchedule::class, 'getDays']);
        Route::get('schedule', [TeacherSchedule::class, 'index']);

        Route::get('grades', [TeacherGradesController::class, 'index']);
        Route::get('grades/{grade}/sections', [TeacherGradesController::class, 'sections']);

        Route::get('sections/{section}/students', [StudentController::class, 'bySection']);
        Route::post('attendance', [AttendanceController::class, 'store']);
        Route::get('teachers-attendance', [TeacherController::class, 'notPrincipleIndex']);
        Route::post('teachers-attendance', [AttendanceController::class, 'teacherStore']);

        Route::get('sections/{section}/assignments', [AssignmentController::class, 'bySection']); //yo order
        Route::post('assignments', [AssignmentController::class, 'store']);

        Route::get('sections/{section}/courses', [GradeController::class, 'teacherIndex']);

        Route::post('students/{student}/marks', [MarkController::class, 'teacherStore']);
        Route::get('students/{student}/mark', [MarkController::class, 'getMark']);
        Route::get('marks/types', [MarkController::class, 'getTypes']);

        Route::get('students/{student}', [StudentController::class, 'profile']);

        Route::post('posts', [PostController::class, 'store']);
        Route::get('grades/{grade}/posts', [PostController::class, 'byGrade']);
        Route::delete('posts/{post}', [PostController::class, 'destroy']);

        Route::post('alerts', [AlertController::class, 'store']);
    });
