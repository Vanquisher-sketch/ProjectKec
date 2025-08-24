@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        {{-- Judul dinamis sesuai ruangan --}}
        <h1 class="h3 mb-0 text-gray-800">Tambah Barang di Ruangan: <strong>{{ $ruangan->name }}</strong></h1>
    </div>

    {{-- Tampilkan error validasi jika ada --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            {{-- Form action mengarah ke route storeInRuangan sambil membawa ID ruangan --}}
            <form action="{{ route('inventaris.storeInRuangan', $ruangan->id) }}" method="POST">
                @csrf
                <div class="row">
                    {{-- Kolom Kiri --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama_barang">Nama Barang/Jenis Barang</label>
                            <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="{{ old('nama_barang') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="merk_model">Merk/Model</label>
                            <input type="text" class="form-control" id="merk_model" name="merk_model" value="{{ old('merk_model') }}">
                        </div>
                        <div class="form-group">
                            <label for="bahan">Bahan</label>
                            <input type="text" class="form-control" id="bahan" name="bahan" value="{{ old('bahan') }}">
                        </div>
                        <div class="form-group">
                            <label for="tahun_pembelian">Tahun Pembelian</label>
                            <input type="number" class="form-control" id="tahun_pembelian" name="tahun_pembelian" value="{{ old('tahun_pembelian') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="kode_barang">No. Kode Barang</label>
                            <input type="text" class="form-control" id="kode_barang" name="kode_barang" value="{{ old('kode_barang') }}" required>
                        </div>
                    </div>
                    {{-- Kolom Kanan --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jumlah">Jumlah</label>
                            <input type="number" class="form-control" id="jumlah" name="jumlah" value="{{ old('jumlah', 1) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="harga_perolehan">Harga Beli (Rp)</label>
                            <input type="number" class="form-control" id="harga_perolehan" name="harga_perolehan" value="{{ old('harga_perolehan') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="kondisi">Keadaan Barang</label>
                            <select class="form-control" id="kondisi" name="kondisi" required>
                                <option value="B" {{ old('kondisi') == 'B' ? 'selected' : '' }}>Baik (B)</option>
                                <option value="KB" {{ old('kondisi') == 'KB' ? 'selected' : '' }}>Kurang Baik (KB)</option>
                                <option value="RB" {{ old('kondisi') == 'RB' ? 'selected' : '' }}>Rusak Berat (RB)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3">{{ old('keterangan') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Simpan Barang</button>
                    <a href="{{ route('inventaris.byRuangan', $ruangan->id) }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection