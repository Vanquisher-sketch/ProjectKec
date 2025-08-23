<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\InfrastrukturController;
use App\Http\Controllers\YearController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\OccupationController;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Halaman utama, mengarahkan berdasarkan status login
Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/dashboard');
    }
    return redirect('/login');
});

// Grup untuk route yang hanya bisa diakses oleh tamu (belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate']);
    Route::get('/register', [AuthController::class, 'registerView']);
    Route::post('/register', [AuthController::class, 'register']);
});

// Grup untuk route yang memerlukan login
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', function () {
        return view('pages.dashboard');
    })->middleware('role:Admin,User')->name('dashboard');

    // Grup untuk route yang hanya bisa diakses Admin
    Route::middleware('role:Admin')->group(function () {
        Route::post('/education', [App\Http\Controllers\EducationController::class, 'store'])->name('education.store');
        Route::get('/resident/cetak', [ResidentController::class, 'printPDF'])->name('resident.cetak');
        Route::resource('resident', ResidentController::class);
        Route::get('/infrastruktur/cetak', [InfrastrukturController::class, 'printPDF'])->name('infrastruktur.cetak');
        Route::resource('infrastruktur', InfrastrukturController::class);
        Route::get('/year/cetak', [YearController::class, 'printPDF'])->name('year.cetak');
        Route::resource('year', YearController::class);
        Route::get('/education/cetak', [EducationController::class, 'printPDF'])->name('education.cetak');
        Route::resource('education', EducationController::class);
        Route::get('/occupation/cetak', [OccupationController::class, 'printPDF'])->name('occupation.cetak');
        Route::resource('occupation', OccupationController::class);
        Route::get('/inventaris/cetak', [InventarisController::class, 'printPDF'])->name('inventaris.cetak');
        Route::resource('inventaris', InventarisController::class);
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
    });


// Tambahkan route ini

});