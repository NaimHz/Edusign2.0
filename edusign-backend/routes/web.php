<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminStudentController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;

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
    return redirect()->route('login');
});

// Routes d'authentification
Route::get('register', [RegisteredUserController::class, 'create'])
    ->name('register')
    ->middleware('guest');
Route::post('register', [RegisteredUserController::class, 'store'])
    ->middleware('guest');

Route::get('login', [AuthenticatedSessionController::class, 'create'])
    ->name('login')
    ->middleware('guest');
Route::post('login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest');

Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout')
    ->middleware('auth');

// Routes d'administration
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    // Routes pour les étudiants
    Route::get('/students', [AdminStudentController::class, 'index'])->name('students.index');
    Route::post('/students', [AdminStudentController::class, 'store'])->name('students.store');
    Route::get('/students/{student}/qrcode', [AdminStudentController::class, 'showQrCode'])->name('students.qrcode');

    // Routes pour les cours
    Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
    Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');

    // Routes pour les séances
    Route::get('/sessions', [SessionController::class, 'index'])->name('sessions.index');
    Route::post('/sessions', [SessionController::class, 'store'])->name('sessions.store');
    Route::get('/sessions/{session}/qrcode', [SessionController::class, 'getQrCode'])->name('sessions.qrcode');
    Route::get('/sessions/{session}/attendance', [SessionController::class, 'show'])->name('sessions.attendance');
    Route::get('/sessions/{session}', [SessionController::class, 'show'])->name('sessions.show');
    Route::post('/sessions/scan', [SessionController::class, 'scanQrCode'])->name('sessions.scan');

    Route::resource('sessions', SessionController::class);
});
