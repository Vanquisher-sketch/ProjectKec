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
|
| Di sini Anda mendaftarkan semua route untuk aplikasi. Route ini
| dimuat oleh RouteServiceProvider dan semuanya akan
| ditugaskan ke grup middleware "web".
|
*/

// Halaman utama, mengarahkan berdasarkan status login
Route::get('/', function () {
    return Auth::check() ? redirect()->route('dashboard') : redirect()->route('login');
});

// Grup untuk route yang hanya bisa diakses oleh tamu (belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate']);
    Route::get('/register', [AuthController::class, 'registerView']);
    Route::post('/register', [AuthController::class, 'register']);
});

// Grup untuk semua route yang memerlukan login
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard dapat diakses oleh semua peran yang sudah login
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // --- GRUP UNTUK MENU KEPENDUDUKAN ---
    // Aturan: SUPERADMIN, KECAMATAN, dan RT memiliki akses penuh (CRUD).
    Route::middleware('role:SUPERADMIN,KECAMATAN,RT')->group(function () {
        Route::get('/resident/cetak', [ResidentController::class, 'printPDF'])->name('resident.cetak');
        Route::resource('resident', ResidentController::class);

        Route::get('/year/cetak', [YearController::class, 'printPDF'])->name('year.cetak');
        Route::resource('year', YearController::class);

        Route::get('/education/cetak', [EducationController::class, 'printPDF'])->name('education.cetak');
        Route::resource('education', EducationController::class);

        Route::get('/occupation/cetak', [OccupationController::class, 'printPDF'])->name('occupation.cetak');
        Route::resource('occupation', OccupationController::class);
    });

    // Aturan: KELURAHAN dan RW hanya memiliki akses lihat (read-only).
    Route::middleware('role:KELURAHAN,RW')->group(function () {
        Route::resource('resident', ResidentController::class)->only(['index', 'show']);
        Route::resource('year', YearController::class)->only(['index', 'show']);
        Route::resource('education', EducationController::class)->only(['index', 'show']);
        Route::resource('occupation', OccupationController::class)->only(['index', 'show']);
    });


    // --- GRUP UNTUK MENU LINGKUNGAN & BARANG ---
    // Aturan: SUPERADMIN dan KECAMATAN memiliki akses penuh (CRUD).
    Route::middleware('role:SUPERADMIN,KECAMATAN')->group(function () {
        Route::get('/infrastruktur/cetak', [InfrastrukturController::class, 'printPDF'])->name('infrastruktur.cetak');
        Route::resource('infrastruktur', InfrastrukturController::class);

        Route::get('/room/cetak', [RoomController::class, 'printPDF'])->name('room.cetak');
        Route::resource('room', RoomController::class);

        Route::get('/inventaris/pdf', [InventarisController::class, 'exportPDF'])->name('inventaris.pdf');
        Route::resource('inventaris', InventarisController::class);
    });

    // Aturan: KELURAHAN hanya memiliki akses lihat (read-only).
    Route::middleware('role:KELURAHAN')->group(function () {
        Route::resource('infrastruktur', InfrastrukturController::class)->only(['index', 'show']);
        Route::resource('room', RoomController::class)->only(['index', 'show']);
        Route::resource('inventaris', InventarisController::class)->only(['index', 'show']);
    });


    // --- GRUP UNTUK MANAJEMEN AKUN ---
    // Aturan: Hanya SUPERADMIN yang memiliki akses penuh (CRUD).
    Route::middleware('role:SUPERADMIN')->group(function () {
        Route::get('/user/cetak', [UserController::class, 'printPDF'])->name('user.cetak');
        Route::resource('user', UserController::class);
    });

    // --- GRUP UNTUK LAPORAN ---
    // Aturan: Semua peran dapat mengakses laporan.
    Route::get('/report/cetak', [ReportController::class, 'printPDF'])->name('report.cetak');
    Route::get('/report', [ReportController::class, 'index'])->name('report.index');

});
