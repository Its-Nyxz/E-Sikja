@extends('layouts.cms')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Kategori Pengaturan</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <a href="#umum" class="list-group-item list-group-item-action active" data-bs-toggle="list">
                            <i class="fas fa-cog me-2"></i> Umum
                        </a>
                        <a href="#logo" class="list-group-item list-group-item-action" data-bs-toggle="list">
                            <i class="fas fa-image me-2"></i> Logo & Gambar
                        </a>
                        <a href="#ttd" class="list-group-item list-group-item-action" data-bs-toggle="list">
                            <i class="fas fa-signature me-2"></i> Tanda Tangan & Cap
                        </a>
                        <a href="#kontak" class="list-group-item list-group-item-action" data-bs-toggle="list">
                            <i class="fas fa-phone me-2"></i> Kontak
                        </a>
                        <a href="#sosmed" class="list-group-item list-group-item-action" data-bs-toggle="list">
                            <i class="fas fa-share-alt me-2"></i> Media Sosial
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Pengaturan Website</h5>
                </div>
                <div class="card-body">
                    <form id="settingsForm" method="POST" action="{{ route('settings.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="tab-content">
                            <!-- Tab Umum -->
                            <div class="tab-pane fade show active" id="umum">
                                <div class="mb-3">
                                    <label for="website_name" class="form-label">Nama Website</label>
                                    <input type="text" class="form-control" id="website_name" name="website_name" value="{{ $settings['website_name'] ?? '' }}">
                                </div>
                                <div class="mb-3">
                                    <label for="website_description" class="form-label">Deskripsi Website</label>
                                    <textarea class="form-control" id="website_description" name="website_description" rows="3">{{ $settings['website_description'] ?? '' }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ $settings['email'] ?? '' }}">
                                </div>
                            </div>

                            <!-- Tab Logo & Gambar -->
                            <div class="tab-pane fade" id="logo">
                                <div class="mb-3">
                                    <label for="logo" class="form-label">Logo Website</label>
                                    <input type="file" class="form-control" id="logo" name="logo">
                                    @if(isset($settings['logo']))
                                        <img src="{{ asset('setting/' . $settings['logo']) }}" alt="Logo" class="mt-2" style="max-height: 100px;">
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="favicon" class="form-label">Favicon</label>
                                    <input type="file" class="form-control" id="favicon" name="favicon">
                                    @if(isset($settings['favicon']))
                                        <img src="{{ asset('setting/' . $settings['favicon']) }}" alt="Favicon" class="mt-2" style="max-height: 32px;">
                                    @endif
                                </div>
                            </div>

                            <!-- Tab Tanda Tangan & Cap -->
                            <div class="tab-pane fade" id="ttd">
                                <div class="mb-3">
                                    <label for="ttd_lurah" class="form-label">Tanda Tangan Lurah</label>
                                    <input type="file" class="form-control" id="ttd_lurah" name="ttd_lurah">
                                    @if(isset($settings['ttd_lurah']))
                                        <img src="{{ asset('setting/' . $settings['ttd_lurah']) }}" alt="Tanda Tangan Lurah" class="mt-2" style="max-height: 100px;">
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="cap_lurah" class="form-label">Cap Lurah</label>
                                    <input type="file" class="form-control" id="cap_lurah" name="cap_lurah">
                                    @if(isset($settings['cap_lurah']))
                                        <img src="{{ asset('setting/' . $settings['cap_lurah']) }}" alt="Cap Lurah" class="mt-2" style="max-height: 100px;">
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="nama_lurah" class="form-label">Nama Lurah</label>
                                    <input type="text" class="form-control" id="nama_lurah" name="nama_lurah" value="{{ $settings['nama_lurah'] ?? '' }}">
                                </div>
                                <div class="mb-3">
                                    <label for="nip_lurah" class="form-label">NIP Lurah</label>
                                    <input type="text" class="form-control" id="nip_lurah" name="nip_lurah" value="{{ $settings['nip_lurah'] ?? '' }}">
                                </div>
                            </div>

                            <!-- Tab Kontak -->
                            <div class="tab-pane fade" id="kontak">
                                <div class="mb-3">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <textarea class="form-control" id="alamat" name="alamat" rows="3">{{ $settings['alamat'] ?? '' }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="telepon" class="form-label">Telepon</label>
                                    <input type="text" class="form-control" id="telepon" name="telepon" value="{{ $settings['telepon'] ?? '' }}">
                                </div>
                                <div class="mb-3">
                                    <label for="whatsapp" class="form-label">WhatsApp</label>
                                    <input type="text" class="form-control" id="whatsapp" name="whatsapp" value="{{ $settings['whatsapp'] ?? '' }}">
                                </div>
                            </div>

                            <!-- Tab Media Sosial -->
                            <div class="tab-pane fade" id="sosmed">
                                <div class="mb-3">
                                    <label for="facebook" class="form-label">Facebook</label>
                                    <input type="url" class="form-control" id="facebook" name="facebook" value="{{ $settings['facebook'] ?? '' }}">
                                </div>
                                <div class="mb-3">
                                    <label for="instagram" class="form-label">Instagram</label>
                                    <input type="url" class="form-control" id="instagram" name="instagram" value="{{ $settings['instagram'] ?? '' }}">
                                </div>
                                <div class="mb-3">
                                    <label for="twitter" class="form-label">Twitter</label>
                                    <input type="url" class="form-control" id="twitter" name="twitter" value="{{ $settings['twitter'] ?? '' }}">
                                </div>
                                <div class="mb-3">
                                    <label for="youtube" class="form-label">YouTube</label>
                                    <input type="url" class="form-control" id="youtube" name="youtube" value="{{ $settings['youtube'] ?? '' }}">
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // Handle form submission
        $('#settingsForm').on('submit', function(e) {
            e.preventDefault();
            
            var formData = new FormData(this);
            
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if(response.success) {
                        Toast.fire({
                            icon: 'success',
                            title: 'Pengaturan berhasil disimpan'
                        });
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: 'Terjadi kesalahan saat menyimpan pengaturan'
                        });
                    }
                },
                error: function(xhr) {
                    Toast.fire({
                            icon: 'error',
                            title: 'Terjadi kesalahan saat menyimpan pengaturan'
                        });
                }
            });
        });
    });
</script>
@endpush
@endsection