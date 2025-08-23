@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Manajemen Akun Pengguna</h1>
    <div>
        {{-- Menggunakan helper route() lebih disarankan daripada URL statis --}}
        <a href="{{ route('user.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Pengguna
        </a>
    </div>
</div>

{{-- Notifikasi Sukses (Opsional tapi sangat direkomendasikan) --}}
@if (session('success'))
    <div class="alert alert-success shadow" role="alert">
        {{ session('success') }}
    </div>
@endif

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Akun</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Role</th>
                        <th width="100px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Menggunakan @forelse untuk penanganan data kosong yang lebih bersih --}}
                    @forelse ($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            {{-- Menggunakan badge untuk tampilan status yang lebih menarik --}}
                            @if($user->status == 'aktif')
                                <span class="badge badge-success">Aktif</span>
                            @else
                                <span class="badge badge-danger">Tidak Aktif</span>
                            @endif
                        </td>
                        <td>
                            {{-- Menampilkan nama role, bukan ID-nya. Asumsi ada relasi 'role' di model User --}}
                            <span class="badge badge-info">{{ $user->role->name ?? 'N/A' }}</span>
                        </td>
                        <td>
                            <div class="d-flex justify-content-around">
                                <a href="{{ route('user.edit', $user->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-pen"></i>
                                </a>
                                {{-- Tombol ini memicu modal tunggal dengan melewatkan data ID --}}
                                <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="{{ $user->id }}" data-bs-toggle="modal" data-bs-target="#confirmationDelete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        {{-- Memperbaiki colspan agar sesuai jumlah kolom --}}
                        <td colspan="6" class="text-center">
                            Tidak ada data untuk ditampilkan.
                        </td>
                    </tr>
                    @include('pages.user.confirmation-delete')
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')
{{-- Tambahkan script ini untuk membuat modal hapus menjadi dinamis --}}
<script>
    // Menunggu dokumen siap
    document.addEventListener('DOMContentLoaded', function () {
        // Cari semua tombol dengan class 'delete-btn'
        const deleteButtons = document.querySelectorAll('.delete-btn');
        const deleteForm = document.getElementById('deleteForm');
        
        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                // Ambil ID pengguna dari atribut data-id
                const userId = this.getAttribute('data-id');
                // Buat URL action untuk form delete
                const url = `/user/${userId}`;
                // Set action form dengan URL yang baru
                deleteForm.setAttribute('action', url);
            });
        });
    });
</script>
@endpush