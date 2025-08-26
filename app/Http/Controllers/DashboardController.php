<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Year;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class DashboardController extends Controller
{
    public function index()
    {
        return view('pages.dashboard');
    }

    // =================================================================
    // ▼▼▼ PENGATURAN UTAMA ▼▼▼
    // =================================================================
    
    // Pastikeun nami tabel ieu LERES saluyu sareng database anjeun.
    // Ieu bakal dianggo ku sadaya fungsi chart di handap.
    private $namaTabelPenduduk = 'residents';

    // =================================================================
    // ▼▼▼ FUNGSI IEU TOS LERES, TEU KEDAH DIROBIH ▼▼▼
    // =================================================================
    public function chartKependudukan()
    {
        try {
            $data = DB::table($this->namaTabelPenduduk) 
                        ->select('status_tinggal', DB::raw('count(*) as jumlah'))
                        ->groupBy('status_tinggal')
                        ->get();
            
            $labels = $data->pluck('status_tinggal');
            $values = $data->pluck('jumlah');

            return response()->json(['labels' => $labels, 'data' => $values]);
        } catch (QueryException $e) {
            // Ngirim pesen error anu langkung jelas upami aya masalah query
            return response()->json(['message' => 'Error di chartKependudukan: ' . $e->getMessage()], 500);
        }
    }

    // =================================================================
    // ▼▼▼ BAGIAN ANU TOS DIBENERKEUN ▼▼▼
    // =================================================================

    /**
     * Fungsi pikeun data chart dumasar kana taun kalahiran.
     */
    public function chartTahunKelahiran()
    {
        try {
            // Léngkah 1: Buka phpMyAdmin, tingali nami kolom kanggo TANGGAL LAHIR.
            // Léngkah 2: Gentos 'birth_date' di handap ieu sareng nami kolom anu leres di tabel anjeun.
            $namaKolomTahunLahir = 'tahun_lahir'; 

            // KESALAHAN LAMI: DB::table($this->$namaKolomTahunLahir) -> Ieu lepat, kedahna nganggo nami tabel utama.
            // KESALAHAN LAMI: Variabel $tahun_lahir teu aya -> Kedah dilebetkeun langsung kana string query.
            $data = Year::table($this->tahun_lahir) // <-- DIBENERKEUN: Nganggo nami tabel anu leres
                ->select(
                    // Ngadamel kolom virtual 'kelompok_tahun' nganggo CASE
                    Year::raw("CASE 
                        WHEN YEAR({$namaKolomTahunLahir}) < 1990 THEN 'Di handap 1990'
                        WHEN YEAR({$namaKolomTahunLahir}) BETWEEN 1990 AND 2000 THEN '1990 - 2000'
                        ELSE 'Di luhur 2000'
                    END as kelompok_tahun"), // <-- DIBENERKEUN: Alias digentos janten 'kelompok_tahun'
                    Year::raw("count(*) as jumlah")
                )
                ->groupBy('kelompok_tahun') // <-- DIBENERKEUN: Ngelompokkeun dumasar kana alias anu nembe didamel
                ->get();
            
            // KESALAHAN LAMI: $data->pluck('kelompok_tahun') -> Sateuacana aliasna lepat.
            $labels = $data->pluck('kelompok_tahun'); // <-- DIBENERKEUN: Ayeuna tos saluyu
            $values = $data->pluck('jumlah');

            return response()->json(['labels' => $labels, 'data' => $values]);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error di chartTahunKelahiran: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Fungsi pikeun data chart dumasar kana pendidikan.
     */
    public function chartPendidikan()
    {
        try {
            // Léngkah 1: Buka phpMyAdmin, tingali nami kolom kanggo PENDIDIKAN.
            // Léngkah 2: Gentos 'education' di handap ieu sareng nami kolom anu leres.
            $namaKolomPendidikan = 'education';

            // KESALAHAN LAMI: DB::table($this->education) -> Lepat, kedahna nganggo nami tabel utama.
            // KESALAHAN LAMI: Variabel $sekolah teu aya.
            $data = DB::table($this->namaTabelPenduduk) // <-- DIBENERKEUN: Nganggo nami tabel anu leres
                        ->select($namaKolomPendidikan, DB::raw('count(*) as jumlah')) // <-- DIBENERKEUN: Nganggo variabel anu leres
                        ->groupBy($namaKolomPendidikan) // <-- DIBENERKEUN: Nganggo variabel anu leres
                        ->get();

            $labels = $data->pluck($namaKolomPendidikan); // <-- DIBENERKEUN: Nganggo variabel anu leres
            $values = $data->pluck('jumlah');
            
            return response()->json(['labels' => $labels, 'data' => $values]);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error di chartPendidikan: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Fungsi pikeun data chart dumasar kana padamelan.
     */
    public function chartPekerjaan()
    {
        try {
            // Léngkah 1: Buka phpMyAdmin, tingali nami kolom kanggo PADAMELAN.
            // Léngkah 2: Gentos 'occupation' di handap ieu sareng nami kolom anu leres.
            $namaKolomPekerjaan = 'occupation';

            // KESALAHAN LAMI: DB::table($this->occupation) -> Lepat, kedahna nganggo nami tabel utama.
            // KESALAHAN LAMI: Variabel $pekerjaan teu aya.
            $data = DB::table($this->namaTabelPenduduk) // <-- DIBENERKEUN: Nganggo nami tabel anu leres
                        ->select($namaKolomPekerjaan, DB::raw('count(*) as jumlah')) // <-- DIBENERKEUN: Nganggo variabel anu leres
                        ->groupBy($namaKolomPekerjaan) // <-- DIBENERKEUN: Nganggo variabel anu leres
                        ->get();

            $labels = $data->pluck($namaKolomPekerjaan); // <-- DIBENERKEUN: Nganggo variabel anu leres
            $values = $data->pluck('jumlah');

            return response()->json(['labels' => $labels, 'data' => $values]);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error di chartPekerjaan: ' . $e->getMessage()], 500);
        }
    }
}
