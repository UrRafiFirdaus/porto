<?php

use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Livewire\Admin\EducationManager;
use App\Livewire\Admin\ExperienceManager;
use App\Livewire\Admin\MessageManager;
use App\Livewire\Admin\ProfileSettings;
use App\Livewire\Admin\ProjectManager;
use App\Livewire\Admin\SkillManager;
use Illuminate\Support\Facades\Route;

// Public Landing Page
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/download-cv', [HomeController::class, 'downloadCv'])->name('cv.download');

// Blokir rute /login dan /register bawaan agar tidak dapat diakses publik
Route::any('/register', function () {
    abort(404);
});
Route::any('/login', function () {
    abort(404);
});

// Rute Login Tersembunyi Khusus Admin
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

    // Area CMS Admin yang Dilindungi Middleware Auth & Level Admin
    Route::middleware(['auth', 'level:1'])->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/profile', ProfileSettings::class)->name('profile');
        Route::get('/projects', ProjectManager::class)->name('projects');
        Route::get('/experiences', ExperienceManager::class)->name('experiences');
        Route::get('/educations', EducationManager::class)->name('educations');
        Route::get('/skills', SkillManager::class)->name('skills');
        Route::get('/messages', MessageManager::class)->name('messages');
    });
});
