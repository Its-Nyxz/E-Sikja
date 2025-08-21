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
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">Nama <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                        id="name" name="name" value="{{ old('name', isset($requestLetter) ? $requestLetter->name : ($resident->name ?? '')) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="nik" class="form-label">NIK <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nik') is-invalid @enderror" 
                        id="nik" name="nik" value="{{ old('nik', isset($requestLetter) ? $requestLetter->nik : ($resident->nik ?? '')) }}" required>
                    @error('nik')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
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

                <div class="col-md-6 mb-3">
                    <label for="pob" class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('pob') is-invalid @enderror" 
                        id="pob" name="pob" value="{{ old('pob', isset($requestLetter) ? $requestLetter->pob : ($resident->pob ?? '')) }}" required>
                    @error('pob')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="dob" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('dob') is-invalid @enderror" 
                        id="dob" name="dob" value="{{ old('dob', isset($requestLetter->dob) ? date('Y-m-d', strtotime($requestLetter->dob)) : (isset($resident->dob) ? date('Y-m-d', strtotime($resident->dob)) : '')) }}" required>
                    @error('dob')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="address" class="form-label">Alamat <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('address') is-invalid @enderror" 
                        id="address" name="address" rows="3" required>{{ old('address', isset($requestLetter) ? $requestLetter->address : ($resident->address ?? '')) }}</textarea>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="mb-3">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="business_name" class="form-label">Nama Usaha <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('business_name') is-invalid @enderror" 
                        id="business_name" name="business_name" value="{{ old('business_name', isset($requestLetter) ? $requestLetter->business_name : '') }}" required>
                    @error('business_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="business_start_date" class="form-label">Mulai Usaha Sejak <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('business_start_date') is-invalid @enderror" 
                        id="business_start_date" name="business_start_date" value="{{ old('business_start_date', isset($requestLetter) ? $requestLetter->business_start_date : '') }}" required>
                    @error('business_start_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="business_address" class="form-label">Alamat Usaha <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('business_address') is-invalid @enderror" 
                        id="business_address" name="business_address" rows="3" required>{{ old('business_address', isset($requestLetter) ? $requestLetter->business_address : '') }}</textarea>
                    @error('business_address')
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


