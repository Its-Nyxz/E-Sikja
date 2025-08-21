@extends('layouts.cms')


@section('content')
<div class="container-fluid">
    <!-- Statistics Cards Row -->
    <div class="row d-flex justify-content-center">
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="{{ route('data-pengajuan.index') }}" class="text-decoration-none">
                <div class="dashboard-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Pengajuan</h6>
                            <h4 class="mb-0">{{ $totalRequest ?? 0 }}</h4>
                        </div>
                        <div class="icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="{{ route('data-pengaduan.index') }}" class="text-decoration-none">
                <div class="dashboard-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Pengaduan</h6>
                            <h4 class="mb-0">{{ $totalComplaint ?? 0 }}</h4>
                        </div>
                        <div class="icon">
                            <i class="fas fa-exclamation-circle"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="{{ route('notifikasi.index') }}" class="text-decoration-none">
                <div class="dashboard-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Pemberitahuan</h6>
                            <h4 class="mb-0">{{ $totalNotification ?? 0 }}</h4>
                        </div>
                        <div class="icon">
                            <i class="fas fa-bell"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="{{ route('data-masyarakat.index') }}" class="text-decoration-none">
                <div class="dashboard-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Masyarakat</h6>
                            <h4 class="mb-0">{{ $totalResident ?? 0 }}</h4>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="{{ route('informasi-kelurahan.index') }}" class="text-decoration-none">
                <div class="dashboard-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Informasi</h6>
                            <h4 class="mb-0">{{ $totalInformation ?? 0 }}</h4>
                        </div>
                        <div class="icon">
                            <i class="fas fa-info"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="{{ route('jenis-permohonan.index') }}" class="text-decoration-none">
                <div class="dashboard-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Jenis Permohonan</h6>
                            <h4 class="mb-0">{{ $totalLetterType ?? 0 }}</h4>
                        </div>
                        <div class="icon">
                            <i class="fas fa-list"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tabel Pengajuan Terbaru</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nomor Pengajuan</th>
                                    <th>Jenis Pengajuan</th>
                                    <th>Status</th>
                                    <th>Tanggal Pengajuan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($latestRequests) == 0)
                                    <tr>
                                        <td colspan="5" class="text-center">Belum ada pengajuan</td>
                                    </tr>
                                @else
                                    @foreach($latestRequests as $index => $request)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $request->code }}</td>
                                            <td>{{ $request->requestType->name }}</td>
                                            <td>
                                                <span class="badge bg-{{ $request->status == 'Diajukan' ? 'warning' : ($request->status == 'Diproses' ? 'info' : ($request->status == 'Selesai' ? 'success' : 'danger')) }}">
                                                    {{ $request->status }}
                                                </span>
                                            </td>
                                            <td>{{ date('d-m-Y', strtotime($request->created_at)) }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tabel Pengaduan Terbaru</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nomor Pengaduan</th>
                                    <th>Judul Pengaduan</th>
                                    <th>Status</th>
                                    <th>Tanggal Pengaduan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($latestComplaints) == 0)
                                    <tr>
                                        <td colspan="5" class="text-center">Belum ada pengaudan</td>
                                    </tr>
                                @else
                                    @foreach($latestComplaints as $index => $request)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $request->code }}</td>
                                            <td>{{ $request->title }}</td>
                                            <td>
                                                <span class="badge bg-{{ $request->status == 'Diajukan' ? 'warning' : ($request->status == 'Diproses' ? 'info' : ($request->status == 'Selesai' ? 'success' : 'danger')) }}">
                                                    {{ $request->status }}
                                                </span>
                                            </td>
                                            <td>{{ date('d-m-Y', strtotime($request->created_at)) }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
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
        // Initialize any necessary JavaScript components here
    });
</script>
@endpush
