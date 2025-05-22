<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\SessionController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route publique pour le scan de QR code
Route::post('sessions/scan', [SessionController::class, 'scanQrCode']);

Route::middleware('auth:sanctum')->group(function () {
    // Student routes
    Route::apiResource('students', StudentController::class);
    Route::get('students/{student}/qr-code', [StudentController::class, 'getQrCode']);

    // Course routes
    Route::apiResource('courses', CourseController::class);
    Route::get('courses/{course}/qr-code', [CourseController::class, 'getQrCode']);

    // Attendance routes
    Route::apiResource('attendances', AttendanceController::class);
    Route::post('attendances/scan', [AttendanceController::class, 'scanQrCode']);
});
