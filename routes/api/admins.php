<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\CourseGradeController;
use App\Http\Controllers\Api\GradeController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\SectionController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\TeacherController;
use App\Http\Controllers\Api\GuardianController;
use App\Models\GradeCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::post('admins/login', [AdminController::class, 'login']);

Route::middleware(['auth:sanctum', 'abilities:admin'])
    ->prefix('admins')->group(function(){
        Route::get('profile', [AdminController::class, 'profile']);

        Route::get('courses', [CourseController::class, 'webIndex']);
        Route::post('courses', [CourseController::class, 'store']);
        Route::put('courses/{course}', [CourseController::class, 'update']);
        Route::delete('courses/{course}', [CourseController::class, 'destroy']);

        Route::get('grades', [GradeController::class, 'index']);
        Route::post('grades', [GradeController::class, 'store']);
        Route::put('grades/{grade}', [GradeController::class, 'update']);
        Route::delete('grades/{grade}', [GradeController::class, 'destroy']);

        Route::post('sections', [SectionController::class, 'store']);
        Route::put('sections/{section}', [SectionController::class, 'update']);
        Route::delete('sections/{section}', [SectionController::class, 'destroy']);

        Route::get('reports', [ReportController::class, 'index']);
        Route::delete('reports/{report}', [ReportController::class, 'destroy']);

        Route::get('grade/{id}/courses', [CourseGradeController::class, 'index']);
        Route::post('grades/courses', [CourseGradeController::class, 'store']);
        Route::put('grade/course', [CourseGradeController::class, 'update']);
        Route::delete('grade/course', [CourseGradeController::class, 'destroy']);

        Route::get('students', [StudentController::class, 'index']);
        Route::post('students', [StudentController::class, 'store']);
        Route::patch('students/{student}', [StudentController::class, 'update']);
        Route::delete('students/{student}', [StudentController::class, 'destroy']);
        Route::get('students/{student}', [StudentController::class, 'show']);

        Route::get('teachers', [TeacherController::class, 'index']);
        Route::post('teachers', [TeacherController::class, 'store']);
        Route::patch('teachers/{teacher}', [TeacherController::class, 'update']);
        Route::delete('teachers/{teacher}', [TeacherController::class, 'destroy']);
        Route::get('teachers/{teacher}', [TeacherController::class, 'show']);

        Route::get('guardians', [GuardianController::class, 'index']);
        Route::post('guardians', [GuardianController::class, 'store']);
        Route::patch('guardians/{guardian}', [GuardianController::class, 'update']);
        Route::delete('guardians/{guardian}', [GuardianController::class, 'destroy']);
        Route::get('guardians/{guardian}', [GuardianController::class, 'show']);

        Route::get('homepage', [AdminController::class, 'homePage']);
    });

