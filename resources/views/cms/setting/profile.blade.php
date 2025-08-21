@extends('layouts.cms')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Pengaturan {{ $title }}</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('profil-kelurahan.store') }}" method="POST">
                        @csrf
                        
                        <div class="form-group">
                            <label for="nama_instansi">Nama Instansi</label>
                            <input type="text" class="form-control @error('nama_instansi') is-invalid @enderror" 
                                id="nama_instansi" name="nama_instansi" value="{{ old('nama_instansi', $settings['profile']['nama_instansi'] ?? '') }}">
                            @error('nama_instansi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="alamat_instansi">Alamat Instansi</label>
                            <input type="text" class="form-control @error('alamat_instansi') is-invalid @enderror" 
                                id="alamat_instansi" name="alamat_instansi" value="{{ old('alamat_instansi', $settings['profile']['alamat_instansi'] ?? '') }}">
                            @error('alamat_instansi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="visi_misi">Visi & Misi</label>
                            <textarea class="form-control @error('visi_misi') is-invalid @enderror" 
                                id="visi_misi" name="visi_misi">{{ old('visi_misi', $settings['profile']['visi_misi'] ?? '') }}</textarea>
                            @error('visi_misi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="tentang_kelurahan">Tentang Kelurahan</label>
                            <textarea class="form-control @error('tentang_kelurahan') is-invalid @enderror" 
                                id="tentang_kelurahan" name="tentang_kelurahan">{{ old('tentang_kelurahan', $settings['profile']['tentang_kelurahan'] ?? '') }}</textarea>
                            @error('tentang_kelurahan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="struktur_organisasi">Struktur Organisasi</label>
                            <textarea class="form-control @error('struktur_organisasi') is-invalid @enderror" 
                                id="struktur_organisasi" name="struktur_organisasi">{{ old('struktur_organisasi', $settings['profile']['struktur_organisasi'] ?? '') }}</textarea>
                            @error('struktur_organisasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-3 text-end">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/27.1.0/classic/ckeditor.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        ClassicEditor
            .create(document.querySelector('#visi_misi'))
            .catch(error => {
                console.error(error);
            });

        ClassicEditor
            .create(document.querySelector('#tentang_kelurahan'))
            .catch(error => {
                console.error(error);
            });

        ClassicEditor
            .create(document.querySelector('#struktur_organisasi'))
            .catch(error => {
                console.error(error);
            });
    });
</script>
@endpush
@endsection