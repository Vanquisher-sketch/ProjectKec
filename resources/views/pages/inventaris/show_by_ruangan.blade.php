@extends('layouts.app')

@section('content')
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            {{-- PERBAIKAN 1: Gunakan variabel $ruangan (tunggal) untuk menampilkan nama --}}
            <h1 class="h3 mb-0 text-gray-800">Inventaris Ruangan: <strong>{{ $ruangan->name }}</strong></h1>
            
            <div>
                {{-- TOMBOL CETAK PDF (OPSIONAL) --}}
                <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-danger btn-success shadow-sm mr-2">
                    <i class="fas fa-print fa-sm text-white-50"></i> Cetak PDF Ruangan
                </a>

                {{-- PERBAIKAN 2: Gunakan variabel $ruangan (tunggal) untuk link tambah barang --}}
                <a href="{{ route('inventaris.createinroom', $ruangan->id) }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                    <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Barang
                </a>
            </div>
        </div>

    <div class="row">
        <div class="table-responsive">
            <table class="table table-bordered table-hovered">
                <thead>
                    <tr>
                        <th rowspan="2" class="align-middle">No Urut</th>
                        <th rowspan="2" class="align-middle">Nama Barang/ Jenis Barang</th>
                        <th rowspan="2" class="align-middle">Merk/ Model</th>
                        <th rowspan="2" class="align-middle">Bahan</th>
                        <th rowspan="2" class="align-middle">Tahun Pembelian</th>
                        <th rowspan="2" class="align-middle">No. Kode Barang</th>
                        <th rowspan="2" class="align-middle">Jumlah</th>
                        <th rowspan="2" class="align-middle">Harga Beli (Rp)</th>
                        <th colspan="3" class="text-center">Keadaan Barang</th>
                        <th rowspan="2" class="align-middle">Keterangan</th>
                        <th rowspan="2" class="align-middle">Aksi</th>
                    </tr>
                    <tr>
                        <th>Baik (B)</th>
                        <th>Kurang Baik (KB)</th>
                        <th>Rusak Berat (RB)</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- PERBAIKAN 3: Gunakan variabel $inventarisItems untuk menampilkan daftar barang --}}
                    @forelse ($inventarisItems as $item)
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
                            <div class="d-flex">
                                <a href="{{ route('inventaris.edit', $item->id) }}" class="d-inline-block mr-2 btn btn-sm btn-warning">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#confirmationDelete-{{ $item->id }}">
                                    <i class="fas fa-eraser"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    {{-- Pastikan modal konfirmasi hapus di-include di sini --}}
                    @include('pages.inventaris.confirmation-delete')
                    @empty
                    <tr>
                        <td colspan="13" class="text-center">Data inventaris di ruangan ini masih kosong.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection