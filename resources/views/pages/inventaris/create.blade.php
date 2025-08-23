@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Inventaris Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-center">Form Tambah Barang Inventaris</h3>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('inventaris.store') }}" method="POST">
                        @csrf <div class="mb-3">
                            <label for="nama_barang" class="form-label">Nama Barang/Jenis Barang</label>
                            <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="{{ old('nama_barang') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="merk_model" class="form-label">Merk/Model</label>
                            <input type="text" class="form-control" id="merk_model" name="merk_model" value="{{ old('merk_model') }}">
                        </div>
                        
                        <div class="mb-3">
                            <label for="bahan" class="form-label">Bahan</label>
                            <input type="text" class="form-control" id="bahan" name="bahan" value="{{ old('bahan') }}">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="tahun_pembelian" class="form-label">Tahun Pembelian</label>
                                <input type="number" class="form-control" id="tahun_pembelian" name="tahun_pembelian" value="{{ old('tahun_pembelian') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="kode_barang" class="form-label">No. Kode Barang</label>
                                <input type="text" class="form-control" id="kode_barang" name="kode_barang" value="{{ old('kode_barang') }}" required>
                            </div>
                        </div>

                        <div class="row">
                             <div class="col-md-6 mb-3">
                                <label for="jumlah" class="form-label">Jumlah</label>
                                <input type="number" class="form-control" id="jumlah" name="jumlah" value="{{ old('jumlah', 1) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="harga_perolehan" class="form-label">Harga Beli (Rp)</label>
                                <input type="number" class="form-control" id="harga_perolehan" name="harga_perolehan" value="{{ old('harga_perolehan') }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kondisi Barang</label>
                            <select class="form-select" name="kondisi" required>
                                <option value="">Pilih Kondisi</option>
                                <option value="B" {{ old('kondisi') == 'B' ? 'selected' : '' }}>Baik (B)</option>
                                <option value="KB" {{ old('kondisi') == 'KB' ? 'selected' : '' }}>Kurang Baik (KB)</option>
                                <option value="RB" {{ old('kondisi') == 'RB' ? 'selected' : '' }}>Rusak Berat (RB)</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3">{{ old('keterangan') }}</textarea>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Simpan Data</button>
                            <a href="{{ route('inventaris.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
@endsection