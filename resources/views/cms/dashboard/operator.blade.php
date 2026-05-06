@extends('layouts.cms')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard Operator</h1>
    </div>

    <!-- Statistics Cards Row -->
    <div class="row d-flex justify-content-center">
        <!-- Total Pengajuan Card -->
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

        <!-- Pengajuan Pending Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="{{ route('data-pengaduan.index') }}" class="text-decoration-none">
                <div class="dashboard-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Pengaduan</h6>
                            <h4 class="mb-0">{{ $totalComplaint ?? 0 }}</h4>
                        </div>
                        <div class="icon">
                            <i class="fas fa-bullhorn"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Pengajuan Disetujui Card -->
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

        <!-- Pengajuan Ditolak Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="{{ route('notifikasi.index') }}" class="text-decoration-none">
                <div class="dashboard-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Notifikasi</h6>
                            <h4 class="mb-0">{{ $totalNotification ?? 0 }}</h4>
                        </div>
                        <div class="icon">
                            <i class="fas fa-bell"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row mb-4">
        <div class="col-lg-6 mb-4 mb-lg-0">
            <div class="card shadow h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary mb-2">Statistik Pengajuan</h6>
                    <div class="d-flex align-items-center flex-wrap">
                        <input type="date" id="chart-req-start" class="form-control form-control-sm mr-2 mb-2" style="max-width: 130px; margin-right: 5px;">
                        <span class="mr-2 mb-2" style="margin-right: 5px;">-</span>
                        <input type="date" id="chart-req-end" class="form-control form-control-sm mr-2 mb-2" style="max-width: 130px; margin-right: 5px;">
                        <button id="btn-filter-req" class="btn btn-sm btn-primary mb-2">Filter</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area" style="height: 300px; position: relative;">
                        <canvas id="requestChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card shadow h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success mb-2">Statistik Pengaduan</h6>
                    <div class="d-flex align-items-center flex-wrap">
                        <input type="date" id="chart-comp-start" class="form-control form-control-sm mr-2 mb-2" style="max-width: 130px; margin-right: 5px;">
                        <span class="mr-2 mb-2" style="margin-right: 5px;">-</span>
                        <input type="date" id="chart-comp-end" class="form-control form-control-sm mr-2 mb-2" style="max-width: 130px; margin-right: 5px;">
                        <button id="btn-filter-comp" class="btn btn-sm btn-success mb-2">Filter</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area" style="height: 300px; position: relative;">
                        <canvas id="complaintChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Pengajuan Terbaru -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Pengajuan Terbaru</h6>
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
                    <h6 class="m-0 font-weight-bold text-primary">Pengaduan Terbaru</h6>
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

@push('styles')
<style>
    .dashboard-card {
        background: #fff;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }

    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    .dashboard-card .icon {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #f8f9fc;
    }

    .dashboard-card .icon i {
        font-size: 24px;
        color: #4e73df;
    }

    .badge {
        padding: 8px 12px;
        font-size: 12px;
        font-weight: 600;
    }

    .bg-warning {
        background-color: #f6c23e !important;
    }

    .bg-success {
        background-color: #1cc88a !important;
    }

    .bg-danger {
        background-color: #e74a3b !important;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $(document).ready(function() {
        // Set default date range: 30 hari terakhir
        const today = new Date();
        const thirtyDaysAgo = new Date();
        thirtyDaysAgo.setDate(today.getDate() - 29);

        const formatDate = (d) => d.toISOString().split('T')[0];
        const defaultStart = formatDate(thirtyDaysAgo);
        const defaultEnd = formatDate(today);

        $('#chart-req-start').val(defaultStart);
        $('#chart-req-end').val(defaultEnd);
        $('#chart-comp-start').val(defaultStart);
        $('#chart-comp-end').val(defaultEnd);

        let requestChart = null;
        let complaintChart = null;

        const commonOptions = {
            maintainAspectRatio: false,
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false, drawBorder: false } },
                y: {
                    ticks: { beginAtZero: true, stepSize: 1 },
                    grid: {
                        color: "rgb(234, 236, 244)",
                        zeroLineColor: "rgb(234, 236, 244)",
                        drawBorder: false,
                        borderDash: [2],
                        zeroLineBorderDash: [2]
                    }
                }
            }
        };

        function fetchRequestChart() {
            const startDate = $('#chart-req-start').val();
            const endDate = $('#chart-req-end').val();

            $.ajax({
                url: "{{ route('dashboard.chart-data') }}",
                type: "GET",
                data: { type: 'request', start_date: startDate, end_date: endDate },
                success: function(response) {
                    if (requestChart) requestChart.destroy();
                    const ctxReq = document.getElementById('requestChart').getContext('2d');
                    requestChart = new Chart(ctxReq, {
                        type: 'line',
                        data: {
                            labels: response.labels,
                            datasets: [{
                                label: 'Total Pengajuan',
                                data: response.data,
                                borderColor: '#4e73df',
                                backgroundColor: 'rgba(78, 115, 223, 0.1)',
                                pointBackgroundColor: '#4e73df',
                                pointBorderColor: '#fff',
                                tension: 0.3,
                                fill: true
                            }]
                        },
                        options: commonOptions
                    });
                }
            });
        }

        function fetchComplaintChart() {
            const startDate = $('#chart-comp-start').val();
            const endDate = $('#chart-comp-end').val();

            $.ajax({
                url: "{{ route('dashboard.chart-data') }}",
                type: "GET",
                data: { type: 'complaint', start_date: startDate, end_date: endDate },
                success: function(response) {
                    if (complaintChart) complaintChart.destroy();
                    const ctxComp = document.getElementById('complaintChart').getContext('2d');
                    complaintChart = new Chart(ctxComp, {
                        type: 'line',
                        data: {
                            labels: response.labels,
                            datasets: [{
                                label: 'Total Pengaduan',
                                data: response.data,
                                borderColor: '#1cc88a',
                                backgroundColor: 'rgba(28, 200, 138, 0.1)',
                                pointBackgroundColor: '#1cc88a',
                                pointBorderColor: '#fff',
                                tension: 0.3,
                                fill: true
                            }]
                        },
                        options: commonOptions
                    });
                }
            });
        }

        // Init charts
        fetchRequestChart();
        fetchComplaintChart();

        // Filter buttons
        $('#btn-filter-req').on('click', function() {
            fetchRequestChart();
        });
        $('#btn-filter-comp').on('click', function() {
            fetchComplaintChart();
        });
    });
</script>
@endpush