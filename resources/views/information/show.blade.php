@extends('layouts.cms')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="card-title mb-0">
                        @if($information->status == 'active')
                            <i class="fas fa-circle text-success" style="font-size: 10px;"></i> Aktif
                        @else
                            <i class="fas fa-circle text-danger" style="font-size: 10px;"></i> Tidak Aktif
                        @endif
                    </h6>
                    <div>
                        <a href="{{ route('informasi-kelurahan.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <a href="{{ route('informasi.show', $information->slug) }}" target="_blank" class="btn btn-sm btn-primary">Preview</a>
                    </div>
                    
                </div>
                <div class="card-body">
                    <h2 class="card-title mb-4">{{ $information->title }}</h2>
                    @if($information->image)
                        <div class="text-center mb-4">
                            <img src="{{ asset($information->image) }}" class="img-fluid" alt="{{ $information->title }}" style="max-height: 400px;">
                        </div>
                    @endif
                    
                    <div>
                        {!! $information->description !!}
                    </div>
                    
                    <div class="mt-4">
                        <small class="text-muted">
                            Tanggal: {{ $information->created_at->format('d F Y') }}
                        </small>
                    </div>
                    
                    <div class="mt-1">
                        <small class="text-muted">
                            Diposting oleh: {{ $information->user->name }}
                        </small>
                    </div>
                    
                    <div class="mt-1 text-end">
                        <small class="text-muted">
                            <a href="{{ route('informasi.show', $information->slug) }}" target="_blank" class="btn btn-sm btn-primary">Preview</a>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 