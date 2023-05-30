<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GuardianController;

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
Route::post('guardians/login', [GuardianController::class, 'login']);
Route::get('guardians/profile', [GuardianController::class, 'profile'])
        ->middleware(['auth:sanctum', 'abilities:guardian']);
