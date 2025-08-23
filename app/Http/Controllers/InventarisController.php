<?php

namespace App\Http\Controllers;

use App\Models\Inventaris;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // Pastikan Rule di-import
use PDF;

class InventarisController extends Controller
{
    public function index()
    {
        $daftarBarang = Inventaris::all();
        return view('pages.inventaris.index', ['daftarBarang' => $daftarBarang]);
    }

    public function create()
    {
        return view('pages.inventaris.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_barang'     => 'required|string|max:255',
            'merk_model'      => 'nullable|string|max:255',
            'bahan'           => 'nullable|string|max:100',
            'tahun_pembelian' => 'required|integer|digits:4|min:1900|max:' . date('Y'),
            'kode_barang'     => 'required|string|max:50|unique:inventaris,kode_barang',
            'jumlah'          => 'required|integer|min:1',
            'harga_perolehan' => 'required|numeric|min:0',
            'kondisi'         => 'required|in:B,KB,RB',
            'keterangan'      => 'nullable|string',
        ]);

        Inventaris::create($validatedData);

        return redirect()->route('inventaris.index')
                         ->with('success', 'Data inventaris baru berhasil ditambahkan!');
    }

    /**
     * PERBAIKAN 1: Menggunakan Route-Model Binding.
     * Laravel akan otomatis mencari data Inventaris berdasarkan ID di URL.
     */
    public function edit(Inventaris $inventari)
    {
        return view('pages.inventaris.edit', [
            'inventaris' => $inventari,
        ]);
    }

    /**
     * PERBAIKAN 2: Menggunakan Route-Model Binding dan memperbaiki validasi 'unique'.
     */
    public function update(Request $request, Inventaris $inventari)
    {
        $validatedData = $request->validate([
            'nama_barang'     => 'required|string|max:255',
            'merk_model'      => 'nullable|string|max:255',
            'bahan'           => 'nullable|string|max:100',
            'tahun_pembelian' => 'required|integer|digits:4|min:1900|max:' . date('Y'),
            // Aturan 'unique' diupdate agar mengabaikan data yang sedang diedit
            'kode_barang'     => ['required', 'string', 'max:50', Rule::unique('inventaris')->ignore($inventari->id)],
            'jumlah'          => 'required|integer|min:1',
            'harga_perolehan' => 'required|numeric|min:0',
            'kondisi'         => 'required|in:B,KB,RB',
            'keterangan'      => 'nullable|string',
        ]);

        $inventari->update($validatedData);

        return redirect()->route('inventaris.index')->with('success', 'Berhasil mengubah data');
    }
    
    /**
     * PERBAIKAN 3: Menggunakan Route-Model Binding.
     */
    public function destroy(Inventaris $inventari)
    {
        $inventari->delete();
        return redirect()->route('inventaris.index')->with('success', 'Berhasil menghapus data');
    }
    public function printPDF() // atau cetakPDF()
{
    // Ambil data
    $daftarBarang = Inventaris::all();
    $total_jumlah = $daftarBarang->sum('jumlah');

    // Muat view PDF
    $pdf = PDF::loadView('pages.inventaris.cetak', [
        'daftarBarang' => $daftarBarang, // <-- UBAH DI SINI
        'total_jumlah' => $total_jumlah
    ]);

    // Atur kertas
    $pdf->setPaper('A4', 'landscape');

    // Tampilkan PDF
    return $pdf->stream('data-inventaris-ruangan.pdf');
}

}
