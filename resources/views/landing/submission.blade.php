@extends('layouts.landing')

@section('content')
<div class="container py-5 mt-5">
    <h1 class="section-title mb-5" style="margin-top: 20px;">Alur Pengajuan Surat</h1>

    <div class="row g-4">
        <!-- Informasi Umum -->
        <div class="col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <i class="fas fa-file-alt fa-3x text-primary"></i>
                    </div>
                    <h4 class="text-center mb-4">Informasi Pengajuan</h4>
                    <p class="text-muted text-center">Layanan pengajuan surat tersedia untuk membantu masyarakat dalam mengajukan berbagai jenis surat keterangan yang diperlukan.</p>
                </div>
            </div>
        </div>

        <!-- Langkah-langkah -->
        <div class="col-lg-8">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <i class="fas fa-tasks fa-3x text-primary"></i>
                    </div>
                    <h4 class="text-center mb-4">Langkah Pengajuan</h4>
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-number">1</div>
                            <div class="timeline-content">
                                <h6>Persiapkan Dokumen</h6>
                                <p class="text-muted small">Siapkan dokumen-dokumen yang diperlukan sesuai jenis surat</p>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-number">2</div>
                            <div class="timeline-content">
                                <h6>Login ke Sistem</h6>
                                <p class="text-muted small">Masuk ke akun Anda atau daftar jika belum memiliki akun</p>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-number">3</div>
                            <div class="timeline-content">
                                <h6>Pilih Jenis Surat</h6>
                                <p class="text-muted small">Pilih jenis surat yang sesuai dengan kebutuhan Anda</p>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-number">4</div>
                            <div class="timeline-content">
                                <h6>Isi Formulir</h6>
                                <p class="text-muted small">Lengkapi data dan upload dokumen pendukung</p>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-number">5</div>
                            <div class="timeline-content">
                                <h6>Tunggu Persetujuan</h6>
                                <p class="text-muted small">Pantau status pengajuan melalui dashboard</p>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-number">6</div>
                            <div class="timeline-content">
                                <h6>Ambil Surat</h6>
                                <p class="text-muted small">Ambil surat di kantor desa/kelurahan setelah disetujui</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-5">
        <a href="{{ route('login') }}" class="btn btn-primary btn-lg">Mulai Pengajuan</a>
    </div>
</div>

<style>
    .timeline {
        position: relative;
        padding-left: 30px;
    }
    .timeline-item {
        position: relative;
        padding-bottom: 1.5rem;
    }
    .timeline-number {
        position: absolute;
        left: -30px;
        top: 0;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: #fff;
        border: 2px solid #4e73df;
        color: #4e73df;
        font-weight: bold;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.875rem;
    }
    .timeline-item:after {
        content: '';
        position: absolute;
        left: -19px;
        top: 24px;
        width: 2px;
        height: calc(100% - 24px);
        background: #e3e6f0;
    }
    .timeline-item:last-child:after {
        display: none;
    }
    
</style>
@endsection 