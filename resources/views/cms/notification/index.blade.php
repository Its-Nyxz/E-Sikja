@extends('layouts.cms')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-tools">
                        <form action="{{ route('notifikasi.mark-all-read') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-tool mr-2" title="Tandai Semua Dibaca">
                                <i class="fas fa-check-double"></i>
                            </button>
                        </form>
                        <div class="btn-group">
                            <button type="button" class="btn btn-tool dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-filter"></i> Filter
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <form action="{{ route('notifikasi.index') }}" method="GET" class="p-3">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="status" class="form-control form-control-sm">
                                            <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua</option>
                                            <option value="unread" {{ (request('status') == 'unread' || request('status') == null) ? 'selected' : '' }}>Belum Dibaca</option>
                                            <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Sudah Dibaca</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Tipe</label>
                                        <select name="type" class="form-control form-control-sm">
                                            <option value="all" {{ request('type') == 'all' ? 'selected' : '' }}>Semua</option>
                                            <option value="Pengajuan" {{ request('type') == 'Pengajuan' ? 'selected' : '' }}>Pengajuan</option>
                                            <option value="Pengaduan" {{ request('type') == 'Pengaduan' ? 'selected' : '' }}>Pengaduan</option>
                                            <option value="Pendaftaran" {{ request('type') == 'Pendaftaran' ? 'selected' : '' }}>Pendaftaran</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-sm btn-block">Terapkan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <tbody>
                                @forelse($notifications as $notification)
                                <tr class="{{ $notification->read_at ? '' : 'bg-light' }}">
                                    <td style="width: 2%">
                                        <div class="text-center">
                                            @if($notification->type == 'Pengajuan Surat')
                                                <i class="fas fa-envelope text-primary"></i>
                                            @elseif($notification->type == 'Pengaduan')
                                                <i class="fas fa-bullhorn text-info"></i>
                                            @elseif($notification->type == 'Pendaftaran')
                                                <i class="fas fa-user-plus text-success"></i>
                                            @else
                                                <i class="fas fa-bell text-warning"></i>
                                            @endif
                                        </div>
                                    </td>
                                    <td width="68%">
                                        <div class="d-flex flex-column">
                                            <span class="font-weight-bold">{{ $notification->title }}</span>
                                            <small class="text-muted">{{ $notification->text }}</small>
                                        </div>
                                        @if ($notification->link)
                                            <a href="{{ $notification->link }}" target="_blank" class="btn btn-outline-primary btn-sm mt-2">Lihat {{ $notification->type }}</a>
                                        @endif
                                    </td>
                                    <td style="width: 20%">
                                        <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                    </td>
                                    <td >
                                        @if(!$notification->read)
                                        <form action="{{ route('notifikasi.mark-as-read', $notification->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-tool " title="Tandai Dibaca">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4">
                                        <i class="fas fa-bell-slash text-muted mb-2" style="font-size: 2rem;"></i>
                                        <p class="text-muted">Tidak ada notifikasi</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer clearfix">
                    <div class="d-flex justify-content-center">
                        {{ $notifications->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
