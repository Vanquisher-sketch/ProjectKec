<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // DATA GRAFIK RENTANG USIA
        $dataGrafikUsia = DB::table('years')
            ->selectRaw("
                CASE
                    WHEN tahun_lahir >= 2014 THEN '2014 - Sekarang'
                    WHEN tahun_lahir BETWEEN 2009 AND 2013 THEN '2009 - 2013'
                    ELSE 'Sebelum 2009'
                END as rentang_usia,
                COUNT(*) as jumlah
            ")
            ->groupBy('rentang_usia')
            ->orderBy('rentang_usia', 'asc')
            ->get();
        $labelsUsia = $dataGrafikUsia->pluck('rentang_usia');
        $dataUsia = $dataGrafikUsia->pluck('jumlah');

        // DATA GRAFIK STATUS PENDIDIKAN
        $dataGrafikPendidikan = DB::table('education')
            ->select('sekolah', 'jumlah')
            ->get();
        $labelsPendidikan = $dataGrafikPendidikan->pluck('sekolah');
        $dataPendidikan = $dataGrafikPendidikan->pluck('jumlah');

        // DATA GRAFIK STATUS PEKERJAAN
        $dataGrafikPekerjaan = DB::table('occupations')
            ->select('pekerjaan', 'jumlah')
            ->get();
        $labelsPekerjaan = $dataGrafikPekerjaan->pluck('pekerjaan');
        $dataPekerjaan = $dataGrafikPekerjaan->pluck('jumlah');

        // =======================================================
        // DATA BARU UNTUK GRAFIK STATUS KEPENDUDUKAN
        // =======================================================
        $dataGrafikKependudukan = DB::table('residents') // Asumsi nama tabel adalah 'residents'
            ->select('status_tinggal', 'jumlah') // Asumsi nama kolom adalah 'status_tinggal' dan 'jumlah'
            ->get();

        $labelsKependudukan = $dataGrafikKependudukan->pluck('status_tinggal');
        $dataKependudukan = $dataGrafikKependudukan->pluck('jumlah');

        // =======================================================
        // KIRIM SEMUA DATA KE VIEW
        // =======================================================
        return view('pages.dashboard', compact(
            'labelsUsia', 'dataUsia',
            'labelsPendidikan', 'dataPendidikan',
            'labelsPekerjaan', 'dataPekerjaan',
            'labelsKependudukan', 'dataKependudukan' // <-- Variabel baru
        ));
    }
}