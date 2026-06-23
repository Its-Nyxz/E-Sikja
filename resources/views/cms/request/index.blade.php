@extends('layouts.cms')

@section('content')
<style>
    .filter-card {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 14px 16px;
        margin-bottom: 16px;
    }
    .filter-card .form-label {
        font-size: 0.8rem;
        font-weight: 600;
        color: #495057;
        margin-bottom: 4px;
    }
    .filter-card .form-control,
    .filter-card .form-select {
        font-size: 0.85rem;
        height: 34px;
        padding: 4px 10px;
    }
    .btn-filter { font-size: 0.83rem; }
    .nav-tabs .nav-link { color: #495057; }
    .nav-tabs .nav-link.active { font-weight: bold; }
    .nav-tabs .nav-link[data-bs-target="#semua"]  { border-color: #6c757d; }
    .nav-tabs .nav-link[data-bs-target="#semua"].active  { background-color: #6c757d; color: white; }
    .nav-tabs .nav-link[data-bs-target="#diajukan"]  { border-color: #ffc107; }
    .nav-tabs .nav-link[data-bs-target="#diajukan"].active  { background-color: #ffc107; color: white; }
    .nav-tabs .nav-link[data-bs-target="#diproses"]  { border-color: #0d6efd; }
    .nav-tabs .nav-link[data-bs-target="#diproses"].active  { background-color: #0d6efd; color: white; }
    .nav-tabs .nav-link[data-bs-target="#selesai"]   { border-color: #198754; }
    .nav-tabs .nav-link[data-bs-target="#selesai"].active   { background-color: #198754; color: white; }
    .nav-tabs .nav-link[data-bs-target="#ditolak"]   { border-color: #dc3545; }
    .nav-tabs .nav-link[data-bs-target="#ditolak"].active   { background-color: #dc3545; color: white; }
    .badge-indicator {
        display: inline-block;
        width: 8px; height: 8px;
        border-radius: 50%;
        margin-right: 4px;
    }
</style>

{{-- ===== TOAST NOTIFIKASI ===== --}}
<div class="position-fixed top-0 end-0 p-3" style="z-index: 9999">
    <div id="export-toast" class="toast align-items-center text-white border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body" id="export-toast-msg"></div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Data Pengajuan</h3>
                    <button id="btn-export" class="btn btn-sm btn-success">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </button>
                </div>
                <div class="card-body">
                    
                    {{-- ===== FILTER PANEL ===== --}}
                    <div class="filter-card">
                        <div class="row g-2 align-items-end">
                            <div class="col-12 col-md-3">
                                <label class="form-label"><i class="fas fa-calendar-alt me-1"></i>Tanggal Dari</label>
                                <input type="date" id="filter-date-from" class="form-control" placeholder="Dari tanggal">
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label"><i class="fas fa-calendar-alt me-1"></i>Tanggal Sampai</label>
                                <input type="date" id="filter-date-to" class="form-control" placeholder="Sampai tanggal">
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label"><i class="fas fa-list me-1"></i>Jenis Pengajuan</label>
                                <select id="filter-request-type" class="form-select">
                                    <option value="">-- Semua Jenis --</option>
                                    @foreach($requestTypes as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-2 d-flex gap-2">
                                <button id="btn-filter" class="btn btn-primary btn-filter flex-fill">
                                    <i class="fas fa-search me-1"></i>Filter
                                </button>
                                <button id="btn-reset" class="btn btn-secondary btn-filter">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- ===== TAB NAVIGATION ===== --}}
                    <ul class="nav nav-tabs" id="requestTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="semua-tab" data-bs-toggle="tab" data-bs-target="#semua" type="button" role="tab" aria-controls="semua" aria-selected="true">
                                Semua
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="diajukan-tab" data-bs-toggle="tab" data-bs-target="#diajukan" type="button" role="tab" aria-controls="diajukan" aria-selected="false">
                                <span class="badge-indicator" style="background:#ffc107;"></span>Diajukan
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="diproses-tab" data-bs-toggle="tab" data-bs-target="#diproses" type="button" role="tab" aria-controls="diproses" aria-selected="false">
                                <span class="badge-indicator" style="background:#0d6efd;"></span>Diproses
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="selesai-tab" data-bs-toggle="tab" data-bs-target="#selesai" type="button" role="tab" aria-controls="selesai" aria-selected="false">
                                <span class="badge-indicator" style="background:#198754;"></span>Selesai
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="ditolak-tab" data-bs-toggle="tab" data-bs-target="#ditolak" type="button" role="tab" aria-controls="ditolak" aria-selected="false">
                                <span class="badge-indicator" style="background:#dc3545;"></span>Ditolak
                            </button>
                        </li>
                    </ul>

                    {{-- ===== TAB CONTENT ===== --}}
                    <div class="tab-content mt-3" id="requestTabsContent">

                        @foreach(['semua','diajukan','diproses','selesai','ditolak'] as $tabStatus)
                        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ $tabStatus }}" role="tabpanel" aria-labelledby="{{ $tabStatus }}-tab">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" width="100%" id="table-{{ $tabStatus }}">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No. Request</th>
                                            <th>No. Dokumen</th>
                                            <th>Tgl. Pengajuan</th>
                                            <th>Jenis Pengajuan</th>
                                            <th>Pemohon</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        @endforeach

                    </div>{{-- /tab-content --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {

    // ---- Filter state (shared across all tabs) ----
    let filterDateFrom = '';
    let filterDateTo   = '';
    let filterTypeId   = '';
    let activeStatus   = 'semua';

    // ---- DataTable instances cache ----
    const dataTables = {};

    // ---- Build DataTable for a given status ----
    function initDataTable(status) {
        if (dataTables[status]) return dataTables[status];

        const table = $(`#table-${status}`).DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('data-pengajuan.index') }}",
                data: function (d) {
                    d.status          = status;
                    d.date_from       = filterDateFrom;
                    d.date_to         = filterDateTo;
                    d.request_type_id = filterTypeId;
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'code',           name: 'code' },
                { data: 'document_number',name: 'document_number' },
                { data: 'created_at',     name: 'created_at' },
                { data: 'request_type',   name: 'request_type' },
                { data: 'user.name',      name: 'user.name' },
                {
                    data: 'status', name: 'status',
                    render: function (data) {
                        const map = {
                            'Diajukan': '<span class="badge bg-warning text-dark">Diajukan</span>',
                            'Diproses': '<span class="badge bg-primary">Diproses</span>',
                            'Selesai' : '<span class="badge bg-success">Selesai</span>',
                            'Ditolak' : '<span class="badge bg-danger">Ditolak</span>',
                        };
                        return map[data] ?? data;
                    }
                },
                { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
            ],
            order: [[3, 'asc']],
            language: { url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json" }
        });

        dataTables[status] = table;
        return table;
    }

    // ---- Reload active DataTable with current filters ----
    function reloadActive() {
        if (dataTables[activeStatus]) {
            dataTables[activeStatus].ajax.reload();
        } else {
            initDataTable(activeStatus);
        }
    }

    // ---- Init default tab ----
    initDataTable('semua');

    // ---- Switch tab: lazy-init & track active ----
    $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
        activeStatus = $(e.target).attr('data-bs-target').replace('#', '');
        initDataTable(activeStatus);
    });

    // ---- Filter button ----
    $('#btn-filter').on('click', function () {
        filterDateFrom = $('#filter-date-from').val();
        filterDateTo   = $('#filter-date-to').val();
        filterTypeId   = $('#filter-request-type').val();
        reloadActive();
    });

    // ---- Reset button ----
    $('#btn-reset').on('click', function () {
        $('#filter-date-from').val('');
        $('#filter-date-to').val('');
        $('#filter-request-type').val('');
        filterDateFrom = '';
        filterDateTo   = '';
        filterTypeId   = '';
        reloadActive();
    });

    // ---- Fungsi tampilkan toast ----
    function showToast(message, type = 'danger') {
        const toastEl = document.getElementById('export-toast');
        const msgEl   = document.getElementById('export-toast-msg');
        toastEl.className = 'toast align-items-center text-white border-0 bg-' + type;
        msgEl.textContent = message;
        const toast = new bootstrap.Toast(toastEl, { delay: 4000 });
        toast.show();
    }

    // ---- Export button ----
    $('#btn-export').on('click', function () {
        const btn = $(this);
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Mengexport...');

        let url = "{{ route('data-pengajuan.export') }}?";
        url += "status=" + activeStatus;
        url += "&date_from=" + filterDateFrom;
        url += "&date_to=" + filterDateTo;
        url += "&request_type_id=" + filterTypeId;

        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(function (response) {
                const contentType = response.headers.get('content-type') || '';
                if (!response.ok || contentType.includes('application/json')) {
                    // Server return JSON error
                    return response.json().then(function (data) {
                        throw new Error(data.message || 'Export gagal, silakan coba lagi.');
                    });
                }
                return response.blob();
            })
            .then(function (blob) {
                // Trigger download
                const a = document.createElement('a');
                const objectUrl = URL.createObjectURL(blob);
                a.href = objectUrl;
                a.download = 'Data_Pengajuan_' + Date.now() + '.xlsx';
                document.body.appendChild(a);
                a.click();
                a.remove();
                URL.revokeObjectURL(objectUrl);
                showToast('Export berhasil! File sedang diunduh.', 'success');
            })
            .catch(function (err) {
                showToast(err.message, 'danger');
            })
            .finally(function () {
                btn.prop('disabled', false).html('<i class="fas fa-file-excel"></i> Export Excel');
            });
    });

    // ---- Allow pressing Enter on date inputs ----
    $('#filter-date-from, #filter-date-to').on('keydown', function (e) {
        if (e.key === 'Enter') $('#btn-filter').trigger('click');
    });
});
</script>
@endpush
