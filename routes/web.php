<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminStudentController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\CourseController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/students', [AdminStudentController::class, 'index'])->name('admin.students.index');
Route::get('/admin/students/{student}/qrcode', [AdminStudentController::class, 'showQrCode'])->name('admin.students.qrcode');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
    Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');

    Route::get('/sessions', [SessionController::class, 'index'])->name('sessions.index');
    Route::post('/sessions', [SessionController::class, 'store'])->name('sessions.store');
    Route::get('/sessions/{session}/qrcode', [SessionController::class, 'getQrCode'])->name('sessions.qrcode');
    Route::get('/sessions/{session}/attendance', [SessionController::class, 'show'])->name('sessions.attendance');
    Route::get('/sessions/{session}', [SessionController::class, 'show'])->name('sessions.show');
    Route::post('/sessions/scan', [SessionController::class, 'scanQrCode'])->name('sessions.scan');

    Route::resource('sessions', SessionController::class);
});
