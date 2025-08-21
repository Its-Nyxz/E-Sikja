@extends('layouts.cms')

@section('content')
<style>
    .nav-tabs .nav-link {
        color: #495057;
    }
    .nav-tabs .nav-link.active {
        font-weight: bold;
    }
    .nav-tabs .nav-link[data-bs-target="#semua"] {
        border-color: #6c757d;
    }
    .nav-tabs .nav-link[data-bs-target="#semua"].active {
        background-color: #6c757d;
        color: white;
    }
    .nav-tabs .nav-link[data-bs-target="#diajukan"] {
        border-color: #ffc107;
    }
    .nav-tabs .nav-link[data-bs-target="#diajukan"].active {
        background-color: #ffc107;
        color: white;
    }
    .nav-tabs .nav-link[data-bs-target="#diproses"] {
        border-color: #0d6efd;
    }
    .nav-tabs .nav-link[data-bs-target="#diproses"].active {
        background-color: #0d6efd;
        color: white;
    }
    .nav-tabs .nav-link[data-bs-target="#selesai"] {
        border-color: #198754;
    }
    .nav-tabs .nav-link[data-bs-target="#selesai"].active {
        background-color: #198754;
        color: white;
    }
    .nav-tabs .nav-link[data-bs-target="#ditolak"] {
        border-color: #dc3545;
    }
    .nav-tabs .nav-link[data-bs-target="#ditolak"].active {
        background-color: #dc3545;
        color: white;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title"></h3>
                    <a href="{{ route('pengajuan-saya.create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Buat Pengajuan Baru
                    </a>
                </div>
                <div class="card-body">
                    <!-- Tab Navigation -->
                    <ul class="nav nav-tabs" id="requestTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="diajukan-tab" data-bs-toggle="tab" data-bs-target="#semua" type="button" role="tab" aria-controls="semua" aria-selected="true">
                                Semua
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="diajukan-tab" data-bs-toggle="tab" data-bs-target="#diajukan" type="button" role="tab" aria-controls="diajukan" aria-selected="true">
                                Diajukan
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="diproses-tab" data-bs-toggle="tab" data-bs-target="#diproses" type="button" role="tab" aria-controls="diproses" aria-selected="false">
                                Diproses
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="selesai-tab" data-bs-toggle="tab" data-bs-target="#selesai" type="button" role="tab" aria-controls="selesai" aria-selected="false">
                                Selesai
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="ditolak-tab" data-bs-toggle="tab" data-bs-target="#ditolak" type="button" role="tab" aria-controls="ditolak" aria-selected="false">
                                Ditolak
                            </button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content mt-3" id="requestTabsContent">
                        <!-- Semua Tab -->
                        <div class="tab-pane fade show active" id="semua" role="tabpanel" aria-labelledby="semua-tab">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" width="100%" id="table-semua">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No. Request</th>
                                            <th>No.Dokumen</th>
                                            <th>Tanggal Pengajuan</th>
                                            <th>Jenis Pengajuan</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <!-- Diajukan Tab -->
                        <div class="tab-pane fade show" id="diajukan" role="tabpanel" aria-labelledby="diajukan-tab">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" width="100%" id="table-diajukan">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No. Request</th>
                                            <th>No.Dokumen</th>
                                            <th>Tanggal Pengajuan</th>
                                            <th>Jenis Pengajuan</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>

                        <!-- Diproses Tab -->
                        <div class="tab-pane fade" id="diproses" role="tabpanel" aria-labelledby="diproses-tab">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" width="100%" id="table-diproses">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No. Request</th>
                                            <th>No.Dokumen</th>
                                            <th>Tanggal Pengajuan</th>
                                            <th>Jenis Pengajuan</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>

                        <!-- Selesai Tab -->
                        <div class="tab-pane fade" id="selesai" role="tabpanel" aria-labelledby="selesai-tab">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" width="100%" id="table-selesai">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No. Request</th>
                                            <th>No.Dokumen</th>
                                            <th>Tanggal Pengajuan</th>
                                            <th>Jenis Pengajuan</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>

                        <!-- Ditolak Tab -->
                        <div class="tab-pane fade" id="ditolak" role="tabpanel" aria-labelledby="ditolak-tab">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" width="100%" id="table-ditolak">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No. Request</th>
                                            <th>No.Dokumen</th>
                                            <th>Tanggal Pengajuan</th>
                                            <th>Jenis Pengajuan</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Store DataTable instances
        const dataTables = {};
        
        // Function to initialize DataTable
        function initDataTable(status) {
            if (dataTables[status]) return dataTables[status];

            const tableId = `#table-${status}`;
            const table = $(tableId).DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('pengajuan-saya.index') }}",
                    data: function(d) {
                        d.status = status;
                    }
                },
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'code',
                        name: 'code'
                    },
                    {
                        data: 'document_number',
                        name: 'document_number'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'request_type',
                        name: 'request_type'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function(data) {
                            let badge = '';
                            switch(data) {
                                case 'Diajukan':
                                    badge = '<span class="badge bg-warning">Diajukan</span>';
                                    break;
                                case 'Diproses':
                                    badge = '<span class="badge bg-primary">Diproses</span>';
                                    break;
                                case 'Selesai':
                                    badge = '<span class="badge bg-success">Selesai</span>';
                                    break;
                                case 'Ditolak':
                                    badge = '<span class="badge bg-danger">Ditolak</span>';
                                    break;
                            }
                            return badge;
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    }
                ],
                order: [[1, 'desc']], // Sort by tanggal_pengajuan descending
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
                }
            });

            dataTables[status] = table;
            return table;
        }

        // Initialize only the active tab
        initDataTable('semua');

        // Handle tab changes
        $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
            const targetId = $(e.target).attr('data-bs-target').replace('#', '');
            initDataTable(targetId);
        });
    });
</script>
@endpush