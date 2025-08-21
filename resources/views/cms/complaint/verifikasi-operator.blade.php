@extends('layouts.cms')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title"></h3>
                    <a href="{{ route('data-pengaduan.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    @if($complaint)
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card shadow-sm mb-4">
                                    <div class="card-body">
                                        <h5 class="card-title border-bottom pb-2 mb-4">Informasi Pengaduan</h5>
                                        <div class="row mb-3">
                                            <div class="col-md-5 fw-bold">Kode Pengaduan</div>
                                            <div class="col-md-7">{{ $complaint->code }}</div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-5 fw-bold">Judul</div>
                                            <div class="col-md-7">{{ $complaint->title }}</div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-5 fw-bold">Status</div>
                                            <div class="col-md-7">
                                                <span class="badge bg-{{ $complaint->status == 'Diajukan' ? 'warning' : ($complaint->status == 'Diproses' ? 'info' : ($complaint->status == 'Selesai' ? 'success' : 'danger')) }}">
                                                    {{ $complaint->status }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-5 fw-bold">Tanggal Pengaduan</div>
                                            <div class="col-md-7">{{ $complaint->date->format('d-m-Y H:i') }}</div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-5 fw-bold">Lokasi</div>
                                            <div class="col-md-7">{{ $complaint->location }}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card shadow-sm mb-4">
                                    <div class="card-body">
                                        <h5 class="card-title border-bottom pb-2 mb-4">Data Pelapor</h5>
                                        <div class="row mb-3">
                                            <div class="col-md-5 fw-bold">Nama</div>
                                            <div class="col-md-7">{{ $complaint->user->name }}</div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-5 fw-bold">NIK</div>
                                            <div class="col-md-7">{{ $complaint->user->resident->nik }}</div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-5 fw-bold">Alamat</div>
                                            <div class="col-md-7">{{ $complaint->user->resident->address }}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card shadow-sm mb-4">
                                    <div class="card-body">
                                        <h5 class="card-title border-bottom pb-2 mb-4">Deskripsi Pengaduan</h5>
                                        <div class="p-3 bg-light rounded">
                                            {{ $complaint->description }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card shadow-sm mb-4">
                                    <div class="card-body">
                                        <h5 class="card-title border-bottom pb-2 mb-4">Bukti Pengaduan</h5>
                                        @if($complaint->image)
                                            <div class="text-center">
                                                <img src="{{ asset( $complaint->image) }}" alt="Bukti Pengaduan" class="img-fluid rounded" style="max-height: 300px;">
                                            </div>
                                        @else
                                            <div class="alert alert-info">
                                                Tidak ada bukti pengaduan
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="card shadow-sm mb-4">
                                    <div class="card-body">
                                        <h5 class="card-title border-bottom pb-2 mb-4">Riwayat Status</h5>
                                        <div class="timeline">
                                            @foreach(json_decode($complaint->histories) as $history)
                                                <div class="timeline-item mb-4">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <span class="badge bg-{{ $history->status == 'Diajukan' ? 'warning' : ($history->status == 'Diproses' ? 'info' : ($history->status == 'Selesai' ? 'success' : 'danger')) }} me-2">
                                                            {{ $history->status }}
                                                        </span>
                                                        <small class="text-muted">{{ \Carbon\Carbon::parse($history->date)->format('d-m-Y H:i') }}</small>
                                                    </div>
                                                    @if($history->note)
                                                        <div class="bg-light p-2 rounded">
                                                            <small class="text-muted">{{ $history->note }}</small>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                @if($complaint->status == 'Diajukan')
                                <div class="card shadow-sm mb-4">
                                    <div class="card-body">
                                        <h5 class="card-title border-bottom pb-2 mb-4">Verifikasi Pengaduan</h5>
                                        <form action="{{ route('data-pengaduan.verifikasi-process', $complaint->id) }}" method="POST">
                                            @csrf
                                            <div class="form-group mb-3">
                                                <label for="status" class="form-label">Status</label>
                                                <select name="status" id="status" class="form-select" required>
                                                    <option value="Diproses">Diproses</option>
                                                    <option value="Ditolak">Ditolak</option>
                                                </select>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="notes" class="form-label">Catatan</label>
                                                <textarea name="notes" id="notes" class="form-control" rows="3" placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                                            </div>
                                            <div class="form-group text-end">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-save me-1"></i> Simpan
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="alert alert-danger">
                            Data pengaduan tidak ditemukan
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
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#complaintsTable').DataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
            }
        });
    });
</script>
@endpush
