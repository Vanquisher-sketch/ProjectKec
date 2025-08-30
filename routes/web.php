<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\InfrastrukturController;
use App\Http\Controllers\YearController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\OccupationController;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ReportController;
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
    })->middleware('role:Admin,kecamatan,kelurahan,rw,rt')->name('dashboard');

    // Grup untuk route yang hanya bisa diakses Admin
    Route::middleware('role:Admin,kecamatan')->group(function () {
        Route::post('/education', [EducationController::class, 'store'])->name('education.store');
        Route::get('/resident/cetak', [ResidentController::class, 'printPDF'])->name('resident.cetak');
        Route::resource('resident', ResidentController::class);
        Route::get('/infrastruktur/cetak', [InfrastrukturController::class, 'printPDF'])->name('infrastruktur.cetak');
        Route::resource('infrastruktur', InfrastrukturController::class);
        Route::get('/year/cetak', [YearController::class, 'printPDF'])->name('year.cetak');
        Route::resource('year', YearController::class);
        Route::get('/education/cetak', [EducationController::class, 'printPDF'])->name('education.cetak');
        Route::resource('education', EducationController::class);
        Route::get('/occupation/cetak', [OccupationController::class, 'printPDF'])->name('occupation.cetak');
        Route::resource('occupation',OccupationController::class);

        // --- BAGIAN INVENTARIS (SUDAH DIPERBAIKI) ---

        // Route untuk menampilkan inventaris berdasarkan ruangan.
        Route::get('/inventaris/room/{room}', [InventarisController::class, 'showByRoom'])->name('inventaris.showByRoom');
        
        // Route untuk mencetak PDF.
        Route::get('/inventaris/pdf', [InventarisController::class, 'exportPDF'])->name('inventaris.pdf');
        // Tambahkan route ini untuk menangani logika pindah ruangan
        Route::patch('/inventaris/{item}/pindah', [InventarisController::class, 'pindahRuangan'])->name('inventaris.pindah');
        Route::resource('inventaris', InventarisController::class);
       
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/room/cetak', [RoomController::class, 'printPDF'])->name('room.cetak');
        Route::resource('room', RoomController::class);
        Route::get('/user/cetak', [UserController::class, 'printPDF'])->name('user.cetak');
        Route::resource('user', UserController::class);
        Route::get('/report/cetak', [ReportController::class, 'printPDF'])->name('report.cetak');
        Route::resource('report', ReportController::class);
        Route::get('/chart/kependudukan', [DashboardController::class, 'chartKependudukan'])->name('chart.kependudukan');
        Route::get('/chart/tahun-kelahiran', [DashboardController::class, 'chartTahunKelahiran'])->name('chart.tahun_kelahiran');
        Route::get('/chart/pendidikan', [DashboardController::class, 'chartPendidikan'])->name('chart.pendidikan');
        Route::get('/chart/pekerjaan', [DashboardController::class, 'chartPekerjaan'])->name('chart.pekerjaan');
    
    
    });

});
