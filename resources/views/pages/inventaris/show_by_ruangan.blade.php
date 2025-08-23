{{-- resources/views/inventaris/show_by_ruangan.blade.php --}}

@extends('layouts.app') {{-- Sesuaikan dengan nama layout utama Anda --}}

@section('content')
<div class="container-fluid">

    <!-- Judul Halaman Dinamis -->
    <h1 class="h3 mb-2 text-gray-800">Daftar Inventaris</h1>
    <p class="mb-4">Menampilkan semua barang inventaris yang berada di <strong>{{ $ruangan->room }}</strong>.</p>

    <!-- Tabel Data -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Inventaris</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Merek</th>
                            <th>Jumlah</th>
                            <th>Kondisi</th>
                            {{-- Tambahkan kolom lain sesuai kebutuhan --}}
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($daftarBarang as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama_barang }}</td>
                                <td>{{ $item->merek }}</td>
                                <td>{{ $item->jumlah }}</td>
                                <td>{{ $item->kondisi }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">
                                    Belum ada data inventaris di ruangan ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection