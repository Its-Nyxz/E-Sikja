@extends('layouts.landing')

@section('content')
<div class="container py-5 mt-5">
    <h1 class="section-title mb-5" style="margin-top: 20px;">Pengaduan</h1>

    <div class="row g-4">
        <!-- Informasi Umum -->
        <div class="col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <i class="fas fa-info-circle fa-3x text-primary"></i>
                    </div>
                    <h4 class="text-center mb-4">Informasi Pengaduan</h4>
                    <p class="text-muted text-center">Layanan pengaduan tersedia untuk membantu masyarakat menyampaikan keluhan, saran, dan masukan terkait layanan desa/kelurahan.</p>
                </div>
            </div>
        </div>

        <!-- Langkah-langkah -->
        <div class="col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <i class="fas fa-tasks fa-3x text-primary"></i>
                    </div>
                    <h4 class="text-center mb-4">Langkah Pengaduan</h4>
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-number">1</div>
                            <div class="timeline-content">
                                <h6>Login ke Akun</h6>
                                <p class="text-muted small">Masuk ke akun Anda terlebih dahulu</p>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-number">2</div>
                            <div class="timeline-content">
                                <h6>Akses Dashboard</h6>
                                <p class="text-muted small">Buka menu pengaduan di dashboard</p>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-number">3</div>
                            <div class="timeline-content">
                                <h6>Isi Formulir</h6>
                                <p class="text-muted small">Lengkapi data pengaduan dengan jelas</p>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-number">4</div>
                            <div class="timeline-content">
                                <h6>Tunggu Respon</h6>
                                <p class="text-muted small">Tim akan menghubungi Anda</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kontak & Waktu -->
        <div class="col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <i class="fas fa-clock fa-3x text-primary"></i>
                    </div>
                    <h4 class="text-center mb-4">Waktu & Kontak</h4>
                    
                    <div class="mb-4">
                        <h6 class="text-primary"><i class="fas fa-clock me-2"></i>Waktu Proses</h6>
                        <p class="text-muted small">Pengaduan akan diproses dalam waktu 1-3 hari kerja</p>
                    </div>

                    <div class="mb-4">
                        <h6 class="text-primary"><i class="fas fa-phone me-2"></i>Kontak Darurat</h6>
                        <ul class="list-unstyled text-muted small">
                            <li class="mb-2"><i class="fas fa-phone-alt me-2"></i>{{ $setting['telepon'] ?? ($setting['whatsapp'] ?? '0213913') }}</li>
                            <li><i class="fas fa-envelope me-2"></i>{{ $setting['email'] }}</li>
                        </ul>
                    </div>

                    <div class="text-center mt-4">
                        <a href="{{ route('login') }}" class="btn btn-primary btn-lg w-100">
                            <i class="fas fa-sign-in-alt me-2"></i>Login untuk Pengaduan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding: 20px 0;
}

.timeline-item {
    position: relative;
    padding-left: 45px;
    margin-bottom: 20px;
}

.timeline-number {
    position: absolute;
    left: 0;
    top: 0;
    width: 30px;
    height: 30px;
    background: #4a90e2;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
}

.timeline-content {
    padding: 10px;
    background: #f8f9fa;
    border-radius: 8px;
}

.timeline-content h6 {
    margin-bottom: 5px;
    color: #2c3e50;
}

.timeline-item:not(:last-child):after {
    content: '';
    position: absolute;
    left: 15px;
    top: 30px;
    bottom: -20px;
    width: 2px;
    background: #e9ecef;
}

.card {
    transition: transform 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
}
</style>
@endsection 