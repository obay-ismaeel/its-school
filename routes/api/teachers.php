<?php

use App\Http\Controllers\Api\CalendarController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TeacherController;
use App\Http\Controllers\CalenderController;
use App\Models\CalendarItem;
use App\Models\Teacher;

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

Route::prefix('teachers', function(){
    Route::post('teachers/login', [TeacherController::class, 'login']);
    Route::get('profile', [TeacherController::class, 'profile'])
        ->middleware(['auth:sanctum', 'abilities:teacher']);
    Route::get('logout', [TeacherController::class, 'logout']);
});

Route::get('calendar', [CalendarController::class, 'index']);
