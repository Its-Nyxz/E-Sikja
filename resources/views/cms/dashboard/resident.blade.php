@extends('layouts.cms')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4 text-gray-800">Dashboard Masyarakat</h1>
        </div>
    </div>

    <div class="row">
        <!-- Main Content Area -->
        <div class="col-lg-8">
            <!-- Pengajuan Statistics -->
            <div class="row mb-4">
                <div class="col-12">
                    <h4 class="mb-3">Statistik Pengajuan</h4>
                </div>
                <!-- Total Pengajuan Card -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-1">
                        <div class="card-body p-2">
                            <div class="row no-gutters align-items-center">
                                <div class="col">
                                    <div class="text-xxs font-weight-bold text-info text-uppercase mb-1">
                                        Total Pengajuan</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $countRequest['total'] ?? 0 }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pengajuan Diproses Card -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-1">
                        <div class="card-body p-2">
                            <div class="row no-gutters align-items-center">
                                <div class="col">
                                    <div class="text-xxs font-weight-bold text-warning text-uppercase mb-1">
                                        Sedang Diproses</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $countRequest['Diproses'] ?? 0 }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pengajuan Selesai Card -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-1">
                        <div class="card-body p-2">
                            <div class="row no-gutters align-items-center">
                                <div class="col">
                                    <div class="text-xxs font-weight-bold text-success text-uppercase mb-1">
                                        Selesai</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $countRequest['Selesai'] ?? 0 }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pengajuan Ditolak Card -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-danger shadow h-100 py-1">
                        <div class="card-body p-2">
                            <div class="row no-gutters align-items-center">
                                <div class="col">
                                    <div class="text-xxs font-weight-bold text-danger text-uppercase mb-1">
                                        Ditolak</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $countRequest['Ditolak'] ?? 0 }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Pengaduan Statistics -->
            <div class="row mb-4">
                <div class="col-12">
                    <h4 class="mb-3">Statistik Pengaduan</h4>
                </div>
                <!-- Total Pengaduan Card -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-1">
                        <div class="card-body p-2">
                            <div class="row no-gutters align-items-center">
                                <div class="col">
                                    <div class="text-xxs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Pengaduan</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $countComplaint['total'] ?? 0 }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pengaduan Diproses Card -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-1">
                        <div class="card-body p-2">
                            <div class="row no-gutters align-items-center">
                                <div class="col">
                                    <div class="text-xxs font-weight-bold text-warning text-uppercase mb-1">
                                        Sedang Diproses</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $countComplaint['Diproses'] ?? 0 }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pengaduan Selesai Card -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-1">
                        <div class="card-body p-2">
                            <div class="row no-gutters align-items-center">
                                <div class="col">
                                    <div class="text-xxs font-weight-bold text-success text-uppercase mb-1">
                                        Selesai</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $countComplaint['Selesai'] ?? 0 }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pengaduan Ditolak Card -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-danger shadow h-100 py-1">
                        <div class="card-body p-2">
                            <div class="row no-gutters align-items-center">
                                <div class="col">
                                    <div class="text-xxs font-weight-bold text-danger text-uppercase mb-1">
                                        Ditolak</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $countComplaint['Ditolak'] ?? 0 }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
        </div>

        <!-- Right Sidebar -->
        <div class="col-lg-4">
            <!-- Cek Status Pengajuan Card -->
            <div class="card shadow mb-4 border-left-primary">
                <div class="card-header py-3 bg-primary text-white">
                    <h6 class="m-0 font-weight-bold">Cek Status Pengajuan</h6>
                </div>
                <div class="card-body">
                    <form id="checkPengajuanForm" onsubmit="return checkPengajuan(event)">
                        <div class="form-group">
                            <label for="nomor_pengajuan">Nomor Pengajuan</label>
                            <input type="text" class="form-control" id="nomor_pengajuan" name="nomor_pengajuan" placeholder="Masukkan nomor pengajuan">
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm btn-block">
                            <i class="fas fa-search"></i> Cek Status
                        </button>
                    </form>

                    <!-- Status Check Modal -->
                    <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title" id="statusModalLabel">Status Pengajuan</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div id="statusResult" style="display: none;">
                                        <div class="alert mb-4" role="alert">
                                            <h6 class="alert-heading mb-1">Status Pengajuan</h6>
                                            <p class="mb-0" id="statusText"></p>
                                        </div>
                                        <div id="pengajuanInfo" style="display: none;">
                                            <div class="card mb-4">
                                                <div class="card-body p-3">
                                                    <h6 class="card-title mb-3">Informasi Pengajuan</h6>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <p class="mb-1"><small class="text-muted">Nomor Pengajuan</small></p>
                                                            <p class="mb-2" id="pengajuanCode"></p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p class="mb-1"><small class="text-muted">Jenis Pengajuan</small></p>
                                                            <p class="mb-2" id="pengajuanType"></p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p class="mb-1"><small class="text-muted">Tanggal Pengajuan</small></p>
                                                            <p class="mb-2" id="pengajuanDate"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="historySection" style="display: none;">
                                            <div class="card">
                                                <div class="card-body p-3">
                                                    <h6 class="card-title mb-3">Riwayat Status</h6>
                                                    <div class="timeline" id="historyTimeline">
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
                </div>
            </div>

            <!-- Cek Status Pengaduan Card -->
            <div class="card shadow mb-4 border-left-danger">
                <div class="card-header py-3 bg-danger text-white">
                    <h6 class="m-0 font-weight-bold">Cek Status Pengaduan</h6>
                </div>
                <div class="card-body">
                    <form id="checkPengaduanForm" onsubmit="return checkPengaduan(event)">
                        <div class="form-group">
                            <label for="nomor_pengaduan">Nomor Pengaduan</label>
                            <input type="text" class="form-control" id="nomor_pengaduan" name="nomor_pengaduan" placeholder="Masukkan nomor pengaduan">
                        </div>
                        <button type="submit" class="btn btn-danger btn-sm btn-block">
                            <i class="fas fa-search"></i> Cek Status
                        </button>
                    </form>

                    <!-- Status Check Modal -->
                    <div class="modal fade" id="pengaduanStatusModal" tabindex="-1" aria-labelledby="pengaduanStatusModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-danger text-white">
                                    <h5 class="modal-title" id="pengaduanStatusModalLabel">Status Pengaduan</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div id="pengaduanStatusResult" style="display: none;">
                                        <div class="alert mb-4" role="alert">
                                            <h6 class="alert-heading mb-1">Status Pengaduan</h6>
                                            <p class="mb-0" id="pengaduanStatusText"></p>
                                        </div>
                                        <div id="pengaduanInfo" style="display: none;">
                                            <div class="card mb-4">
                                                <div class="card-body p-3">
                                                    <h6 class="card-title mb-3">Informasi Pengaduan</h6>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <p class="mb-1"><small class="text-muted">Nomor Pengaduan</small></p>
                                                            <p class="mb-2" id="pengaduanCode"></p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p class="mb-1"><small class="text-muted">Judul Pengaduan</small></p>
                                                            <p class="mb-2" id="pengaduanType"></p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p class="mb-1"><small class="text-muted">Tanggal Pengaduan</small></p>
                                                            <p class="mb-2" id="pengaduanDate"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="pengaduanHistorySection" style="display: none;">
                                            <div class="card">
                                                <div class="card-body p-3">
                                                    <h6 class="card-title mb-3">Riwayat Status</h6>
                                                    <div class="timeline" id="pengaduanHistoryTimeline">
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


<style>
    .border-left-primary {
        border-left: 4px solid #4e73df !important;
    }
    .border-left-success {
        border-left: 4px solid #1cc88a !important;
    }
    .border-left-warning {
        border-left: 4px solid #f6c23e !important;
    }
    .border-left-danger {
        border-left: 4px solid #e74a3b !important;
    }
    .border-left-info {
        border-left: 4px solid #36b9cc !important;
    }
    .text-xxs {
        font-size: 0.65rem;
    }
    .timeline {
        position: relative;
        padding-left: 30px;
    }
    .timeline-item {
        position: relative;
        padding-bottom: 1.5rem;
    }
    .timeline-item:before {
        content: '';
        position: absolute;
        left: -30px;
        top: 0;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #fff;
        border: 2px solid #4e73df;
    }
    .timeline-item:after {
        content: '';
        position: absolute;
        left: -21px;
        top: 20px;
        width: 2px;
        height: calc(100% - 20px);
        background: #e3e6f0;
    }
    .timeline-item:last-child:after {
        display: none;
    }
    .timeline-item.pending:before { border-color: #f6c23e; }
    .timeline-item.process:before { border-color: #36b9cc; }
    .timeline-item.completed:before { border-color: #1cc88a; }
    .timeline-item.rejected:before { border-color: #e74a3b; }
</style>

<script>
function checkPengajuan(event) {
    event.preventDefault();
    
    const nomorPengajuan = document.getElementById('nomor_pengajuan').value;
    const statusResult = document.getElementById('statusResult');
    const statusText = document.getElementById('statusText');
    const pengajuanInfo = document.getElementById('pengajuanInfo');
    const historySection = document.getElementById('historySection');
    
    if (!nomorPengajuan) {
        alert('Mohon masukkan nomor pengajuan');
        return false;
    }

    // Show modal
    const statusModal = new bootstrap.Modal(document.getElementById('statusModal'));
    statusModal.show();

    // Show loading state
    statusResult.style.display = 'block';
    statusResult.className = 'mt-3';
    statusText.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memeriksa status...';
    pengajuanInfo.style.display = 'none';
    historySection.style.display = 'none';

    // Make AJAX request
    fetch(`/pengajuan-saya/check?nomor_pengajuan=${encodeURIComponent(nomorPengajuan)}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                let statusClass = '';
                let statusIcon = '';
                
                switch(data.status) {
                    case 'diajukan':
                        statusClass = 'alert-warning';
                        statusIcon = 'fa-clock';
                        break;
                    case 'diproses':
                        statusClass = 'alert-info';
                        statusIcon = 'fa-spinner';
                        break;
                    case 'selesai':
                        statusClass = 'alert-success';
                        statusIcon = 'fa-check-circle';
                        break;
                    case 'ditolak':
                        statusClass = 'alert-danger';
                        statusIcon = 'fa-times-circle';
                        break;
                    default:
                        statusClass = 'alert-secondary';
                        statusIcon = 'fa-question-circle';
                }

                statusResult.className = `mt-3 alert ${statusClass}`;
                statusText.innerHTML = `
                    <i class="fas ${statusIcon}"></i> 
                    ${data.message}
                    ${data.details ? `<br><small class="text-muted">${data.details}</small>` : ''}
                `;

                // Show pengajuan info
                document.getElementById('pengajuanCode').innerHTML = `<a target="_blank" href="/pengajuan-saya/show/${data.pengajuan.id}">${data.pengajuan.code}</a>`;
                document.getElementById('pengajuanType').textContent = data.pengajuan.type;
                document.getElementById('pengajuanDate').textContent = data.pengajuan.created_at;
                pengajuanInfo.style.display = 'block';

                // Show history
                const historyTimeline = document.getElementById('historyTimeline');
                historyTimeline.innerHTML = '';
                
                data.history.forEach(item => {
                    const statusClass = item.status.toLowerCase().replace(' ', '-');
                    const historyItem = document.createElement('div');
                    historyItem.className = `timeline-item ${statusClass}`;
                    historyItem.innerHTML = `
                        <div class="mb-1">
                            <strong>${item.status}</strong>
                            <small class="text-muted float-end">${item.created_at}</small>
                        </div>
                        ${item.notes ? `<p class="mb-0 small">${item.notes}</p>` : ''}
                    `;
                    historyTimeline.appendChild(historyItem);
                });
                
                historySection.style.display = 'block';
            } else {
                statusResult.className = 'mt-3 alert alert-danger';
                statusText.innerHTML = data.message || 'Terjadi kesalahan saat memeriksa status';
                pengajuanInfo.style.display = 'none';
                historySection.style.display = 'none';
            }
        })
        .catch(error => {
            statusResult.className = 'mt-3 alert alert-danger';
            statusText.innerHTML = 'Terjadi kesalahan saat memeriksa status';
            pengajuanInfo.style.display = 'none';
            historySection.style.display = 'none';
            console.error('Error:', error);
        });

    return false;
}

function checkPengaduan(event) {
    event.preventDefault();
    
    const nomorPengaduan = document.getElementById('nomor_pengaduan').value;
    const statusResult = document.getElementById('pengaduanStatusResult');
    const statusText = document.getElementById('pengaduanStatusText');
    const pengaduanInfo = document.getElementById('pengaduanInfo');
    const historySection = document.getElementById('pengaduanHistorySection');
    
    if (!nomorPengaduan) {
        alert('Mohon masukkan nomor pengaduan');
        return false;
    }

    // Show modal
    const statusModal = new bootstrap.Modal(document.getElementById('pengaduanStatusModal'));
    statusModal.show();

    // Show loading state
    statusResult.style.display = 'block';
    statusResult.className = 'mt-3';
    statusText.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memeriksa status...';
    pengaduanInfo.style.display = 'none';
    historySection.style.display = 'none';

    // Make AJAX request
    fetch(`/pengaduan-saya/check?nomor_pengaduan=${encodeURIComponent(nomorPengaduan)}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                let statusClass = '';
                let statusIcon = '';
                
                switch(data.status) {
                    case 'diajukan':
                        statusClass = 'alert-warning';
                        statusIcon = 'fa-clock';
                        break;
                    case 'diproses':
                        statusClass = 'alert-info';
                        statusIcon = 'fa-spinner';
                        break;
                    case 'selesai':
                        statusClass = 'alert-success';
                        statusIcon = 'fa-check-circle';
                        break;
                    case 'ditolak':
                        statusClass = 'alert-danger';
                        statusIcon = 'fa-times-circle';
                        break;
                    default:
                        statusClass = 'alert-secondary';
                        statusIcon = 'fa-question-circle';
                }

                statusResult.className = `mt-3 alert ${statusClass}`;
                statusText.innerHTML = `
                    <i class="fas ${statusIcon}"></i> 
                    ${data.message}
                    ${data.details ? `<br><small class="text-muted">${data.details}</small>` : ''}
                `;

                // Show pengaduan info
                document.getElementById('pengaduanCode').innerHTML = `<a target="_blank" href="/pengaduan-saya/show/${data.pengaduan.id}">${data.pengaduan.code}</a>`;
                document.getElementById('pengaduanType').textContent = data.pengaduan.title;
                document.getElementById('pengaduanDate').textContent = data.pengaduan.created_at;
                pengaduanInfo.style.display = 'block';

                // Show history
                const historyTimeline = document.getElementById('pengaduanHistoryTimeline');
                historyTimeline.innerHTML = '';
                
                data.history.forEach(item => {
                    const statusClass = item.status.toLowerCase().replace(' ', '-');
                    const historyItem = document.createElement('div');
                    historyItem.className = `timeline-item ${statusClass}`;
                    historyItem.innerHTML = `
                        <div class="mb-1">
                            <strong>${item.status}</strong>
                            <small class="text-muted float-end">${new Intl.DateTimeFormat('id-ID', { year: 'numeric', month: 'long', day: 'numeric' }).format(new Date(item.date))}</small>
                        </div>
                        ${item.note ? `<p class="mb-0 small">${item.note}</p>` : ''}
                    `;
                    historyTimeline.appendChild(historyItem);
                });
                
                historySection.style.display = 'block';
            } else {
                statusResult.className = 'mt-3 alert alert-danger';
                statusText.innerHTML = data.message || 'Terjadi kesalahan saat memeriksa status';
                pengaduanInfo.style.display = 'none';
                historySection.style.display = 'none';
            }
        })
        .catch(error => {
            statusResult.className = 'mt-3 alert alert-danger';
            statusText.innerHTML = 'Terjadi kesalahan saat memeriksa status';
            pengaduanInfo.style.display = 'none';
            historySection.style.display = 'none';
            console.error('Error:', error);
        });

    return false;
}
</script>
