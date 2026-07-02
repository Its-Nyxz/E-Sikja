@php
    $settingsPath = public_path('setting/settings.json');
    $setting = json_decode(file_get_contents($settingsPath), true) ?? [];
    $profile = $setting['profile'] ?? [];
@endphp


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Beranda' ?> - {{ $setting['website_description'] }}</title>
    <link rel="icon" href="{{ asset('setting/' . $setting['favicon']) }}" type="image/x-icon') }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/landing.css') }}">

    <style>

    </style>
</head>

<body>
    <!-- Add Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Playfair+Display:wght@700&display=swap"
        rel="stylesheet">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('/') }}">
                <img src="{{ asset('setting/' . $setting['logo']) }}" width="50" height="50" alt="Logo Website">
                <span>{{ $setting['website_name'] }}</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('/') ? 'active' : '' }}"
                            href="{{ route('/') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('profil*') ? 'active' : '' }}"
                            href="{{ route('profil.index') }}">Profil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pengajuan*') ? 'active' : '' }}"
                            href="{{ route('pengajuan.index') }}">Pengajuan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pengaduan*') ? 'active' : '' }}"
                            href="{{ route('pengaduan.index') }}">Pengaduan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('informasi*') ? 'active' : '' }}"
                            href="{{ route('informasi.index') }}">Informasi</a>
                    </li>
                    <li class="nav-item ms-2">
                        <a class="btn btn-login text-white" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-3 mb-md-0">
                    <h5>{{ $setting['website_name'] }}</h5>
                    <p>{{ $setting['website_description'] }}</p>
                    <p><i class="fas fa-map-marker-alt me-2"></i>{{ $profile['alamat_instansi'] }}</p>
                    <p><i class="fas fa-clock me-2"></i>Senin - Jumat: 08:00 - 16:00</p>
                </div>
                <div class="col-lg-4 col-md-6 mb-3 mb-md-0">
                    <h5>Kontak</h5>
                    <p><i class="fas fa-phone me-2"></i>{{ $setting['telepon'] ?? '(021)  12345678' }}</p>
                    <p><i class="fas fa-envelope me-2"></i>{{ $setting['email'] }}</p>
                </div>
                <div class="col-lg-4 col-md-12">
                    <h5>Ikuti Kami</h5>
                    <div class="social-links mb-2">
                        <a href="{{ $setting['facebook'] ?? '#' }}" class="text-dark"><i
                                class="fab fa-facebook-f"></i></a>
                        <a href="{{ $setting['instagram'] ?? '#' }}" class="text-dark"><i
                                class="fab fa-instagram"></i></a>
                        <a href="{{ $setting['youtube'] ?? '#' }}" class="text-dark"><i class="fab fa-youtube"></i></a>
                        <a href="{{ $setting['twitter'] ?? '#' }}" class="text-dark"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p class="mb-0">&copy; {{ date('Y') }} {{ $profile['nama_instansi'] }}. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Image Preview Modal -->
    <div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-labelledby="imagePreviewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-transparent border-0">
                <div class="modal-header border-0 p-0 position-absolute end-0 top-0" style="z-index: 10;">
                    <button type="button" class="btn-close btn-close-white m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0 text-center position-relative">
                    <img src="" id="modalPreviewImage" class="img-fluid rounded shadow-lg" style="max-height: 85vh; width: auto; object-fit: contain;">
                    <div class="mt-2">
                        <span id="modalPreviewTitle" class="text-white p-2 bg-dark bg-opacity-75 rounded d-inline-block"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const imagePreviewModal = document.getElementById('imagePreviewModal');
            if (imagePreviewModal) {
                imagePreviewModal.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget;
                    const src = button.getAttribute('data-preview-src');
                    const title = button.getAttribute('data-preview-title');
                    
                    const modalImg = imagePreviewModal.querySelector('#modalPreviewImage');
                    const modalTitle = imagePreviewModal.querySelector('#modalPreviewTitle');
                    
                    modalImg.src = src;
                    if (title) {
                        modalTitle.textContent = title;
                        modalTitle.parentElement.classList.remove('d-none');
                    } else {
                        modalTitle.textContent = '';
                        modalTitle.parentElement.classList.add('d-none');
                    }
                });
            }
        });
    </script>
</body>

</html>
