@extends('layouts.cms')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                {{-- <div class="card-header">
                    <h5 class="mb-0">Tambah Jenis Permohonan</h5>
                </div> --}}
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('jenis-permohonan.update', $requestType->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="code" class="form-label">Kode</label>
                                    <input type="text" class="form-control @error('code') is-invalid @enderror" 
                                           id="code" name="code" value="{{ old('code', $requestType->code) }}" required readonly>
                                    @error('code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $requestType->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3">{{ old('description', $requestType->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="mb-3">
                            <label class="form-label">Dokumen yang Diperlukan</label>
                            <div id="requiredDocuments">
                                @if(old('required_documents'))
                                    @foreach(old('required_documents') as $index => $document)
                                    <div class="row mb-2">
                                        <div class="col-md-10">
                                            <input type="text" class="form-control @error('required_documents.'.$index) is-invalid @enderror" 
                                                   name="required_documents[]" 
                                                   value="{{ $document }}" 
                                                   placeholder="Nama Dokumen">
                                            @error('required_documents.'.$index)
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-sm btn-danger remove-document">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @endforeach
                                @else
                                    @foreach(json_decode($requestType->required_documents) ?? [] as $document)
                                    <div class="row mb-2">
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" 
                                                   name="required_documents[]" 
                                                   value="{{ $document }}" 
                                                   placeholder="Nama Dokumen">
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-sm btn-danger remove-document">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                            <button type="button" class="btn btn-secondary btn-sm" id="addDocument">
                                <i class="fas fa-plus"></i> Tambah Dokumen
                            </button>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input @error('status') is-invalid @enderror" 
                                       id="status" name="status" value="1" {{ old('status', $requestType->status) ? 'checked' : '' }}>
                                <label class="form-check-label" for="status">Status Aktif</label>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('jenis-permohonan.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        let fieldCount = {{ count((array) old('additional_fields', json_decode($requestType->additional_fields) ?? [])) }};
        let documentCount = {{ count((array) old('required_documents', json_decode($requestType->required_documents) ?? [])) }};

        // Status toggle functionality
        $('#status').change(function() {
            const label = $(this).next('label');
            if ($(this).is(':checked')) {
                label.text('Status Aktif');
            } else {
                label.text('Status Tidak Aktif');
            }
        });

        $('#addField').click(function() {
            const newField = `
                <div class="row mb-2">
                    <div class="col-md-5">
                        <input type="text" class="form-control" name="additional_fields[${fieldCount}][label]" placeholder="Label">
                    </div>
                    <div class="col-md-5">
                        <select class="form-control" name="additional_fields[${fieldCount}][type]">
                            <option value="text">Text</option>
                            <option value="number">Number</option>
                            <option value="date">Date</option>
                            <option value="select">Select</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-sm btn-danger remove-field">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;
            $('#additionalFields').append(newField);
            fieldCount++;
        });

        $('#addDocument').click(function() {
            const newDocument = `
                <div class="row mb-2">
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="required_documents[]" placeholder="Nama Dokumen">
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-sm btn-danger remove-document">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;
            $('#requiredDocuments').append(newDocument);
            documentCount++;
        });

        $(document).on('click', '.remove-field', function() {
            $(this).closest('.row').remove();
        });

        $(document).on('click', '.remove-document', function() {
            $(this).closest('.row').remove();
        });
    });
</script>
@endpush 