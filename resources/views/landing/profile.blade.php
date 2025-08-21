@extends('layouts.landing')

@section('content')
<div class="container py-5 mt-5">
    <h1 class="section-title mb-5">Profil {{ $profile['nama_instansi'] }}</h1>

    <div class="row g-4">
        <!-- Informasi Instansi -->
        <div class="col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <i class="fas fa-building fa-3x text-primary"></i>
                    </div>
                    <h4 class="text-center mb-4">Informasi Instansi</h4>
                    <div class="info-list">
                        <div class="info-item mb-3">
                            <h6 class="text-primary"><i class="fas fa-home me-2"></i>Nama Instansi</h6>
                            <p class="text-muted">{{ $profile['nama_instansi'] }}</p>
                        </div>
                        <div class="info-item mb-3">
                            <h6 class="text-primary"><i class="fas fa-map-marker-alt me-2"></i>Alamat</h6>
                            <p class="text-muted">{{ $profile['alamat_instansi'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Visi & Misi -->
        <div class="col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <i class="fas fa-bullseye fa-3x text-primary"></i>
                    </div>
                    <h4 class="text-center mb-4">Visi & Misi</h4>
                    <div class="vision-mission">
                        {!! $profile['visi_misi'] !!}
                    </div>
                </div>
            </div>
        </div>

        <!-- Tentang Kelurahan -->
        <div class="col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <i class="fas fa-info-circle fa-3x text-primary"></i>
                    </div>
                    <h4 class="text-center mb-4">Tentang Kelurahan</h4>
                    <div class="about-village">
                        {!! $profile['tentang_kelurahan'] !!}
                    </div>
                </div>
            </div>
        </div>

        <!-- Struktur Organisasi -->
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <i class="fas fa-sitemap fa-3x text-primary"></i>
                    </div>
                    <h4 class="text-center mb-4">Struktur Organisasi</h4>
                    <div class="org-structure">
                        {!! $profile['struktur_organisasi'] !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    transition: transform 0.3s ease;
    border: none;
    border-radius: 15px;
}

.card:hover {
    transform: translateY(-5px);
}

.info-list {
    padding: 10px;
}

.info-item {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
}

.info-item h6 {
    margin-bottom: 8px;
}

.vision-mission, .about-village {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    line-height: 1.6;
}

.vision-mission p, .about-village p {
    margin-bottom: 10px;
    color: #6c757d;
}

.org-structure {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
}

.org-structure table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

.org-structure table td {
    padding: 12px;
    border: 1px solid #dee2e6;
}

.org-structure table tr:first-child td {
    background-color: #e9ecef;
    font-weight: 600;
    color: #2c3e50;
}

.org-structure table tr:hover td {
    background-color: #f8f9fa;
}

.section-title {
    color: #2c3e50;
    font-weight: 600;
    position: relative;
    padding-bottom: 15px;
    margin-top: 20px;
}



@media (max-width: 768px) {
    .card {
        margin-bottom: 20px;
    }
    
    .section-title {
        font-size: 1.75rem;
    }
}
</style>
@endsection