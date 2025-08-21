@extends('layouts.cms')

@section('content')
<div class="container d-flex align-items-center justify-content-center" style="min-height: calc(100vh - 200px);">
    <div class="row justify-content-center w-100">
        <div class="col-md-8 text-center">
            <div class="card shadow-sm">
                <div class="card-body p-5">
                    <h1 class="display-1 text-muted mb-4">404</h1>
                    <h2 class="h4 mb-4">Halaman Tidak Ditemukan</h2>
                    <p class="text-muted mb-4">Maaf, halaman yang Anda cari tidak ditemukan atau telah dipindahkan.</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('dashboard.index') }}" class="btn btn-primary">
                            <i class="fas fa-home me-2"></i>Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
