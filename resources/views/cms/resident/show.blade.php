@extends('layouts.cms')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary"></h6>
                <div>
                    <a href="{{ route('data-masyarakat.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    @if (Auth::user()->role == 'admin')
                        <a href="{{ route('data-masyarakat.edit', $resident->id) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-header bg-primary text-white">
                            <h6 class="m-0 font-weight-bold">Data Pribadi</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="200">NIK</th>
                                    <td>{{ $resident->nik }}</td>
                                </tr>
                                <tr>
                                    <th>No. KK</th>
                                    <td>{{ $resident->kk }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Lengkap</th>
                                    <td>{{ $resident->name }}</td>
                                </tr>
                                <tr>
                                    <th>Tempat Lahir</th>
                                    <td>{{ $resident->pob }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Lahir</th>
                                    <td>{{ $resident->dob->format('d-m-Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Jenis Kelamin</th>
                                    <td>{{ $resident->gender }}</td>
                                </tr>
                                <tr>
                                    <th>Agama</th>
                                    <td>{{ $resident->religion }}</td>
                                </tr>
                                <tr>
                                    <th>Status Perkawinan</th>
                                    <td>{{ $resident->marital_status }}</td>
                                </tr>
                                <tr>
                                    <th>Pekerjaan</th>
                                    <td>{{ $resident->occupation }}</td>
                                </tr>
                                <tr>
                                    <th>Pendidikan</th>
                                    <td>{{ $resident->education }}</td>
                                </tr>
                                <tr>
                                    <th>Kewarganegaraan</th>
                                    <td>{{ $resident->nationality }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-header bg-primary text-white">
                            <h6 class="m-0 font-weight-bold">Data Alamat</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="200">Alamat</th>
                                    <td>{{ $resident->address }}</td>
                                </tr>
                                <tr>
                                    <th>RT/RW</th>
                                    <td>{{ $resident->rt }}/{{ $resident->rw }}</td>
                                </tr>
                                <tr>
                                    <th>Dusun/Lingkungan</th>
                                    <td>{{ $resident->sub_village?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Desa/Kelurahan</th>
                                    <td>{{ $resident->village }}</td>
                                </tr>
                                <tr>
                                    <th>Kecamatan</th>
                                    <td>{{ $resident->district }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h6 class="m-0 font-weight-bold">Data Orang Tua</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="200">Nama Ayah</th>
                                    <td>{{ $resident->father_name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Ibu</th>
                                    <td>{{ $resident->mother_name ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
