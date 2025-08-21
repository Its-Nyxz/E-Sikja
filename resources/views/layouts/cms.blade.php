@php
   $settingsPath = public_path('setting/settings.json');
  $setting = json_decode(file_get_contents($settingsPath), true)??[];
  $profile = $setting['profile']??[];

  $user = Auth::user();
  $unreadNotification = $user->notifications()->where('read', false)->count();
@endphp


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Dashboard' }} - {{ $setting['website_name'] }}</title>
     <link rel="icon" href="{{ asset('setting/' . $setting['favicon']) }}" type="image/x-icon') }}">
    <meta name="description" content="{{ $setting['website_description'] ?? 'Website Sistem Layanan Surat Menyurat Kelurahan' }}">


    <!-- jQuery -->
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/css/all.min.css') }}">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/css/dataTables.bootstrap5.min.css') }}">
    <!-- DataTables Responsive CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/css/responsive.bootstrap5.min.css') }}">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/sweetalert2/sweetalert2.min.css') }}">
    <!-- Popper.js -->
    <script src="{{ asset('assets/vendor/popper/popper.min.js') }}"></script>
    <!-- Bootstrap JS -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- Moment.js -->
    <script src="{{ asset('assets/vendor/moment/moment.min.js') }}"></script>
    <!-- DataTables JS -->
    <script src="{{ asset('assets/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables/js/dataTables.bootstrap5.min.js') }}"></script>
    <!-- DataTables Responsive JS -->
    <script src="{{ asset('assets/vendor/datatables/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables/js/responsive.bootstrap5.min.js') }}"></script>
    <!-- SweetAlert2 JS -->
    <script src="{{ asset('assets/vendor/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <!-- CKEditor -->
    <script src="{{ asset('assets/vendor/ckeditor/ckeditor.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/cms.css') }}">
</head>
<body>
    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="sidebar-header">
            <img src="{{ asset('setting/' . $setting['logo']) }}" width="50" height="50" alt="Logo">
            <h3>{{ $setting['website_name'] }}</h3>
            <small>
                {{ $user->name }}
                <br>
                @if($user->role === 'admin')
                    <span class="role-badge role-admin">Admin</span>
                @elseif($user->role === 'operator')
                    <span class="role-badge role-operator">Operator</span>
                @else
                    <span class="role-badge role-resident">Masyarakat</span>
                @endif
            </small>
            <button class="toggle-sidebar" id="toggleSidebar">
                <i class="fas fa-chevron-left"></i>
            </button>
        </div>
        
        <div class="sidebar-menu">
            <a href="{{ URL::to('dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
            </a>
            @if ($user?->role === 'masyarakat')
                <div class="menu-section">Menu Masyarakat </div>
                <a href="{{ route('pengajuan-saya.index') }}" class="{{ request()->is('pengajuan-saya*') ? 'active' : '' }}">
                    <i class="fas fa-envelope"></i> <span>Pengajuan Surat</span>
                </a>
                <a href="{{ route('pengaduan-saya.index') }}" class="{{ request()->is('pengaduan-saya*') ? 'active' : '' }}">
                    <i class="fas fa-bullhorn"></i> <span>Pengaduan</span>
                </a>
            @elseif ($user?->role === 'operator')
                <div class="menu-section">Menu Operator </div>
                <a href="{{ route('data-masyarakat.index') }}" class="{{ request()->is('data-masyarakat*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i> <span>Data Masyarakat</span>
                </a>

                <a href="{{ route('data-pengajuan.index') }}" class="{{ request()->is('data-pengajuan*') ? 'active' : '' }}">
                    <i class="fas fa-inbox"></i> <span>Data Pengajuan</span>
                </a>

                <a href="{{ route('data-pengaduan.index') }}" class="{{ request()->is('data-pengaduan*') ? 'active' : '' }}">
                    <i class="fas fa-bullhorn"></i> <span>Pengaduan Masyarakat</span>
                </a>

            @else
                <div class="menu-section">Menu Administrator </div>
                <a href="{{ route('profil-kelurahan.index') }}" class="{{ request()->is('profil-kelurahan*') ? 'active' : '' }}">
                    <i class="fas fa-clipboard-list"></i> <span>Profil Instansi</span>
                </a>
                
                <a href="{{ route('informasi-kelurahan.index') }}" class="{{ request()->is('informasi-kelurahan*') ? 'active' : '' }}">
                    <i class="fas fa-info"></i> <span>Informasi Kelurahan</span>
                </a>
                <a href="{{ route('data-masyarakat.index') }}" class="{{ request()->is('data-masyarakat*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i> <span>Data Masyarakat</span>
                </a>
                <a href="{{ route('jenis-permohonan.index') }}" class="{{ request()->is('jenis-permohonan*') ? 'active' : '' }}">
                    <i class="fas fa-list"></i> <span>Jenis Permohonan</span>
                </a>
                <a href="{{ route('data-pengajuan.index') }}" class="{{ request()->is('data-pengajuan*') ? 'active' : '' }}">
                    <i class="fas fa-inbox"></i> <span>Data Pengajuan</span>
                </a>

                <a href="{{ route('data-pengaduan.index') }}" class="{{ request()->is('data-pengaduan.index*') ? 'active' : '' }}">
                    <i class="fas fa-bullhorn"></i> <span>Pengaduan Masyarakat</span>
                </a>
                
                <a href="{{ route('manajemen-pengguna.index') }}" class="{{ request()->is('manajemen-pengguna*') ? 'active' : '' }}">
                    <i class="fas fa-user-tie"></i> <span>Manajemen Pengguna</span>
                </a>

                <a href="{{ route('settings.index') }}" class="{{ request()->is('settings') ? 'active' : '' }}">
                    <i class="fas fa-globe"></i> <span>Website</span>
                </a>

            @endif

        </div>

        <!-- Bottom Menu -->
        <div class="sidebar-bottom-menu">
            <a href="{{ route('profile.index') }}" class="{{ request()->is('profile') ? 'active' : '' }}" title="Profil Saya">
                <i class="fas fa-user-circle"></i>
            </a>
            <a href="{{ route('notifikasi.index') }}" class="{{ request()->is('notifikasi') ? 'active' : '' }} position-relative" title="Notifikasi">
                <i class="fas fa-bell"></i>
                @if($unreadNotification)
                    <span class="badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle">{{ $unreadNotification }}</span>
                @endif
            </a>
            <a href="{{ route('logout') }}" title="Logout">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </div>
    </nav>

    <!-- Content -->
    <div class="content">
        <nav class="navbar navbar-expand-lg navbar-light mb-4">
            <div class="container-fluid">
                <button id="sidebarToggle" class="btn btn-outline-secondary d-md-none">
                    <i class="fas fa-bars"></i>
                </button>
                <h4 class="mb-0 ms-2">{{ $title ?? 'Dashboard' }}</h4>
                <div class="ms-auto d-flex align-items-center">
                    <div class="dropdown">
                        <button class="btn btn-link nav-link dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle me-1"></i> {{ $user->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="{{ route('profile.index') }}"><i class="fas fa-user me-2"></i> Profil</a></li>
                            <li>
                                <a class="dropdown-item {{ request()->is('notifikasi') ? 'active' : '' }}" href="{{ route('notifikasi.index') }}">
                                    <i class="fas fa-bell me-2"></i> Notifikasi
                                    @if($unreadNotification)
                                        <span class="badge bg-danger rounded-pill ms-2">{{ $unreadNotification }}</span>
                                    @endif
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('logout') }}"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        
        <!-- Main Content -->
        @yield('content')
    </div>

    <script>
        // Initialize dropdowns
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize all dropdowns
            var dropdownTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="dropdown"]'));
            dropdownTriggerList.map(function(dropdownTriggerEl) {
                return new bootstrap.Dropdown(dropdownTriggerEl);
            });

            // Toggle sidebar for all screen sizes
            document.getElementById('toggleSidebar').addEventListener('click', function() {
                const sidebar = document.querySelector('.sidebar');
                const content = document.querySelector('.content');
                const toggleIcon = this.querySelector('i');
                
                sidebar.classList.toggle('collapsed');
                content.classList.toggle('expanded');
                
                // Change icon direction
                if (sidebar.classList.contains('collapsed')) {
                    toggleIcon.classList.remove('fa-chevron-left');
                    toggleIcon.classList.add('fa-chevron-right');
                } else {
                    toggleIcon.classList.remove('fa-chevron-right');
                    toggleIcon.classList.add('fa-chevron-left');
                }
            });
            
            // Mobile sidebar toggle
            document.getElementById('sidebarToggle').addEventListener('click', function() {
                const sidebar = document.querySelector('.sidebar');
                const content = document.querySelector('.content');
                
                sidebar.classList.toggle('active');
                content.classList.toggle('active');
            });
        });

        const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });
            
    </script>

    @if (session('success'))
        <script>
            Toast.fire({
                icon: 'success',
                title: '{{ session('success') }}'
            });
        </script>
    @endif
    @if (session('error'))
        <script>
            Toast.fire({
                icon: 'error',
                title: '{{ session('error') }}'
            });
        </script>
    @endif
    @stack('scripts')
</body>
</html>

