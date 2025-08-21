@extends('layouts.cms')

@section('title', 'Verifikasi Pengguna')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Detail Verifikasi Pengguna</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h5 class="border-bottom pb-2">Informasi Akun</h5>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Username</label>
                                                <p class="mb-0">{{ $user->username }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Email</label>
                                                <p class="mb-0">{{ $user->email }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">No. Telepon</label>
                                                <p class="mb-0">{{ $user->phone }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Status</label>
                                                <p class="mb-0">
                                                    @if($user->is_verified)
                                                        <span class="badge bg-success">Terverifikasi</span>
                                                    @else
                                                        <span class="badge bg-warning">Menunggu Verifikasi</span>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h5 class="border-bottom pb-2">Informasi Pribadi</h5>
                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">Nama Lengkap</div>
                                    <div class="col-md-8">{{ $user->resident->name }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">NIK</div>
                                    <div class="col-md-8">{{ $user->resident->nik }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">No. KK</div>
                                    <div class="col-md-8">{{ $user->resident->kk }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">Tempat Lahir</div>
                                    <div class="col-md-8">{{ $user->resident->pob }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">Tanggal Lahir</div>
                                    <div class="col-md-8">{{ $user->resident->dob }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">Jenis Kelamin</div>
                                    <div class="col-md-8">{{ $user->resident->gender }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">Agama</div>
                                    <div class="col-md-8">{{ $user->resident->religion }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">Status Perkawinan</div>
                                    <div class="col-md-8">{{ $user->resident->marital_status }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h5 class="border-bottom pb-2">Informasi Kontak & Domisili</h5>
                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">Email</div>
                                    <div class="col-md-8">{{ $user->email }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">Alamat</div>
                                    <div class="col-md-8">{{ $user->resident->address }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">RT</div>
                                    <div class="col-md-8">{{ $user->resident->rt }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">RW</div>
                                    <div class="col-md-8">{{ $user->resident->rw }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">Desa/Kelurahan</div>
                                    <div class="col-md-8">{{ $user->resident->village }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">Kecamatan</div>
                                    <div class="col-md-8">{{ $user->resident->district }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h5 class="border-bottom pb-2">Informasi Pendidikan & Pekerjaan</h5>
                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">Pendidikan</div>
                                    <div class="col-md-8">{{ $user->resident->education }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">Pekerjaan</div>
                                    <div class="col-md-8">{{ $user->resident->occupation }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">Kewarganegaraan</div>
                                    <div class="col-md-8">{{ $user->resident->nationality }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h5 class="border-bottom pb-2">Informasi Orang Tua</h5>
                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">Nama Ayah</div>
                                    <div class="col-md-8">{{ $user->resident->father_name ?? '-' }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4 fw-bold">Nama Ibu</div>
                                    <div class="col-md-8">{{ $user->resident->mother_name ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ redirect()->back()->getTargetUrl() }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                                {{-- <button type="button" class="btn btn-danger" onclick="rejectUser({{ $user->id }})">
                                    <i class="fas fa-times"></i> Tolak
                                </button> --}}
                                <button type="button" class="btn btn-success" onclick="verifyUser({{ $user->id }})">
                                    <i class="fas fa-check"></i> Verifikasi
                                </button>
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
    function verifyUser(userId) {
        Swal.fire({
            title: 'Verifikasi Pengguna',
            text: 'Apakah Anda yakin ingin memverifikasi pengguna ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Verifikasi',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#28a745'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `${userId}/verify`,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Pengguna berhasil diverifikasi',
                            icon: 'success'
                        }).then(() => {
                            window.location.href = '{{ route("notifikasi.index") }}';
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat memverifikasi pengguna',
                            icon: 'error'
                        });
                    }
                });
            }
        });
    }

    // function rejectUser(userId) {
    //     Swal.fire({
    //         title: 'Tolak Pengguna',
    //         text: 'Apakah Anda yakin ingin menolak pengguna ini?',
    //         icon: 'warning',
    //         showCancelButton: true,
    //         confirmButtonText: 'Ya, Tolak',
    //         cancelButtonText: 'Batal',
    //         confirmButtonColor: '#dc3545'
    //     }).then((result) => {
    //         if (result.isConfirmed) {
    //             $.ajax({
    //                 url: `/admin/users/${userId}/reject`,
    //                 type: 'POST',
    //                 data: {
    //                     _token: '{{ csrf_token() }}'
    //                 },
    //                 success: function(response) {
    //                     Swal.fire({
    //                         title: 'Berhasil!',
    //                         text: 'Pengguna berhasil ditolak',
    //                         icon: 'success'
    //                     }).then(() => {
    //                         window.location.href = '{{ route("notifikasi.index") }}';
    //                     });
    //                 },
    //                 error: function(xhr) {
    //                     Swal.fire({
    //                         title: 'Error!',
    //                         text: 'Terjadi kesalahan saat menolak pengguna',
    //                         icon: 'error'
    //                     });
    //                 }
    //             });
    //         }
    //     });
    // }
</script>
@endpush
