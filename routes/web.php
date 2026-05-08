<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EventController; 
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\Admin\EventController as AdminEventController;






Route::get('/', [EventController::class, 'dashboard'])->name('dashboard');

Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/search', [EventController::class, 'search'])->name('events.search'); 

Route::get('/register', [RegisterController::class, 'showRegister'])->name('register.show');
Route::post('/register', [RegisterController::class, 'register'])->name('register.perform');

Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.process');


Route::middleware('auth')->group(function () {
    
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    Route::get('/home', [UserDashboardController::class, 'index'])->name('user.home');

    Route::get('/about', [AboutController::class, 'index'])->name('about');

    Route::resource('events', EventController::class)->only(['create', 'store', 'show']); 
    
    Route::post('/events/{eventId}/update-status/{status}', [EventController::class, 'updateStatus'])->name('events.updateStatus');

    
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [UserProfileController::class, 'show'])->name('show');
        Route::get('/edit', [UserProfileController::class, 'edit'])->name('edit');
        Route::post('/update', [UserProfileController::class, 'update'])->name('update');
        Route::get('/proposals', [UserProfileController::class, 'proposals'])->name('proposals');
    });
});


Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/home', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/events', [AdminEventController::class, 'index'])->name('events.index');
    
    Route::get('/events/{event}/edit', [AdminEventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [AdminEventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [AdminEventController::class, 'destroy'])->name('events.destroy');

    Route::post('/events/{id}/status/{status}', [AdminEventController::class, 'updateStatus'])->name('event.status');
});
