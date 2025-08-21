@extends('layouts.cms')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show d-flex justify-content-between" role="alert">
                        {{ session('error') }}
                        <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="card-body">
                    <form action="{{ route('informasi-kelurahan.update', $information->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="title">Judul <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                        id="title" name="title" value="{{ old('title', $information->title) }}" maxlength="255" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Deskripsi <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                        id="description" name="description" required>{{ old('description', $information->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="image">Gambar</label>
                                    @if($information->image)
                                        <div class="mb-2">
                                            <img src="{{ asset($information->image) }}" 
                                                alt="{{ $information->title }}" class="img-thumbnail" style="max-height: 200px">
                                        </div>
                                    @endif
                                    <div class="custom-file">
                                        <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                            id="image" name="image">
                                    </div>
                                    <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah gambar</small>
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status <span class="text-danger">*</span></label>
                                    <div class="d-flex align-items-center">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="status" name="status" 
                                                value="1" {{ old('status', $information->status) == '1' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="status" id="statusLabel">
                                                {{ old('status', $information->status) == '1' ? 'Aktif' : 'Tidak Aktif' }}
                                            </label>
                                        </div>
                                    </div>
                                    @error('status')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12 text-right">
                                <a href="{{ route('informasi-kelurahan.index') }}" class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Initialize CKEditor
    ClassicEditor
        .create(document.querySelector('#description'), {
            toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'outdent', 'indent', '|', 'blockQuote', 'insertTable', 'undo', 'redo'],
            placeholder: 'Masukkan deskripsi informasi desa/kelurahan...'
        })
        .catch(error => {
            console.error(error);
        });

    // Status toggle handler
    $('#status').on('change', function() {
        $('#statusLabel').text(this.checked ? 'Aktif' : 'Tidak Aktif');
    });
</script>
@endpush
@endsection 