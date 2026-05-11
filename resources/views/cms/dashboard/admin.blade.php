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

    <!-- Charts Row -->
    <div class="row mb-4">
        <div class="col-lg-6 mb-4 mb-lg-0">
            <div class="card shadow h-100">
                <div class="card-header py-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="m-0 font-weight-bold text-primary">Statistik Pengajuan</h6>
                        <div class="chart-toggle-group" id="reqChartToggle">
                            <button type="button" class="chart-toggle-btn active" data-type="line" title="Line Chart">
                                <i class="fas fa-chart-line"></i>
                            </button>
                            <button type="button" class="chart-toggle-btn" data-type="bar" title="Bar Chart">
                                <i class="fas fa-chart-bar"></i>
                            </button>
                            <button type="button" class="chart-toggle-btn" data-type="pie" title="Pie Chart">
                                <i class="fas fa-chart-pie"></i>
                            </button>
                        </div>
                    </div>
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
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="m-0 font-weight-bold text-success">Statistik Pengaduan</h6>
                        <div class="chart-toggle-group" id="compChartToggle">
                            <button type="button" class="chart-toggle-btn active" data-type="line" title="Line Chart">
                                <i class="fas fa-chart-line"></i>
                            </button>
                            <button type="button" class="chart-toggle-btn" data-type="bar" title="Bar Chart">
                                <i class="fas fa-chart-bar"></i>
                            </button>
                            <button type="button" class="chart-toggle-btn" data-type="pie" title="Pie Chart">
                                <i class="fas fa-chart-pie"></i>
                            </button>
                        </div>
                    </div>
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

@push('styles')
<style>
    .chart-toggle-group {
        display: inline-flex;
        background: #f0f2f5;
        border-radius: 8px;
        padding: 3px;
        gap: 2px;
    }
    .chart-toggle-btn {
        border: none;
        background: transparent;
        color: #6c757d;
        padding: 5px 12px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        line-height: 1;
    }
    .chart-toggle-btn:hover {
        color: #4e73df;
        background: rgba(78, 115, 223, 0.08);
    }
    .chart-toggle-btn.active {
        background: #fff;
        color: #4e73df;
        box-shadow: 0 1px 4px rgba(78, 115, 223, 0.18);
    }
    .chart-area canvas {
        transition: opacity 0.3s ease;
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
        let reqChartType = 'line';
        let compChartType = 'line';

        // Store last fetched data so we can re-render without refetching
        let lastReqData = null;
        let lastCompData = null;

        // Generate distinct colors for pie/bar segments
        function generateColors(count) {
            const palette = [
                '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b',
                '#858796', '#5a5c69', '#2e59d9', '#17a673', '#2c9faf',
                '#dda0dd', '#ff7f50', '#6495ed', '#dc143c', '#00ced1',
                '#ffa07a', '#20b2aa', '#87ceeb', '#778899', '#b0c4de',
                '#ff6384', '#9966ff', '#ffce56', '#4bc0c0', '#ff9f40',
                '#c9cbcf', '#7bc8a4', '#e8c3b9', '#b6a6ca', '#8dd3c7'
            ];
            const colors = [];
            for (let i = 0; i < count; i++) {
                colors.push(palette[i % palette.length]);
            }
            return colors;
        }

        function getChartOptions(chartType) {
            if (chartType === 'pie') {
                return {
                    maintainAspectRatio: false,
                    responsive: true,
                    animation: {
                        duration: 600,
                        easing: 'easeInOutQuart'
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: {
                                boxWidth: 12,
                                padding: 8,
                                font: { size: 10 },
                                usePointStyle: true
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const value = context.parsed;
                                    const pct = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                    return context.label + ': ' + value + ' (' + pct + '%)';
                                }
                            }
                        }
                    }
                };
            }

            return {
                maintainAspectRatio: false,
                responsive: true,
                animation: {
                    duration: 600,
                    easing: 'easeInOutQuart'
                },
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
        }

        function buildDataset(chartType, labels, data, color, bgColor, label) {
            if (chartType === 'pie') {
                // For pie: filter out zero-value entries for cleaner display
                const filteredLabels = [];
                const filteredData = [];
                for (let i = 0; i < data.length; i++) {
                    if (data[i] > 0) {
                        filteredLabels.push(labels[i]);
                        filteredData.push(data[i]);
                    }
                }

                // If all data is zero, show a placeholder
                if (filteredData.length === 0) {
                    filteredLabels.push('Tidak ada data');
                    filteredData.push(1);
                }

                const colors = generateColors(filteredData.length);
                return {
                    labels: filteredLabels,
                    datasets: [{
                        label: label,
                        data: filteredData,
                        backgroundColor: colors.map(c => c + 'CC'),
                        borderColor: colors,
                        borderWidth: 2,
                        hoverOffset: 8
                    }]
                };
            }

            if (chartType === 'bar') {
                const colors = generateColors(data.length);
                return {
                    labels: labels,
                    datasets: [{
                        label: label,
                        data: data,
                        backgroundColor: colors.map(c => c + 'B3'),
                        borderColor: colors,
                        borderWidth: 1,
                        borderRadius: 4,
                        borderSkipped: false
                    }]
                };
            }

            // Line chart (default)
            return {
                labels: labels,
                datasets: [{
                    label: label,
                    data: data,
                    borderColor: color,
                    backgroundColor: bgColor,
                    pointBackgroundColor: color,
                    pointBorderColor: '#fff',
                    tension: 0.3,
                    fill: true
                }]
            };
        }

        function renderRequestChart(response) {
            const canvas = document.getElementById('requestChart');

            // Fade out animation
            canvas.style.opacity = '0';

            setTimeout(function() {
                if (requestChart) requestChart.destroy();
                const ctx = canvas.getContext('2d');
                const chartData = buildDataset(
                    reqChartType,
                    response.labels,
                    response.data,
                    '#4e73df',
                    'rgba(78, 115, 223, 0.1)',
                    'Total Pengajuan'
                );

                requestChart = new Chart(ctx, {
                    type: reqChartType === 'pie' ? 'pie' : reqChartType,
                    data: chartData,
                    options: getChartOptions(reqChartType)
                });

                // Fade in
                canvas.style.opacity = '1';
            }, 250);
        }

        function renderComplaintChart(response) {
            const canvas = document.getElementById('complaintChart');

            // Fade out animation
            canvas.style.opacity = '0';

            setTimeout(function() {
                if (complaintChart) complaintChart.destroy();
                const ctx = canvas.getContext('2d');
                const chartData = buildDataset(
                    compChartType,
                    response.labels,
                    response.data,
                    '#1cc88a',
                    'rgba(28, 200, 138, 0.1)',
                    'Total Pengaduan'
                );

                complaintChart = new Chart(ctx, {
                    type: compChartType === 'pie' ? 'pie' : compChartType,
                    data: chartData,
                    options: getChartOptions(compChartType)
                });

                // Fade in
                canvas.style.opacity = '1';
            }, 250);
        }

        function fetchRequestChart() {
            const startDate = $('#chart-req-start').val();
            const endDate = $('#chart-req-end').val();

            $.ajax({
                url: "{{ route('dashboard.chart-data') }}",
                type: "GET",
                data: { type: 'request', start_date: startDate, end_date: endDate },
                success: function(response) {
                    lastReqData = response;
                    renderRequestChart(response);
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
                    lastCompData = response;
                    renderComplaintChart(response);
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

        // Chart type toggle - Pengajuan
        $('#reqChartToggle').on('click', '.chart-toggle-btn', function() {
            const $btn = $(this);
            const newType = $btn.data('type');

            if (newType === reqChartType) return;

            // Update active state
            $('#reqChartToggle .chart-toggle-btn').removeClass('active');
            $btn.addClass('active');

            reqChartType = newType;

            // Re-render with cached data (no new fetch needed)
            if (lastReqData) {
                renderRequestChart(lastReqData);
            }
        });

        // Chart type toggle - Pengaduan
        $('#compChartToggle').on('click', '.chart-toggle-btn', function() {
            const $btn = $(this);
            const newType = $btn.data('type');

            if (newType === compChartType) return;

            // Update active state
            $('#compChartToggle .chart-toggle-btn').removeClass('active');
            $btn.addClass('active');

            compChartType = newType;

            // Re-render with cached data (no new fetch needed)
            if (lastCompData) {
                renderComplaintChart(lastCompData);
            }
        });
    });

</script>
@endpush
