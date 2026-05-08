<?php

use Illuminate\Support\Facades\Route;

// Panggil Controller yang digunakan
use App\Http\Controllers\EventController; 
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\AboutController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Versi ini menyederhanakan route, memastikan nama unik, dan menyiapkan
| untuk navigasi kondisional (Beranda, Semua Acara).
*/


// --- PUBLIC ROUTES (Akses tanpa Login) ---

// Landing Page (Route utama, Beranda untuk Guest)
Route::get('/', [EventController::class, 'dashboard'])->name('dashboard');

// Daftar Semua Event (Akses Publik, Index)
// Route ini digunakan oleh tautan 'Semua Acara' di Navbar Public
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/search', [EventController::class, 'search'])->name('events.search'); 
// Asumsi: Anda ingin fungsi search juga tersedia secara publik

// Login/Register
Route::get('/register', [RegisterController::class, 'showRegister'])->name('register.show');
Route::post('/register', [RegisterController::class, 'register'])->name('register.perform');

Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.process');


// --- AUTHENTICATED USER ROUTES (Harus Login) ---
Route::middleware('auth')->group(function () {
    
    // Logout (Dipindahkan ke dalam middleware 'auth')
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    // Dashboard User (Halaman yang diakses saat menekan 'Beranda' setelah login)
    Route::get('/home', [UserDashboardController::class, 'index'])->name('user.home');

    // About Route
    Route::get('/about', [AboutController::class, 'index'])->name('about');

    // Event Management (CRUD)
    // Mengecualikan 'index' karena sudah didefinisikan secara publik, 
    // kecuali Anda ingin index untuk user terautentikasi berbeda.
    Route::resource('events', EventController::class)->except(['index']); 
    
    // Update Event Status (User Context)
    Route::post('/events/{eventId}/update-status/{status}', [EventController::class, 'updateStatus'])->name('events.updateStatus');

    
    // User Profile Routes
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [UserProfileController::class, 'show'])->name('show');
        Route::get('/edit', [UserProfileController::class, 'edit'])->name('edit');
        Route::post('/update', [UserProfileController::class, 'update'])->name('update');
        Route::get('/proposals', [UserProfileController::class, 'proposals'])->name('proposals');
    });
});


// --- ADMIN ROUTES ---
// Pastikan user memiliki role 'admin'
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard Admin (Target redirect untuk admin)
    Route::get('/home', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Kelola Event oleh Admin
    // Admin mungkin melihat daftar event dengan data tambahan, jadi biarkan index di sini.
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    
    // Approve/Reject Event (Method ini ada di EventController kamu)
    Route::post('/events/{id}/status/{status}', [EventController::class, 'updateStatus'])->name('event.status');
});