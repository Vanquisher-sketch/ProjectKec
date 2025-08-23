@extends('layouts.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Data Warga</h1>
    </div>

    <div class="row">
        <div class="col-lg-8 col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Formulir Data Warga</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('resident.store') }}" method="POST">
                        @csrf
                        {{-- @method('POST') tidak diperlukan karena method form sudah POST --}}
                        
                        {{-- Menampilkan error validasi general jika ada --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label for="status_tinggal" class="form-label">Status Tinggal</label>
                            <select name="status_tinggal" id="status_tinggal" class="form-control @error('status_tinggal') is-invalid @enderror">
                                <option value="" disabled selected>-- Pilih Status --</option>
                                <option value="tetap" {{ old('status_tinggal') == 'tetap' ? 'selected' : '' }}>Tetap</option>
                                <option value="pindahan" {{ old('status_tinggal') == 'pindahan' ? 'selected' : '' }}>Pindahan</option>
                            </select>
                            @error('status_tinggal')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            {{-- Kesalahan pada kode Anda ada di sini: div diberi class form-control --}}
                            <label for="jumlah" class="form-label">Jumlah</label>
                            {{-- Kesalahan lain: id="jumlah' -> ada petik tunggal yg salah --}}
                            <input type="number" name="jumlah" id="jumlah" class="form-control @error('jumlah') is-invalid @enderror" value="{{ old('jumlah') }}" placeholder="Masukkan jumlah warga...">
                             @error('jumlah')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Card-footer dipindah ke dalam form untuk menampung tombol --}}
                        <div class="mt-4 d-flex justify-content-end gap-10">
                             <a href="{{ route('resident.index') }}" class="btn btn-secondary">
                                Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Simpan Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection