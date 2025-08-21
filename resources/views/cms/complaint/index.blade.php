@extends('layouts.cms')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">List Pengaduan</h3>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <select class="form-control" id="status-filter">
                                <option value="semua">Semua Status</option>
                                <option value="Diajukan">Diajukan</option>
                                <option value="Diproses">Diproses</option>
                                <option value="Ditolak">Ditolak</option>
                                <option value="Selesai">Selesai</option>
                            </select>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" width="100%" id="complaint-table">
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
                {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}

                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(function() {
        var table = $('#complaint-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('data-pengaduan.index') }}",
                data: function(d) {
                    d.status = $('#status-filter').val();
                }
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'created_at', name: 'created_at'},
                {data: 'code', name: 'code'},
                {data: 'user.name', name: 'user.name'},
                {data: 'title', name: 'title'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        $('#status-filter').change(function() {
            table.ajax.reload();
        });

        // Handle show detail
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
                        case 'Diajukan':
                            badgeClass = 'warning';
                            break;
                        case 'Diproses':
                            badgeClass = 'primary';
                            break;
                        case 'Ditolak':
                            badgeClass = 'danger';
                            break;
                        case 'Selesai':
                            badgeClass = 'success';
                            break;
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
                            case 'Diajukan':
                                historyBadgeClass = 'warning';
                                break;
                            case 'Diproses':
                                historyBadgeClass = 'primary';
                                break;
                            case 'Ditolak':
                                historyBadgeClass = 'danger';
                                break;
                            case 'Selesai':
                                historyBadgeClass = 'success';
                                break;
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