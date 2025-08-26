<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use App\Models\Year;
use App\Models\Occupation;
use App\Models\Education;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // WAJIB di-import untuk query lanjutan
use PDF;

class ReportController extends Controller
{
    /**
     * Menampilkan halaman laporan dengan data yang sudah diagregasi.
     */
    public function index()
    {
        // 1. Data Status Kependudukan (digrouping)
        $residents = Resident::query()
            ->select('status_tinggal', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('status_tinggal')
            ->get();
        $total_residents = $residents->sum('jumlah');

        // 2. Data Tahun Kelahiran (digrouping dari tanggal lahir)
        $years = Year::query()
            ->select(DB::raw('YEAR(tahun_lahir) as tahun_lahir'), DB::raw('COUNT(*) as jumlah')) // <-- DIUBAH
            ->whereNotNull('tahun_lahir') // <-- DIUBAH
            ->groupBy('tahun_lahir')
            ->orderBy('tahun_lahir', 'desc')
            ->get();
        $total_years = $years->sum('jumlah');

        // 3. Data Pekerjaan (digrouping)
        $occupations = Occupation::query()
            ->select('pekerjaan', DB::raw('COUNT(*) as jumlah'))
            ->whereNotNull('pekerjaan') // Hindari pekerjaan yang kosong
            ->groupBy('pekerjaan')
            ->get();
        $total_occupations = $occupations->sum('jumlah');

        // 4. Data Pendidikan (digrouping)
        $educations = Education::query()
            ->select('sekolah', DB::raw('COUNT(*) as jumlah'))
            ->whereNotNull('sekolah') // Hindari sekolah yang kosong
            ->groupBy('sekolah')
            ->get();
        $total_educations = $educations->sum('jumlah');

        // Kirim SEMUA variabel yang dibutuhkan ke view
        return view('pages.report.index', compact(
            'residents',
            'total_residents', // <-- Diperbaiki: Sekarang dikirim ke view
            'years',
            'total_years',     // <-- Diperbaiki: Sekarang dikirim ke view
            'occupations',
            'total_occupations',// <-- Diperbaiki: Sekarang dikirim ke view
            'educations',
            'total_educations' // <-- Diperbaiki: Sekarang dikirim ke view
        ));
    }

    /**
     * Membuat dan menampilkan laporan dalam format PDF.
     */
    public function printPDF()
    {
        // Logika query untuk PDF harus sama dengan method index()
        // Anda bisa memanggil ulang query di sini atau membuat method terpisah
        // untuk menghindari duplikasi kode.

        // Untuk saat ini, kita duplikasi saja agar jelas
        $residents = Resident::query()->select('status_tinggal', DB::raw('COUNT(*) as jumlah'))->groupBy('status_tinggal')->get();
        $total_residents = $residents->sum('jumlah');

        $years = Year::query()->select(DB::raw('YEAR(tahun_lahir) as tahun_lahir'), DB::raw('COUNT(*) as jumlah'))->whereNotNull('tahun_lahir')->groupBy('tahun_lahir')->orderBy('tahun_lahir', 'desc')->get();
        $total_years = $years->sum('jumlah');

        $occupations = Occupation::query()->select('pekerjaan', DB::raw('COUNT(*) as jumlah'))->whereNotNull('pekerjaan')->groupBy('pekerjaan')->get();
        $total_occupations = $occupations->sum('jumlah');

        $educations = Education::query()->select('sekolah', DB::raw('COUNT(*) as jumlah'))->whereNotNull('sekolah')->groupBy('sekolah')->get();
        $total_educations = $educations->sum('jumlah');

        // Siapkan semua data yang akan dikirim ke view PDF
        $data = [
            'residents'         => $residents,
            'total_residents'   => $total_residents,
            'years'             => $years,
            'total_years'       => $total_years,
            'occupations'       => $occupations,
            'total_occupations' => $total_occupations,
            'educations'        => $educations,
            'total_educations'  => $total_educations,
        ];

        // Muat view PDF dengan data yang sudah disiapkan
        $pdf = PDF::loadView('pages.report.cetak', $data);
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('laporan-data-warga.pdf');
    }
}
