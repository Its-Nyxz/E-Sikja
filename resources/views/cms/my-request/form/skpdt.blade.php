<div class="container">
    <div class="row justify-content-center">
        <div class="mb-4">
            <div class="row">
                @if (isset($requestLetter))
                    <div class="col-md-12 mb-3">
                        <label for="code" class="form-label">No. Request</label>
                        <input type="text" class="form-control @error('code') is-invalid @enderror" 
                            id="code" name="code" value="{{ old('code', isset($requestLetter) ? $requestLetter->code : '') }}" disabled>
                        @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                @endif
                <div class="col-md-12 mb-3">
                    <label for="name" class="form-label">Nama <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                        id="name" name="name" value="{{ old('name', isset($requestLetter) ? $requestLetter->name : ($resident->name ?? '')) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="pob" class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('pob') is-invalid @enderror" 
                        id="pob" name="pob" value="{{ old('pob', isset($requestLetter) ? $requestLetter->pob : ($resident->pob ?? '')) }}" required>
                    @error('pob')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label for="dob" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('dob') is-invalid @enderror" 
                        id="dob" name="dob" value="{{ old('dob', isset($requestLetter->dob) ? date('Y-m-d', strtotime($requestLetter->dob)) : (isset($resident->dob) ? date('Y-m-d', strtotime($resident->dob)) : '')) }}" required>
                    @error('dob')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label for="nik" class="form-label">NIK <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nik') is-invalid @enderror" 
                        id="nik" name="nik" value="{{ old('nik', isset($requestLetter) ? $requestLetter->nik : ($resident->nik ?? '')) }}" required>
                    @error('nik')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="occupation" class="form-label">Pekerjaan <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('occupation') is-invalid @enderror" 
                        id="occupation" name="occupation" value="{{ old('occupation', isset($requestLetter) ? $requestLetter->occupation : ($resident->occupation ?? '')) }}" required>
                    @error('occupation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label for="gender" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                    <select class="form-select @error('gender') is-invalid @enderror" 
                        id="gender" name="gender" required>
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="Laki-laki" {{ old('gender', isset($requestLetter) ? $requestLetter->gender : ($resident->gender ?? '')) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('gender', isset($requestLetter) ? $requestLetter->gender : ($resident->gender ?? '')) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('gender')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label for="religion" class="form-label">Agama <span class="text-danger">*</span></label>
                    <select class="form-select @error('religion') is-invalid @enderror" 
                        id="religion" name="religion" required>
                        <option value="">Pilih Agama</option>
                        <option value="Islam" {{ old('religion', isset($requestLetter) ? $requestLetter->religion : ($resident->religion ?? '')) == 'Islam' ? 'selected' : '' }}>Islam</option>
                        <option value="Kristen" {{ old('religion', isset($requestLetter) ? $requestLetter->religion : ($resident->religion ?? '')) == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                        <option value="Katolik" {{ old('religion', isset($requestLetter) ? $requestLetter->religion : ($resident->religion ?? '')) == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                        <option value="Hindu" {{ old('religion', isset($requestLetter) ? $requestLetter->religion : ($resident->religion ?? '')) == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                        <option value="Buddha" {{ old('religion', isset($requestLetter) ? $requestLetter->religion : ($resident->religion ?? '')) == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                        <option value="Konghucu" {{ old('religion', isset($requestLetter) ? $requestLetter->religion : ($resident->religion ?? '')) == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                    </select>
                    @error('religion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="marital_status" class="form-label">Status Perkawinan <span class="text-danger">*</span></label>
                    <select class="form-select @error('marital_status') is-invalid @enderror" 
                        id="marital_status" name="marital_status" required>
                        <option value="">Pilih Status Perkawinan</option>
                        <option value="Belum Kawin" {{ old('marital_status', isset($requestLetter) ? $requestLetter->marital_status : ($resident->marital_status ?? '')) == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                        <option value="Kawin" {{ old('marital_status', isset($requestLetter) ? $requestLetter->marital_status : ($resident->marital_status ?? '')) == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                        <option value="Cerai Hidup" {{ old('marital_status', isset($requestLetter) ? $requestLetter->marital_status : ($resident->marital_status ?? '')) == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                        <option value="Cerai Mati" {{ old('marital_status', isset($requestLetter) ? $requestLetter->marital_status : ($resident->marital_status ?? '')) == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                    </select>
                    @error('marital_status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="followers_count" class="form-label">Pengikut Sejumlah <span class="text-danger">*</span></label>
                    <input type="number" min="0" class="form-control @error('followers_count') is-invalid @enderror" 
                        id="followers_count" name="followers_count" value="{{ old('followers_count', isset($requestLetter) ? $requestLetter->followers_count : '') }}" required>
                    @error('followers_count')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="current_address" class="form-label">Alamat Asal <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('current_address') is-invalid @enderror" 
                        id="current_address" name="current_address" rows="3" required>{{ old('current_address', isset($requestLetter) ? $requestLetter->current_address : ($resident->address ?? '')) }}</textarea>
                    @error('current_address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="destination_address" class="form-label">Pindah Ke <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('destination_address') is-invalid @enderror" 
                        id="destination_address" name="destination_address" rows="3" required>{{ old('destination_address', isset($requestLetter) ? $requestLetter->destination_address : '') }}</textarea>
                    @error('destination_address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="moving_reason" class="form-label">Alasan Pindah <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('moving_reason') is-invalid @enderror" 
                        id="moving_reason" name="moving_reason" rows="3" required>{{ old('moving_reason', isset($requestLetter) ? $requestLetter->moving_reason : '') }}</textarea>
                    @error('moving_reason')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="mb-4">
            <h5 class="mb-4"><b>Dokumen yang Diperlukan</b></h5>
            @if($requestType->required_documents)
                @foreach(json_decode($requestType->required_documents) as $index => $document)
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label for="document_{{ str_replace(' ', '_', strtolower($document)) }}" class="form-label">{{ $document }} @if(!str_contains($document, '(Optional)') && !isset($requestLetter)) <span class="text-danger">*</span> @endif</label>
                        @if(isset($documents))
                            @php
                                $documentFile = collect($documents)->first(function($doc) use ($document) {
                                    return $doc->name === $document;
                                });
                            @endphp
                            @if($documentFile)
                                <div class="mb-2">
                                    <a href="{{ asset( $documentFile->url) }}" target="_blank" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> Lihat File
                                    </a>
                                </div>
                            @endif
                        @endif
                        <input type="file" class="form-control @error('documents.'.str_replace(' ', '_', strtolower($document))) is-invalid @enderror" 
                            id="document_{{ str_replace(' ', '_', strtolower($document)) }}" 
                            name="documents[{{ $index }}]" 
                            {{ (str_contains($document, '(Optional)') || isset($requestLetter)) ? '' : 'required' }}>
                        @error('documents.'.str_replace(' ', '_', strtolower($document)))
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>
</div>