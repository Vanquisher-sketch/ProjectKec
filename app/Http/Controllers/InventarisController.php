<?php

namespace App\Http\Controllers;

use App\Models\Inventaris;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use PDF;

class InventarisController extends Controller
{
    /**
     * FUNGSI UTAMA: Menampilkan daftar inventaris.
     */
    public function index(Request $request)
    {
        $daftarRuangan = Room::orderBy('name', 'asc')->get();
        $queryInventaris = Inventaris::query()->with('room');
        $selectedRuanganId = $request->input('room_id');
        $ruanganTerpilih = null;

        if ($selectedRuanganId) {
            $queryInventaris->where('room_id', $selectedRuanganId);
            $ruanganTerpilih = Room::find($selectedRuanganId);
        }

        $daftarBarang = $queryInventaris->get();

        return view('pages.inventaris.index', [
            'daftarRuangan'  => $daftarRuangan,
            'daftarBarang'   => $daftarBarang,
            'ruanganTerpilih'=> $ruanganTerpilih,
            'selectedRuanganId' => $selectedRuanganId
        ]);
    }

    /**
     * Menampilkan form untuk membuat data inventaris baru.
     */
    public function create(Request $request)
    {
        $daftarRuangan = Room::orderBy('name', 'asc')->get();
        $selectedRoomId = $request->input('room_id');

        return view('pages.inventaris.create', [
            'daftarRuangan' => $daftarRuangan,
            'selectedRoomId' => $selectedRoomId
        ]);
    }

    /**
     * Menyimpan data inventaris baru ke database.
     */
    public function store(Request $request)
    {
        // ===================================================================
        // Baris debugging di bawah ini sudah dihapus/dikomentari.
        // ===================================================================
        // dd($request->all());
        // ===================================================================

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
            'room_id'         => 'required|exists:rooms,id'
        ]);

        Inventaris::create($validatedData);

        return redirect()->route('inventaris.index', ['room_id' => $request->room_id])
                         ->with('success', 'Data inventaris baru berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit data inventaris.
     */
    public function edit(Inventaris $inventari)
    {
        $daftarRuangan = Room::orderBy('name', 'asc')->get();
        return view('pages.inventaris.edit', [
            'inventaris' => $inventari,
            'daftarRuangan' => $daftarRuangan,
        ]);
    }

    /**
     * Mengupdate data inventaris di database.
     */
    public function update(Request $request, Inventaris $inventari)
    {
        $validatedData = $request->validate([
            'nama_barang'     => 'required|string|max:255',
            'merk_model'      => 'nullable|string|max:255',
            'bahan'           => 'nullable|string|max:100',
            'tahun_pembelian' => 'required|integer|digits:4|min:1900|max:' . date('Y'),
            'kode_barang'     => ['required', 'string', 'max:50', Rule::unique('inventaris')->ignore($inventari->id)],
            'jumlah'          => 'required|integer|min:1',
            'harga_perolehan' => 'required|numeric|min:0',
            'kondisi'         => 'required|in:B,KB,RB',
            'keterangan'      => 'nullable|string',
            'room_id'         => 'required|exists:rooms,id'
        ]);

        $inventari->update($validatedData);

        return redirect()->route('inventaris.index', ['room_id' => $request->room_id])
                         ->with('success', 'Berhasil mengubah data');
    }

    /**
     * Menghapus data inventaris dari database.
     */
    public function destroy(Inventaris $inventari)
    {
        $roomId = $inventari->room_id;
        $inventari->delete();
        return redirect()->route('inventaris.index', ['room_id' => $roomId])
                         ->with('success', 'Berhasil menghapus data');
    }

    /**
     * Membuat file PDF dari data inventaris.
     */
    public function printPDF(Request $request)
    {
        $queryInventaris = Inventaris::query();
        $namaRuangan = 'Semua Ruangan';

        if ($request->has('ruangan_id') && $request->ruangan_id) {
            $queryInventaris->where('room_id', $request->ruangan_id);
            $ruangan = Room::find($request->ruangan_id);
            if($ruangan) {
                $namaRuangan = $ruangan->name;
            }
        }

        $daftarBarang = $queryInventaris->get();
        $total_jumlah = $daftarBarang->sum('jumlah');

        $pdf = PDF::loadView('pages.inventaris.cetak', [
            'daftarBarang' => $daftarBarang,
            'total_jumlah' => $total_jumlah,
            'namaRuangan'  => $namaRuangan
        ]);

        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream('data-inventaris-ruangan-'.$namaRuangan.'.pdf');
    }
}
