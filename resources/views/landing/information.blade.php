@extends('layouts.landing')

@section('content')
<div class="container py-5 mt-5">
    <h1 class="section-title mb-4" style="margin-top: 20px;">Informasi Kelurahan</h1>

    <!-- Search Form -->
    <div class="row mb-4">
        <div class="col-md-6 mx-auto">
            <form action="{{ route('informasi.index') }}" method="GET" class="d-flex gap-2">
                <input type="text" name="search" class="form-control" placeholder="Cari informasi..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
    </div>

    <div class="row d-flex justify-content-center">
        @forelse($informations as $information)
            <div class="col-md-4 mb-4">
                <div class="info-card h-100">
                    @if($information->image)
                        <img src="{{ asset($information->image) }}" alt="{{ $information->title }}" class="img-fluid rounded mb-2" style="max-height: 200px; width: 100%; object-fit: cover;">
                    @endif
                    <h4 class="mb-2">{{ Str::limit($information->title, 50) }}</h4>
                    <p class="text-muted small mb-2">
                        <i class="fas fa-calendar-alt me-1"></i>
                        {{ $information->created_at->format('d F Y') }}
                    </p>
                    <p class="mb-3">{!! Str::limit(strip_tags($information->description), 100) !!}</p>
                    <a href="{{ route('informasi.show', $information->slug) }}" class="btn btn-sm btn-primary">
                        Baca Selengkapnya
                    </a>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="info-card">
                    <p class="text-center text-muted">Belum ada informasi yang tersedia</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="row mt-4">
        <div class="col-12">
            <nav aria-label="Page navigation">
                {{ $informations->links('pagination::bootstrap-5') }}
            </nav>
        </div>
    </div>

</div>
@endsection
