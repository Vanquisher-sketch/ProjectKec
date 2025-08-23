@extends('layouts.app')

@section('content')
             <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Data Inventaris Ruangan</h1>
            <div>
            {{-- TOMBOL CETAK PDF BARU --}}
            <a href="{{ route('inventaris.cetak') }}" target="_blank" class="d-none d-sm-inline-block btn btn-sm btn-danger btn-success shadow-sm mr-2">
                <i class="fas fa-print fa-sm text-white-50"></i> Cetak PDF
            </a>
            {{-- TOMBOL TAMBAH DATA --}}
            <a href="/inventaris/create" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Tambah
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
                            <div class="d-flex">
                                    {{-- GANTI TOMBOL LAMA ANDA DENGAN INI --}}
                                    <a href="{{ route('inventaris.edit', $item->id) }}" class="d-inline-block mr-2 btn btn-sm btn-warning">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#confirmationDelete-{{ $item->id }}">
                                        <i class="fas fa-eraser"></i>
                                    </button>
                                </div>
                            </td>
                        </tr> 
                        @include('pages.inventaris.confirmation-delete')
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="13" class="text-center">Data inventaris masih kosong.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
