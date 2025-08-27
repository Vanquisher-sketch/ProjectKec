@extends('layouts.app')

@section('title', 'Data Inventaris Ruangan')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            Data Inventaris
            @if ($ruanganTerpilih)
                Ruangan: <strong>{{ $ruanganTerpilih->name }}</strong>
            @else
                <strong>Keseluruhan</strong>
            @endif
        </h1>
        <div>
            <a href="{{ route('inventaris.cetak', ['ruangan_id' => $selectedRuanganId]) }}" target="_blank" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm mr-2">
                <i class="fas fa-print fa-sm text-white-50"></i> Cetak PDF
            </a>
            <a href="{{ route('inventaris.create', ['room_id' => $selectedRuanganId]) }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Inventaris
            </a>
        </div>
    </div>

    <!-- TABEL DATA -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Barang</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th rowspan="2" class="align-middle text-center">No Urut</th>
                            <th rowspan="2" class="align-middle">Nama Barang/ Jenis Barang</th>
                            <th rowspan="2" class="align-middle">Merk/ Model</th>
                            <th rowspan="2" class="align-middle">Bahan</th>
                            <th rowspan="2" class="align-middle text-center">Tahun Pembelian</th>
                            <th rowspan="2" class="align-middle text-center">No. Kode Barang</th>
                            <th rowspan="2" class="align-middle text-center">Jumlah Barang</th>
                            <th rowspan="2" class="align-middle text-end">Harga Beli (Rp)</th>
                            <th colspan="3" class="text-center">Keadaan Barang</th>
                            <th rowspan="2" class="align-middle">Keterangan</th>
                            <th rowspan="2" class="align-middle text-center">Aksi</th>
                        </tr>
                        <tr>
                            <th class="text-center">Baik (B)</th>
                            <th class="text-center">Kurang Baik (KB)</th>
                            <th class="text-center">Rusak Berat (RB)</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @forelse ($daftarBarang as $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $item->nama_barang }}</td>
                            <td>{{ $item->merk_model }}</td>
                            <td>{{ $item->bahan }}</td>
                            <td class="text-center">{{ $item->tahun_pembelian }}</td>
                            <td class="text-center">{{ $item->kode_barang }}</td>
                            <td class="text-center">{{ $item->jumlah }}</td>
                            <td class="text-end">{{ number_format($item->harga_perolehan, 0, ',', '.') }}</td>
                            <td class="text-center">@if($item->kondisi == 'B') ✓ @endif</td>
                            <td class="text-center">@if($item->kondisi == 'KB') ✓ @endif</td>
                            <td class="text-center">@if($item->kondisi == 'RB') ✓ @endif</td>
                            <td>{{ $item->keterangan }}</td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    {{-- ====================================================================== --}}
                                    {{-- KODE YANG BENAR UNTUK SEMUA TOMBOL ADA DI SINI --}}
                                    {{-- Perhatikan penulisan ['inventari' => $item->id] yang benar --}}
                                    {{-- ====================================================================== --}}
                                    
                                    {{-- Tombol Edit --}}
                                    <a href="{{ route('inventaris.edit', ['inventaris' => $item->id]) }}" class="btn btn-sm btn-warning mr-1" title="Edit">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    
                                    {{-- Tombol Hapus --}}
                                    <form action="{{ route('inventaris.destroy', ['inventaris' => $item->id]) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger mr-1" title="Hapus"><i class="fas fa-eraser"></i></button>
                                    </form>

                                    {{-- Tombol Pindah Ruangan (mengarah ke halaman edit) --}}
                                    <a href="{{ route('inventaris.edit', ['inventaris' => $item->id]) }}" class="btn btn-sm btn-success" title="Pindah Ruangan">
                                        <i class="fas fa-exchange-alt"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="13" class="text-center">Data tidak ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
