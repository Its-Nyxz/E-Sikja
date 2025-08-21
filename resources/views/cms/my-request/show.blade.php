@extends('layouts.cms')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title"></h3>
                    <div>
                        <a href="{{ route('pengajuan-saya.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        @if($requestLetter && $requestLetter->status == 'Diajukan')
                            <a href="{{ route('pengajuan-saya.edit', $requestLetter->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('pengajuan-saya.destroy', $requestLetter->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger me-2" onclick="return confirm('Apakah Anda yakin ingin menghapus pengajuan ini?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        @elseif ($requestLetter && $requestLetter->status == 'Selesai')
                            <a href="{{ route('pengajuan-saya.print', $requestLetter->id) }}" target="_blank" class="btn btn-sm btn-info">
                                <i class="fas fa-print"></i> Cetak
                            </a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    @if($requestLetter)
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card shadow-sm mb-4">
                                    <div class="card-body">
                                        <h5 class="card-title border-bottom pb-2 mb-4">Informasi Pengajuan</h5>
                                        <div class="row mb-3">
                                            <div class="col-md-5 fw-bold">Nomor Pengajuan</div>
                                            <div class="col-md-7">{{ $requestLetter->code }}</div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-5 fw-bold">Jenis Pengajuan</div>
                                            <div class="col-md-7">{{ $requestLetter->requestType->name }}</div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-5 fw-bold">Status</div>
                                            <div class="col-md-7">
                                                <span class="badge bg-{{ $requestLetter->status == 'Diajukan' ? 'warning' : ($requestLetter->status == 'Diproses' ? 'info' : ($requestLetter->status == 'Selesai' ? 'success' : 'danger')) }}">
                                                    {{ $requestLetter->status }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-5 fw-bold">Tanggal Pengajuan</div>
                                            <div class="col-md-7">{{ date('d-m-Y H:i', strtotime($requestLetter->created_at)) }}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card shadow-sm mb-4">
                                    <div class="card-body">
                                        <h5 class="card-title border-bottom pb-2 mb-4">Data Pemohon</h5>
                                        <div class="row mb-3">
                                            <div class="col-md-5 fw-bold">Nama</div>
                                            <div class="col-md-7">{{ $requestLetter->user->name }}</div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-5 fw-bold">NIK</div>
                                            <div class="col-md-7">{{ $requestLetter->user->resident->nik }}</div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-5 fw-bold">Alamat</div>
                                            <div class="col-md-7">{{ $requestLetter->user->resident->address }}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card shadow-sm mb-4">
                                    <div class="card-body">
                                        <h5 class="card-title border-bottom pb-2 mb-4">Data Pengajuan</h5>
                                        @php
                                            $exclude = ['request_type_id', 'village_head', 'village_head_position', 'id'];
                                        @endphp
                                        @foreach(json_decode($requestLetter->data) as $key => $value)
                                            @if(!in_array($key, $exclude))
                                                @if(str_contains($key, 'date') || str_contains($key, 'dob'))
                                                    <div class="row mb-3">
                                                        <div class="col-md-5 fw-bold">{{ __('request-letter.' . $key) }}</div>
                                                        <div class="col-md-7">{{ date('d-M-Y', strtotime($value)) }}</div>
                                                    </div>
                                                @else
                                                    <div class="row mb-3">
                                                        <div class="col-md-5 fw-bold">{{ __('request-letter.' . $key) }}</div>
                                                        <div class="col-md-7">{{ str_contains($key, 'income') ? number_format($value) : $value }}</div>
                                                    </div>
                                                @endif
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card shadow-sm mb-4">
                                    <div class="card-body">
                                        <h5 class="card-title border-bottom pb-2 mb-4">Dokumen Lampiran</h5>
                                        @foreach($requestLetter->documentRequestLetters as $index => $document)
                                            <div class="d-flex align-items-center justify-content-between mb-3 p-3 bg-light rounded">
                                                <div>
                                                    <span class="badge bg-primary me-2">{{ $index + 1 }}</span>
                                                    <span class="fw-medium">{{ $document->name }}</span>
                                                </div>
                                                <a href="{{ asset( $document->url) }}" target="_blank" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i> Lihat
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="card shadow-sm mb-4">
                                    <div class="card-body">
                                        <h5 class="card-title border-bottom pb-2 mb-4">Riwayat Status</h5>
                                        <div class="timeline">
                                            @foreach($requestLetter->historyRequestLetters as $history)
                                                <div class="timeline-item mb-4">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <span class="badge bg-{{ $history->status == 'Diajukan' ? 'warning' : ($history->status == 'Diproses' ? 'info' : ($history->status == 'Selesai' ? 'success' : 'danger')) }} me-2">
                                                            {{ $history->status }}
                                                        </span>
                                                        <small class="text-muted">{{ date('d-m-Y H:i', strtotime($history->created_at)) }}</small>
                                                    </div>
                                                    @if($history->notes)
                                                        <div class="bg-light p-2 rounded">
                                                            <small class="text-muted">{{ $history->notes }}</small>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-danger">
                            Data pengajuan tidak ditemukan
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 20px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e9ecef;
}

.timeline-item {
    position: relative;
}

.timeline-item::before {
    content: '';
    position: absolute;
    left: -24px;
    top: 0;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: #4a90e2;
    border: 2px solid #fff;
}

.card {
    border: none;
    border-radius: 10px;
}

.card-body {
    padding: 1.5rem;
}

.shadow-sm {
    box-shadow: 0 .125rem .25rem rgba(0,0,0,.075)!important;
}

.bg-light {
    background-color: #f8f9fa!important;
}

.rounded {
    border-radius: 0.5rem!important;
}
</style>
@endsection 