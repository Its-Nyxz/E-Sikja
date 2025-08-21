@extends('layouts.cms')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"></h5>
                    <div>
                        <a href="{{ route('jenis-permohonan.edit', $requestType) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('jenis-permohonan.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 200px;">Kode</th>
                                    <td>{{ $requestType->code }}</td>
                                </tr>
                                <tr>
                                    <th>Nama</th>
                                    <td>{{ $requestType->name }}</td>
                                </tr>
                                <tr>
                                    <th>Deskripsi</th>
                                    <td>{{ $requestType->description }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span class="badge bg-{{ $requestType->status ? 'success' : 'danger' }}">
                                            {{ $requestType->status ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>


                    @if($requestType->required_documents)
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6>Dokumen yang Diperlukan</h6>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Dokumen</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(json_decode($requestType->required_documents) as $index => $document)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $document }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 