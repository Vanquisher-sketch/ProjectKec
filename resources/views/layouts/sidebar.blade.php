@php
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
@endphp
 <ul class="navbar-nav bg-gradient-info sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i href="public/img/tasikmalaya.jpg"></i>
                </div>
                <div class="sidebar-brand-text mx-3">SIMDAWANI</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <!-- <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="/dashboard">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li> --}}

            <!-- Divider -->
            <!-- <hr class="sidebar-divider"> --}}

            <!-- Heading -->
            <!-- div class="sidebar-heading">
                Manajemen Data
            </div> --}}

            <!-- Nav Item - Tables -->
             @foreach ($menus[auth()->user()->role_id] as $menu)
    <li class="nav-item {{ request()->is($menu->path . '*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url($menu->path) }}">
            <i class="{{ $menu->icon }}"></i>
            <span>{{ $menu->title }}</span>
        </a>
    </li>
@endforeach
            
            <!-- Nav Item - Tables -->
            <li class="nav-item {{ request()->is('year') ? 'active' : '' }}">
                <a class="nav-link" href="/year">
                    <i class="fas fa-regular fa-calendar-check"></i>
                    <span>Data Tahun Kelahiran</span></a>
            </li>
            <li class="nav-item {{ request()->is('education') ? 'active' : '' }}">
                <a class="nav-link" href="/education">
                    <i class="fas fa-regular fa-school"></i>
                    <span>Data Status Pendidikan</span></a>
            </li>
            <li class="nav-item {{ request()->is('occupation') ? 'active' : '' }}">
                <a class="nav-link" href="/occupation">
                    <i class="fas fa-regular fa-city"></i>
                    <span>Data Status Pekerjaan</span></a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Heading -->
            <div class="sidebar-heading">
                Kondisi Lingkungan
            </div> 

            

            <li class="nav-item {{ request()->is('infrastruktur') ? 'active' : '' }}">
                <a class="nav-link" href="/infrastruktur">
                    <i class="fas fa-fw fa-landmark"></i>
                    <span>Data Infrastrukur</span></a>
            </li>

                        <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Heading -->
            <div class="sidebar-heading">
                Data Barang
            </div> 
            <li class="nav-item {{ request()->is('inventaris') ? 'active' : '' }}">
                <a class="nav-link" href="/inventaris">
                    <i class="fas fa-fw fa-landmark"></i>
                    <span>Data Inventori Ruangan</span></a>
            </li>
            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul> 