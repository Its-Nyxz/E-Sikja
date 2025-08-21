@extends('layouts.cms')

@section('content')
<div class="container-fluid">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="row">
        <!-- List Column (7 columns) -->
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">List Pengaduan</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="mb-3 col-4">
                            <select class="form-control" id="status-filter">
                                <option value="semua">Semua Status</option>
                                <option value="Diajukan">Diajukan</option>
                                <option value="Diproses">Diproses</option>
                                <option value="Selesai">Selesai</option>
                                <option value="Ditolak">Ditolak</option>
                            </select>
                        </div>

                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" width="100%" id="complaints-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Judul</th>
                                    <th>Tanggal Kejadian</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Column (5 columns) -->
        <div class="col-md-5">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title" id="form-title">Buat Pengaduan Baru</h5>
                    <button type="button" class="btn btn-secondary btn-sm" id="reset-form" style="display: none;">
                        <i class="fas fa-times"></i> Batal Edit
                    </button>
                </div>
                <div class="card-body">
                    <form id="complaint-form" action="{{ route('pengaduan-saya.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="_method" value="POST" id="form-method">
                        <input type="hidden" name="complaint_id" id="complaint-id">

                        <div class="form-group mb-3">
                            <label for="title">Judul Pengaduan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="date">Tanggal Kejadian <span class="text-danger">*</span></label>
                            <input type="datetime-local" class="form-control @error('date') is-invalid @enderror" 
                                id="date" name="date" value="{{ old('date') }}" required>
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="description">Deskripsi Pengaduan <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="location">Lokasi Kejadian <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('location') is-invalid @enderror" 
                                id="location" name="location" rows="2" required>{{ old('location') }}</textarea>
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="image">Foto Pendukung</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                id="image" name="image" accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB</small>
                            <div id="current-image" class="mt-2" style="display: none;">
                                <img src="" alt="Current Image" class="img-thumbnail" style="max-height: 200px;">
                                <p class="text-muted small mt-1">Foto saat ini</p>
                            </div>
                        </div>

                        <div class="form-group text-end">
                            <button type="submit" class="btn btn-primary" id="submit-btn">Kirim Pengaduan</button>
                        </div>
                    </form>
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
$(document).ready(function() {
    // Setup CSRF token for all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var table = $('#complaints-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('pengaduan-saya.index') }}",
            data: function(d) {
                d.status = $('#status-filter').val();
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'code', name: 'code'},
            {data: 'title', name: 'title'},
            {data: 'date', name: 'date'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        order: [[3, 'desc']]
    });

    $('#status-filter').change(function() {
        table.ajax.reload();
    });

    // Function to reset form
    function resetForm() {
        $('#form-title').text('Buat Pengaduan Baru');
        $('#form-method').val('POST');
        $('#complaint-id').val('');
        $('#complaint-form').attr('action', "{{ route('pengaduan-saya.store') }}");
        $('#complaint-form')[0].reset();
        $('#current-image').hide();
        $('#reset-form').hide();
        $('#submit-btn').text('Kirim Pengaduan');
        
        // Update CSRF token
        var newToken = $('meta[name="csrf-token"]').attr('content');
        $('input[name="_token"]').val(newToken);
    }

    // Handle edit button click
    $(document).on('click', '.btn-warning', function(e) {
        e.preventDefault();
        var id = $(this).closest('form').find('input[name="id"]').val();
        var href = $(this).attr('href');
        
        // Get complaint data
        $.get(href, function(data) {
            var title = data.title;
            var csrf_token = data.csrf_token;
            var data = data.complaint;
            
            // Update CSRF token
            var newToken = $('meta[name="csrf-token"]').attr('content');
            $('input[name="_token"]').val(csrf_token);
            
            $('#form-title').text(title);
            $('#form-method').val('PUT');
            $('#complaint-id').val(data.id);
            $('#complaint-form').attr('action', "{{ url('pengaduan-saya') }}/update/" + data.id);
            
            // Fill form fields
            $('#title').val(data.title);
            $('#date').val(data.date);
            $('#description').val(data.description);
            $('#location').val(data.location);
            
            // Show current image if exists
            if (data.image) {
                $('#current-image').show();
                $('#current-image img').attr('src', data.image);
            } else {
                $('#current-image').hide();
            }
            
            $('#reset-form').show();
            $('#submit-btn').text('Update Pengaduan');
            
            // Scroll to form
            $('html, body').animate({
                scrollTop: $("#complaint-form").offset().top - 100
            }, 500);
        });
    });

    // Handle reset form button
    $('#reset-form').click(function() {
        resetForm();
    });

    // Handle form submission
    $('#complaint-form').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var method = $('#form-method').val();
        var url = $(this).attr('action');

        // Tambahkan _method jika update
        if (method === 'PUT') {
            formData.append('_method', 'PUT');
        }

        // Tambahkan file jika ada
        var imageFile = $('#image')[0].files[0];
        if (imageFile) {
            formData.append('image', imageFile);
        }

        $.ajax({
            url: url,
            type: 'POST', // Selalu gunakan POST
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.status === 'success') {
                    resetForm();
                    table.ajax.reload();
                    
                }
                Toast.fire({
                    icon: response.status,
                    title: response.message
                });
            },
            error: function(xhr) {
                if (xhr.status === 419) {
                    window.location.reload();
                } else {
                    var errors = xhr.responseJSON.errors;
                    if (errors) {
                        Object.keys(errors).forEach(function(key) {
                            Toast.fire('error', errors[key][0]);
                        });
                    } else {
                        Toast.fire('error', 'Terjadi kesalahan. Silakan coba lagi.');
                    }
                }
            }
        });
    });

    // Handle show button click
    $(document).on('click', '.btn-info', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        
        // Get complaint data
        $.get("{{ url('pengaduan-saya') }}/show/" + id, function(data) {
            // Update modal content
            $('#modal-code').text(data.code);
            $('#modal-title').text(data.title);
            $('#modal-date').text(data.date);
            $('#modal-location').text(data.location);
            $('#modal-reporter').text(data.reporter_name || '-');
            $('#modal-status').html('<span class="badge bg-' + 
                (data.status === 'Diajukan' ? 'primary' : 
                 data.status === 'Diproses' ? 'warning' : 
                 data.status === 'Selesai' ? 'success' : 'danger') + 
                ' text-white">' + data.status + '</span>');
            $('#modal-description').text(data.description);
            
            // Handle image
            if (data.image) {
                $('#modal-image').html('<img src="' + data.image + '" class="img-fluid" style="max-height: 300px;">');
            } else {
                $('#modal-image').text('Tidak ada foto');
            }

            // Handle history
            var historyHtml = '';
            data.histories.forEach(function(history) {
                historyHtml += '<tr>' +
                    '<td>' + history.date + '</td>' +
                    '<td><span class="badge bg-' + 
                    (history.status === 'Diajukan' ? 'primary' : 
                     history.status === 'Diproses' ? 'warning' : 
                     history.status === 'Selesai' ? 'success' : 'danger') + 
                    ' text-white">' + history.status + '</span></td>' +
                    '<td>' + history.note + '</td>' +
                    '</tr>';
            });
            $('#modal-histories').html(historyHtml);
            
            // Show modal
            var modal = new bootstrap.Modal(document.getElementById('detailModal'));
            modal.show();
        });
    });
});
</script>
@endpush