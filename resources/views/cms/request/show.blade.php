@extends('layouts.cms')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title"></h3>
                        <a href="{{ route('data-pengajuan.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                    <div class="card-body">
                        @if ($requestLetter)
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
                                                    <span
                                                        class="badge bg-{{ $requestLetter->status == 'Diajukan' ? 'warning' : ($requestLetter->status == 'Diproses' ? 'info' : ($requestLetter->status == 'Selesai' ? 'success' : 'danger')) }}">
                                                        {{ $requestLetter->status }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-5 fw-bold">Tanggal Pengajuan</div>
                                                <div class="col-md-7">
                                                    {{ date('d-m-Y H:i', strtotime($requestLetter->created_at)) }}</div>
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
                                                $exclude = ['request_type_id', 'village_head', 'village_head_position'];
                                            @endphp
                                            @foreach (json_decode($requestLetter->data) as $key => $value)
                                                @if (!in_array($key, $exclude))
                                                    @if (str_contains($key, 'date') || str_contains($key, 'dob'))
                                                        <div class="row mb-3">
                                                            <div class="col-md-5 fw-bold">{{ __('request-letter.' . $key) }}
                                                            </div>
                                                            <div class="col-md-7">{{ date('d-M-Y', strtotime($value)) }}
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="row mb-3">
                                                            <div class="col-md-5 fw-bold">
                                                                {{ __('request-letter.' . $key) }}</div>
                                                            <div class="col-md-7">{{ $value }}</div>
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
                                            @foreach ($requestLetter->documentRequestLetters as $index => $document)
                                                @php
                                                    $fileUrl = asset($document->url);
                                                    $extension = strtolower(
                                                        pathinfo(
                                                            parse_url($document->url, PHP_URL_PATH),
                                                            PATHINFO_EXTENSION,
                                                        ),
                                                    );
                                                @endphp

                                                <div
                                                    class="d-flex align-items-center justify-content-between mb-3 p-3 bg-light rounded">
                                                    <div>
                                                        <span class="badge bg-primary me-2">{{ $index + 1 }}</span>
                                                        <span class="fw-medium">{{ $document->name }}</span>
                                                    </div>

                                                    <button type="button" class="btn btn-sm btn-info btn-preview-document"
                                                        data-bs-toggle="modal" data-bs-target="#documentPreviewModal"
                                                        data-title="{{ $document->name }}" data-url="{{ $fileUrl }}"
                                                        data-extension="{{ $extension }}">
                                                        <i class="fas fa-eye"></i> Lihat
                                                    </button>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="modal fade" id="documentPreviewModal" tabindex="-1"
                                        aria-labelledby="documentPreviewModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-xl modal-dialog-centered">
                                            <div class="modal-content preview-modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="documentPreviewModalLabel">Preview Dokumen
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Tutup"></button>
                                                </div>

                                                <div class="modal-body">
                                                    <div id="previewImageWrapper" class="protected-preview-wrapper d-none"
                                                        data-watermark="{{ $requestLetter->code ?? 'DOKUMEN' }}"
                                                        oncontextmenu="return false;">

                                                        <img id="previewImage" src="" alt="Preview Dokumen"
                                                            class="protected-image" draggable="false">
                                                    </div>

                                                    <div id="previewPdfWrapper" class="d-none">
                                                        <iframe id="previewPdf" src="" class="preview-pdf"></iframe>
                                                    </div>

                                                    <div id="previewUnsupported" class="alert alert-warning d-none mb-0">
                                                        File ini tidak dapat dipreview langsung. Format file tidak didukung
                                                        untuk preview.
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <small class="text-muted me-auto">
                                                        Dokumen hanya untuk preview.
                                                    </small>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">
                                                        Tutup
                                                    </button>
                                                </div>
                                                <button type="button" class="btn btn-sm btn-info" onclick="openDocumentViewer('{{ route('dokumen.lihat', $document->id) }}', '{{ $document->name }}')">
                                                    <i class="fas fa-eye"></i> Lihat
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card shadow-sm mb-4">
                                        <div class="card-body">
                                            <h5 class="card-title border-bottom pb-2 mb-4">Riwayat Status</h5>
                                            <div class="complaint-timeline">
                                                @foreach ($requestLetter->historyRequestLetters as $history)
                                                    @php
                                                        $badgeClass = '';
                                                        $dotColor = '';
                                                        switch ($history->status) {
                                                            case 'Diajukan':
                                                                $badgeClass = 'warning text-dark';
                                                                $dotColor = '#ffc107';
                                                                break;
                                                            case 'Diproses':
                                                                $badgeClass = 'primary';
                                                                $dotColor = '#0d6efd';
                                                                break;
                                                            case 'Ditolak':
                                                                $badgeClass = 'danger';
                                                                $dotColor = '#dc3545';
                                                                break;
                                                            case 'Selesai':
                                                                $badgeClass = 'success';
                                                                $dotColor = '#198754';
                                                                break;
                                                        }
                                                    @endphp
                                                    <div class="timeline-item">
                                                        <div class="timeline-dot"
                                                            style="border-color: {{ $dotColor }}"></div>
                                                        <div class="timeline-content">
                                                            <div class="timeline-header">
                                                                <span
                                                                    class="badge bg-{{ $badgeClass }}">{{ $history->status }}</span>
                                                                <span class="timeline-date"><i
                                                                        class="far fa-clock me-1"></i>{{ date('d-m-Y H:i', strtotime($history->created_at)) }}</span>
                                                            </div>
                                                            @if ($history->notes)
                                                                <div class="timeline-note">{{ $history->notes }}</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach

                                                @if ($requestLetter->historyRequestLetters->isEmpty())
                                                    <p class="text-center text-muted my-3">Belum ada riwayat status</p>
                                                @endif
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
</div>

<style>
.complaint-timeline {
    position: relative;
    padding-left: 30px;
    margin-top: 10px;
}

.complaint-timeline::before {
    content: '';
    position: absolute;
    left: 7px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e9ecef;
}

.timeline-item {
    position: relative;
    padding-bottom: 20px;
}

.timeline-item:last-child {
    padding-bottom: 0;
}

.timeline-dot {
    position: absolute;
    left: -30px;
    top: 4px;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    background: #fff;
    border: 3px solid #0d6efd;
    z-index: 1;
}

.timeline-content {
    background: #f8f9fa;
    padding: 12px 15px;
    border-radius: 8px;
    border: 1px solid #edf2f7;
    box-shadow: 0 2px 4px rgba(0,0,0,0.02);
}

.timeline-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 8px;
}

.timeline-date {
    font-size: 0.75rem;
    color: #718096;
    font-weight: 500;
}

.timeline-note {
    font-size: 0.875rem;
    color: #4a5568;
    line-height: 1.5;
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

.form-control:focus, .form-select:focus {
    border-color: #4a90e2;
    box-shadow: 0 0 0 0.2rem rgba(74, 144, 226, 0.25);
}

.btn-primary {
    background: linear-gradient(135deg, #4a90e2 0%, #357abd 100%);
    border: none;
    padding: 0.5rem 1.5rem;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #357abd 0%, #2c6aa0 100%);
}
</style>

@include('components.document-viewer')
@endsection
