<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        {{-- <img src="/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8"> --}}
        {{-- <span class="brand-text font-weight-light">AdminLTE 3</span> --}}

        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="brand-image " width="30" style="">
        <span class="brand-text font-weight-light">
            {{ config('app.name') }}
        </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            {{-- Dropdown --}}
            <div class="image">
                <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">
                    {{ Auth::user()->name }}
                </a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-header">DASHBOARD</li>
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-header">CORE</li>
                <li class="nav-item">
                    <a href="{{ route('dashboard.companies.index') }}"
                        class="nav-link {{ request()->routeIs('dashboard.companies.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-building"></i>
                        <p>
                            Company
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dashboard.projects.index') }}"
                        class="nav-link {{ request()->routeIs('dashboard.projects.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-bullseye"></i>
                        <p>
                            Project
                        </p>
                    </a>
                </li>
                <li class="nav-header">DATA ASSETS</li>
                <li class="nav-item">
                    <a href="#"
                        class="nav-link {{ request()->is('users*') || request()->is('roles*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Master Data
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('dashboard.assets-status.index') }}"
                                class="nav-link {{ request()->routeIs('dashboard.assets-status.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Status Aset</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('dashboard.assets-class.index') }}"
                                class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kelas Aset</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('dashboard.unit-of-measurement.index') }}"
                                class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Satuan Unit Aset</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('dashboard.department.index') }}"
                                class="nav-link {{ request()->routeIs('dashboard.department.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Department</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('dashboard.person-in-charge.index') }}"
                                class="nav-link {{ request()->routeIs('dashboard.person-in-charge.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Person in Charge</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('dashboard.assets-users.index') }}"
                                class="nav-link {{ request()->routeIs('dashboard.assets-users.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pengguna</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('dashboard.categories.index') }}"
                                class="nav-link {{ request()->routeIs('dashboard.categories.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kategori</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('dashboard.locations.index') }}"
                                class="nav-link {{ request()->routeIs('dashboard.locations.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Lokasi</p>
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a href="{{ route('dashboard.users.index') }}"
                                class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data Pengguna</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('dashboard.roles.index') }}"
                                class="nav-link {{ request()->routeIs('roles.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data Role</p>
                            </a>
                        </li> --}}
                    </ul>
                </li>
                <li class="nav-header">SYSTEMS</li>
                <li class="nav-item">
                    <a href="#"
                        class="nav-link {{ request()->is('log*') || request()->is('log*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-history"></i>
                        <p>
                            Log
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('dashboard.log-activity') }}"
                                class="nav-link {{ request()->routeIs('log-activity') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Aktivitas</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('dashboard.log') }}"
                                class="nav-link {{ request()->routeIs('log') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sistem</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#"
                        class="nav-link {{ request()->is('settings*') || request()->is('settings*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            Pengaturan
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('dashboard.settings.index') }}"
                                class="nav-link {{ request()->routeIs('settings.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sistem</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item mt-3">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" id="form-logout-button" class="nav-link">
                            <i class="nav-icon fa fa-sign-out"></i>
                            <p>
                                Logout
                            </p>
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
