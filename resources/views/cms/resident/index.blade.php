@extends('layouts.cms')

@section('content')
    
<div class="container-fluid">

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div></div>
                @if (Auth::user()->role == 'admin')
                    <a href="<?= route('data-masyarakat.create') ?>" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Tambah {{ $title }}
                    </a>
                @endif
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="residentsTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Tempat, Tanggal Lahir</th>
                            <th>Jenis Kelamin</th>
                            <th>Alamat</th>
                            <th>RT/RW</th>
                            <th>Agama</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                       
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function () {
        $('#residentsTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('data-masyarakat.index') }}',
            columns: [
                { data: 'nik', name: 'nik' },
                { data: 'name', name: 'name' },
                { data: 'ttl', name: 'ttl' }, // Pastikan field ini ada di model/database
                { data: 'gender', name: 'gender' },
                { data: 'address', name: 'address' },
                { data: 'rt_rw', name: 'rt_rw' },
                { data: 'religion', name: 'religion' },
                { data: 'marital_status', name: 'marital_status' },
                { data: 'aksi', name: 'aksi', orderable: false, searchable: false }
            ]
        });
    });
</script>   
@endpush
@endsection
