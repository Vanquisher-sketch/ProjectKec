<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\InfrastrukturController;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\OccupationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\YearController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman utama
Route::get('/', function () {
    return Auth::check() ? redirect()->route('dashboard') : redirect()->route('login');
});

// Route untuk Tamu
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate']);
    Route::get('/register', [AuthController::class, 'registerView']);
    Route::post('/register', [AuthController::class, 'register']);
});

// Grup untuk semua yang sudah login
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // --- GRUP MENU KEPENDUDUKAN ---
    // Aturan: Semua peran terkait (termasuk RT) bisa MELIHAT data
    Route::middleware('role:SUPERADMIN,KECAMATAN,KELURAHAN,RW,RT')->group(function () {
        Route::get('/resident', [ResidentController::class, 'index'])->name('resident.index');
        Route::get('/resident/{resident}', [ResidentController::class, 'show'])->name('resident.show');

        Route::get('/year', [YearController::class, 'index'])->name('year.index');
        Route::get('/year/{year}', [YearController::class, 'show'])->name('year.show');
        
        Route::get('/education', [EducationController::class, 'index'])->name('education.index');
        Route::get('/education/{education}', [EducationController::class, 'show'])->name('education.show');

        Route::get('/occupation', [OccupationController::class, 'index'])->name('occupation.index');
        Route::get('/occupation/{occupation}', [OccupationController::class, 'show'])->name('occupation.show');
    });

    // Aturan: Hanya peran tertentu (termasuk RT) yang bisa MENGELOLA (CRUD) data kependudukan
    Route::middleware('role:SUPERADMIN,KECAMATAN,RT')->group(function () {
        Route::resource('resident', ResidentController::class)->except(['index', 'show']);
        Route::resource('year', YearController::class)->except(['index', 'show']);
        Route::resource('education', EducationController::class)->except(['index', 'show']);
        Route::resource('occupation', OccupationController::class)->except(['index', 'show']);
        
        Route::get('/resident/cetak', [ResidentController::class, 'printPDF'])->name('resident.cetak');
        Route::get('/year/cetak', [YearController::class, 'printPDF'])->name('year.cetak');
        Route::get('/education/cetak', [EducationController::class, 'printPDF'])->name('education.cetak');
        Route::get('/occupation/cetak', [OccupationController::class, 'printPDF'])->name('occupation.cetak');
    });


    // --- GRUP MENU LINGKUNGAN & BARANG ---
    // Aturan: KELURAHAN ke atas bisa MELIHAT data
    Route::middleware('role:SUPERADMIN,KECAMATAN,KELURAHAN')->group(function () {
        Route::resource('infrastruktur', InfrastrukturController::class)->only(['index', 'show']);
        Route::resource('room', RoomController::class)->only(['index', 'show']);
        Route::resource('inventaris', InventarisController::class)->only(['index', 'show']);
    });

    // Aturan: Hanya KECAMATAN ke atas yang bisa MENGELOLA (CRUD) data lingkungan
    Route::middleware('role:SUPERADMIN,KECAMATAN')->group(function () {
        Route::resource('infrastruktur', InfrastrukturController::class)->except(['index', 'show']);
        Route::resource('room', RoomController::class)->except(['index', 'show']);
        Route::resource('inventaris', InventarisController::class)->except(['index', 'show']);

        Route::get('/infrastruktur/cetak', [InfrastrukturController::class, 'printPDF'])->name('infrastruktur.cetak');
        Route::get('/room/cetak', [RoomController::class, 'printPDF'])->name('room.cetak');
        Route::get('/inventaris/pdf', [InventarisController::class, 'exportPDF'])->name('inventaris.pdf');
    });


    // --- GRUP MENU AKUN (Hanya SUPERADMIN) ---
    Route::middleware('role:SUPERADMIN')->group(function () {
        Route::get('/user/cetak', [UserController::class, 'printPDF'])->name('user.cetak');
        Route::resource('user', UserController::class);
    });

    // --- GRUP LAPORAN (Semua bisa akses) ---
    Route::get('/report', [ReportController::class, 'index'])->name('report.index');
    Route::get('/report/cetak', [ReportController::class, 'printPDF'])->name('report.cetak');
});

