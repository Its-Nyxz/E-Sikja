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
    .nav-tabs .nav-link[data-bs-target="#semua"]    { border-color: #6c757d; }
    .nav-tabs .nav-link[data-bs-target="#semua"].active    { background-color: #6c757d; color: white; }
    .nav-tabs .nav-link[data-bs-target="#diajukan"] { border-color: #ffc107; }
    .nav-tabs .nav-link[data-bs-target="#diajukan"].active { background-color: #ffc107; color: white; }
    .nav-tabs .nav-link[data-bs-target="#diproses"] { border-color: #0d6efd; }
    .nav-tabs .nav-link[data-bs-target="#diproses"].active { background-color: #0d6efd; color: white; }
    .nav-tabs .nav-link[data-bs-target="#selesai"]  { border-color: #198754; }
    .nav-tabs .nav-link[data-bs-target="#selesai"].active  { background-color: #198754; color: white; }
    .nav-tabs .nav-link[data-bs-target="#ditolak"]  { border-color: #dc3545; }
    .nav-tabs .nav-link[data-bs-target="#ditolak"].active  { background-color: #dc3545; color: white; }
    .badge-indicator {
        display: inline-block;
        width: 8px; height: 8px;
        border-radius: 50%;
        margin-right: 4px;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Data Pengaduan</h3>
                    <button id="btn-export" class="btn btn-sm btn-success">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </button>
                </div>
                <div class="card-body">

                    {{-- ===== FILTER PANEL ===== --}}
                    <div class="filter-card">
                        <div class="row g-2 align-items-end">
                            <div class="col-12 col-md-4">
                                <label class="form-label"><i class="fas fa-calendar-alt me-1"></i>Tanggal Dari</label>
                                <input type="date" id="filter-date-from" class="form-control">
                            </div>
                            <div class="col-12 col-md-4">
                                <label class="form-label"><i class="fas fa-calendar-alt me-1"></i>Tanggal Sampai</label>
                                <input type="date" id="filter-date-to" class="form-control">
                            </div>
                            <div class="col-12 col-md-4 d-flex gap-2">
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
                    <ul class="nav nav-tabs" id="complaintTabs" role="tablist">
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
                    <div class="tab-content mt-3" id="complaintTabsContent">

                        @foreach(['semua','diajukan','diproses','selesai','ditolak'] as $tabStatus)
                        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ $tabStatus }}" role="tabpanel" aria-labelledby="{{ $tabStatus }}-tab">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" width="100%" id="table-{{ $tabStatus }}">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Nomor</th>
                                            <th>Pelapor</th>
                                            <th>Judul</th>
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

<!-- Modal Detail -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Pengaduan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Left Column -->
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header bg-light">
                                <h6 class="card-title mb-0">Informasi Dasar</h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <th width="35%">Nomor</th>
                                        <td id="modal-code"></td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal</th>
                                        <td id="modal-date"></td>
                                    </tr>
                                    <tr>
                                        <th>Pelapor</th>
                                        <td id="modal-reporter"></td>
                                    </tr>
                                    <tr>
                                        <th>Judul</th>
                                        <td id="modal-title"></td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td id="modal-status"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="card mt-3">
                            <div class="card-header bg-light">
                                <h6 class="card-title mb-0">Foto Pendukung</h6>
                            </div>
                            <div class="card-body">
                                <div id="modal-image" class="text-center"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header bg-light">
                                <h6 class="card-title mb-0">Detail Pengaduan</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="font-weight-bold">Deskripsi</label>
                                    <div id="modal-description" class="border p-3 rounded bg-light"></div>
                                </div>
                                <div class="form-group mt-3">
                                    <label class="font-weight-bold">Lokasi</label>
                                    <div id="modal-location" class="border p-3 rounded bg-light"></div>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-3">
                            <div class="card-header bg-light">
                                <h6 class="card-title mb-0">Riwayat Status</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm">
                                        <thead class="bg-light">
                                            <tr>
                                                <th width="20%">Tanggal</th>
                                                <th width="15%">Status</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody id="modal-histories">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
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
                url: "{{ route('data-pengaduan.index') }}",
                data: function (d) {
                    d.status    = status;
                    d.date_from = filterDateFrom;
                    d.date_to   = filterDateTo;
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'created_at',  name: 'created_at' },
                { data: 'code',        name: 'code' },
                { data: 'user.name',   name: 'user.name' },
                { data: 'title',       name: 'title' },
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
            order: [[1, 'asc']],
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
        reloadActive();
    });

    // ---- Reset button ----
    $('#btn-reset').on('click', function () {
        $('#filter-date-from').val('');
        $('#filter-date-to').val('');
        filterDateFrom = '';
        filterDateTo   = '';
        reloadActive();
    });

    // ---- Export button ----
    $('#btn-export').on('click', function () {
        let url = "{{ route('data-pengaduan.export') }}?";
        url += "status=" + activeStatus;
        url += "&date_from=" + filterDateFrom;
        url += "&date_to=" + filterDateTo;

        window.location.href = url;
    });

    // ---- Allow pressing Enter on date inputs ----
    $('#filter-date-from, #filter-date-to').on('keydown', function (e) {
        if (e.key === 'Enter') $('#btn-filter').trigger('click');
    });

    // ---- Handle show detail (modal) ----
    $(document).on('click', '.btn-detail', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        
        $.get("{{ url('data-pengaduan') }}/show/" + id, function(response) {
            if (response.status === 'success') {
                var data = response.data.complaint;
                var histories = response.data.histories;
                
                // Fill modal with data
                $('#modal-code').text(data.code);
                $('#modal-date').text(moment(data.created_at).format('DD-MM-YYYY HH:mm'));
                $('#modal-reporter').text(data.user.name);
                $('#modal-title').text(data.title);
                
                // Set status with badge
                var badgeClass = '';
                switch (data.status) {
                    case 'Diajukan': badgeClass = 'warning'; break;
                    case 'Diproses': badgeClass = 'primary'; break;
                    case 'Ditolak':  badgeClass = 'danger';  break;
                    case 'Selesai':  badgeClass = 'success'; break;
                }
                $('#modal-status').html('<span class="badge bg-' + badgeClass + '">' + data.status + '</span>');
                
                $('#modal-description').text(data.description);
                $('#modal-location').text(data.location);
                
                // Handle image
                if (data.image) {
                    $('#modal-image').html('<img src="' + data.image + '" class="img-fluid rounded" style="max-height: 200px;">');
                } else {
                    $('#modal-image').html('<p class="text-muted">Tidak ada foto</p>');
                }
                
                // Fill histories with badges
                var historyHtml = '';
                histories.forEach(function(history) {
                    var historyBadgeClass = '';
                    switch (history.status) {
                        case 'Diajukan': historyBadgeClass = 'warning'; break;
                        case 'Diproses': historyBadgeClass = 'primary'; break;
                        case 'Ditolak':  historyBadgeClass = 'danger';  break;
                        case 'Selesai':  historyBadgeClass = 'success'; break;
                    }
                    
                    historyHtml += '<tr>' +
                        '<td>' + moment(history.date).format('DD-MM-YYYY HH:mm') + '</td>' +
                        '<td><span class="badge bg-' + historyBadgeClass + '">' + history.status + '</span></td>' +
                        '<td>' + history.note + '</td>' +
                        '</tr>';
                });
                $('#modal-histories').html(historyHtml);
                
                // Show modal
                $('#detailModal').modal('show');
            }
        });
    });
});
</script>
@endpush 