@extends('layouts.app')

@section('title', 'Edit Data Inventaris')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Inventaris: {{ $inventaris->nama_barang }}</h1>
    </div>

    {{-- Tampilkan Notifikasi Error --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Edit -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Formulir Perubahan Data Barang</h6>
        </div>
        <div class="card-body">
            {{-- Arahkan form ke route 'inventaris.update' dengan metode PUT/PATCH --}}
            <form action="{{ route('inventaris.update', $inventaris->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    {{-- Kolom Kiri --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama_barang">Nama Barang / Jenis Barang</label>
                            <input type="text" class="form-control" id="nama_barang" name="nama_barang" 
                                   value="{{ old('nama_barang', $inventaris->nama_barang) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="merk_model">Merk / Model</label>
                            <input type="text" class="form-control" id="merk_model" name="merk_model"
                                   value="{{ old('merk_model', $inventaris->merk_model) }}">
                        </div>
                        <div class="form-group">
                            <label for="bahan">Bahan</label>
                            <input type="text" class="form-control" id="bahan" name="bahan"
                                   value="{{ old('bahan', $inventaris->bahan) }}">
                        </div>
                        <div class="form-group">
                            <label for="tahun_pembelian">Tahun Pembelian</label>
                            <input type="number" class="form-control" id="tahun_pembelian" name="tahun_pembelian"
                                   placeholder="Contoh: 2023" value="{{ old('tahun_pembelian', $inventaris->tahun_pembelian) }}">
                        </div>
                         <div class="form-group">
                            <label for="kode_barang">Nomor Kode Barang</label>
                            <input type="text" class="form-control" id="kode_barang" name="kode_barang"
                                   value="{{ old('kode_barang', $inventaris->kode_barang) }}">
                        </div>
                    </div>

                    {{-- Kolom Kanan --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jumlah">Jumlah Barang</label>
                            <input type="number" class="form-control" id="jumlah" name="jumlah"
                                   value="{{ old('jumlah', $inventaris->jumlah) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="harga_perolehan">Harga Beli (Rp)</label>
                            <input type="number" class="form-control" id="harga_perolehan" name="harga_perolehan"
                                   placeholder="Contoh: 500000" value="{{ old('harga_perolehan', $inventaris->harga_perolehan) }}">
                        </div>
                        <div class="form-group">
                            <label for="kondisi">Keadaan Barang</label>
                            <select class="form-control" id="kondisi" name="kondisi" required>
                                <option value="B" {{ old('kondisi', $inventaris->kondisi) == 'B' ? 'selected' : '' }}>Baik (B)</option>
                                <option value="KB" {{ old('kondisi', $inventaris->kondisi) == 'KB' ? 'selected' : '' }}>Kurang Baik (KB)</option>
                                <option value="RB" {{ old('kondisi', $inventaris->kondisi) == 'RB' ? 'selected' : '' }}>Rusak Berat (RB)</option>
                            </select>
                        </div>
                         <div class="form-group">
                            <label for="ruangan_id">Lokasi Ruangan (Pindahkan)</label>
                            <select class="form-control" id="ruangan_id" name="ruangan_id" required>
                                <option value="">-- Pilih Ruangan --</option>
                                @foreach($ruangans as $ruangan)
                                    <option value="{{ $ruangan->id }}" {{ old('ruangan_id', $inventaris->ruangan_id) == $ruangan->id ? 'selected' : '' }}>
                                        {{ $ruangan->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="2">{{ old('keterangan', $inventaris->keterangan) }}</textarea>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('inventaris.index') }}" class="btn btn-secondary mr-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Update Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
