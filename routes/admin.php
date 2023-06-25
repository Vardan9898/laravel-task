<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Web\EventController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth')->group(function () {
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/users/{user}', [UsersController::class, 'show'])->name('users.show');
Route::post('/events/{event}/participate', [EventController::class, 'participate'])->name('events.participate');
Route::post('/events/{event}/cancel-participation', [EventController::class, 'cancelParticipation'])->name('events.cancelParticipation');
});
