<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Pastikan untuk mengimpor DB facade
use App\Models\Resident; // Ganti dengan nama model Anda jika ada

class DashboardController extends Controller
{
    public function index()
    {
        // Mengambil data dari database dan mengelompokkannya
        // Query ini akan menghitung jumlah baris untuk setiap 'status_tinggal'
        $residentData = Resident::select('status_tinggal', Resident::raw('count(*) as jumlah'))
                        ->groupBy('status_tinggal')
                        ->get();

        // Memisahkan data menjadi label (untuk nama status) dan data (untuk jumlah)
        // agar bisa dibaca oleh Chart.js
        $labels = $residentData->pluck('status_tinggal');
        $data = $residentData->pluck('jumlah');

        // Kirim data ke view dashboard
        return view('pages.dashboard', compact('labels', 'data'));
    }
}