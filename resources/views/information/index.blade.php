@extends('layouts.cms')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title"></h3>
                    <div class="card-tools">
                        <a href="{{ route('informasi-kelurahan.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah Informasi
                        </a>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped" width="100%" id="informationTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Gambar</th>
                                <th>Judul</th>
                                <th>Status</th>
                                <th>Dibuat Oleh</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .toggle-switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }
    .toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 34px;
    }
    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }
    input:checked + .slider {
        background-color: #2196F3;
    }
    input:checked + .slider:before {
        transform: translateX(26px);
    }
</style>
@endpush

@push('scripts')
<script>
    $(function() {
        $('#informationTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('informasi-kelurahan.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'image_preview', name: 'image', orderable: false, searchable: false},
                {data: 'title', name: 'title'},
                {
                    data: 'status',
                    name: 'status',
                    render: function(data, type, row) {
                        return `
                            <div class="form-check form-switch">
                                <input class="form-check-input status-toggle" id="status-${row.id}"  type="checkbox" 
                                    ${data == 1 ? 'checked' : ''} 
                                    data-id="${row.id}">
                                <label class="form-check-label status-label" for="status-${row.id}">
                                    ${data == 1 ? 'Aktif' : 'Tidak Aktif'}
                                </label>
                            </div>
                        `;
                    },
                    orderable: false,
                    searchable: false
                },
                {data: 'user.name', name: 'user.name'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            order: [[0, 'desc']],
            language: {
                // url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            }
        });

        // Status toggle handler
        $(document).on('change', '.status-toggle', function() {
            let id = $(this).data('id');
            let status = $(this).prop('checked') ? 1 : 0;
            let $toggle = $(this);
            let $label = $toggle.siblings('.status-label');
            
            $.ajax({
                url: `/informasi-kelurahan/${id}/toggle-status`,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    status: status
                },
                success: function(response) {
                    $label.text(status ? 'Aktif' : 'Tidak Aktif');
                    Toast.fire({
                        icon: 'success',
                        title: 'Status berhasil diubah'
                    }).then(() => {
                        $('#informationTable').DataTable().ajax.reload();
                    });
                },
                error: function(xhr) {
                    Toast.fire({
                        icon: 'error',
                        title: 'Status gagal diubah'
                    });
                    // Revert the toggle if there's an error
                    $toggle.prop('checked', !status);
                    $label.text(!status ? 'Aktif' : 'Tidak Aktif');
                }
            });
        });

        // Delete button handler
        $(document).on('click', '.delete-btn', function() {
            let id = $(this).data('id');
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/informasi-kelurahan/${id}`,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Toast.fire({
                                icon: 'success',
                                title: 'Data berhasil dihapus'
                            }).then(() => {
                                $('#informationTable').DataTable().ajax.reload();
                            });
                        },
                        error: function(xhr) {
                            Toast.fire({
                                icon: 'error',
                                title: 'Data gagal dihapus'
                            });
                        }
                    });
                }
            });
        });
    });
</script>
@endpush
@endsection 