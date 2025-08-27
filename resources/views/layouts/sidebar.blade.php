@php
    // Array untuk menu dinamis berdasarkan role user
    $menus = [
        1 => [
            (object)[
                'title' => 'Dashboard',
                'path' => 'dashboard',
                'icon' => 'fas fa-fw fa-tachometer-alt',
            ],
            (object)[
                'title' => 'Status Kependudukan',
                'path' => 'resident',
                'icon' => 'fas fa-fw fa-table',
            ],
        ],
        2 => [
            (object)[
                'title' => 'Dashboard',
                'path' => 'dashboard',
                'icon' => 'fas fa-fw fa-tachometer-alt',
            ],
        ],
    ];

    // Mengambil data semua ruangan untuk ditampilkan di submenu inventaris.
    $ruangansForSidebar = \App\Models\Room::orderBy('name', 'asc')->get();
@endphp

<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-info sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/dashboard') }}">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('img/tsk.png') }}" alt="Logo" style="width: 40px; border-radius: 60%;">
        </div>
        <div class="sidebar-brand-text mx-3">SIDIUK</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Menu Dinamis Berdasarkan Role -->
    @foreach ($menus[auth()->user()->role_id] as $menu)
        <li class="nav-item {{ request()->is($menu->path . '*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url($menu->path) }}">
                <i class="{{ $menu->icon }}"></i>
                <span>{{ $menu->title }}</span>
            </a>
        </li>
    @endforeach

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Manajemen Data
    </div>

    <!-- Menu-menu Statis -->
    <li class="nav-item {{ request()->is('year*') ? 'active' : '' }}">
        <a class="nav-link" href="/year">
            <i class="fas fa-regular fa-calendar-check"></i>
            <span>Data Tahun Kelahiran</span>
        </a>
    </li>
    <li class="nav-item {{ request()->is('education*') ? 'active' : '' }}">
        <a class="nav-link" href="/education">
            <i class="fas fa-regular fa-school"></i>
            <span>Data Status Pendidikan</span>
        </a>
    </li>
    <li class="nav-item {{ request()->is('occupation*') ? 'active' : '' }}">
        <a class="nav-link" href="/occupation">
            <i class="fas fa-regular fa-city"></i>
            <span>Data Status Pekerjaan</span>
        </a>
    </li>

    <!-- Heading -->
    <div class="sidebar-heading">
        Kondisi Lingkungan
    </div>

    <li class="nav-item {{ request()->is('infrastruktur*') ? 'active' : '' }}">
        <a class="nav-link" href="/infrastruktur">
            <i class="fas fa-fw fa-landmark"></i>
            <span>Data Infrastrukur</span>
        </a>
    </li>

    <!-- Heading -->
    <div class="sidebar-heading">
        Data Barang
    </div>

    <li class="nav-item {{ request()->is('room*') ? 'active' : '' }}">
        <a class="nav-link" href="/room">
            <i class="fas fa-fw fa-door-open"></i>
            <span>Data Ruangan</span>
        </a>
    </li>

    <!-- Nav Item - Data Inventori Ruangan (Collapsible Menu) -->
    <li class="nav-item {{ request()->is('inventaris*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseInventaris"
            aria-expanded="true" aria-controls="collapseInventaris">
            <i class="fas fa-fw fa-boxes"></i>
            <span>Data Inventori Ruangan</span>
        </a>
        
        <div id="collapseInventaris" class="collapse {{ request()->is('inventaris*') ? 'show' : '' }}" aria-labelledby="headingInventaris" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Pilih Ruangan:</h6>
                
                @forelse ($ruangansForSidebar as $ruangan)
                    {{-- 
                        PERUBAHAN UTAMA DI SINI:
                        - href sekarang menggunakan route('inventaris.index') dengan parameter 'room_id'.
                        - Pengecekan 'active' sekarang membandingkan request('room_id') dengan $ruangan->id.
                    --}}
                    <a class="collapse-item {{ request('room_id') == $ruangan->id ? 'active' : '' }}" 
                       href="{{ route('inventaris.index', ['room_id' => $ruangan->id]) }}">
                        {{ $ruangan->name }}
                    </a>
                @empty
                    <a class="collapse-item" href="{{ route('room.create') }}">Tambah Ruangan Dulu</a>
                @endforelse
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Data Akun & Laporan
    </div>

    <li class="nav-item {{ request()->is('user*') ? 'active' : '' }}">
        <a class="nav-link" href="/user">
            <i class="fas fa-regular fa-user"></i>
            <span>Account</span>
        </a>
    </li>
    <li class="nav-item {{ request()->is('report*') ? 'active' : '' }}">
        <a class="nav-link" href="/report">
            <i class="fas fa-regular fa-print"></i>
            <span>Laporan Keseluruhan</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
