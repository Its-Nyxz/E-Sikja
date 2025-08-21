<div class="container">
    <div class="row justify-content-center">
        <div class="mb-4">
            <input type="hidden" name="village_head" value="Budi Triyono S.Sos.MM">
            <input type="hidden" name="village_head_position" value="Lurah Jantiharjo">
            
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

            <h5 class="mb-4">I. Data Suami</h5>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="husband_name" class="form-label">Nama <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('husband_name') is-invalid @enderror" 
                        id="husband_name" name="husband_name" value="{{ old('husband_name', isset($requestLetter) ? $requestLetter->husband_name : '') }}" required>
                    @error('husband_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="husband_pob" class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('husband_pob') is-invalid @enderror" 
                        id="husband_pob" name="husband_pob" value="{{ old('husband_pob', isset($requestLetter) ? $requestLetter->husband_pob : '') }}" required>
                    @error('husband_pob')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label for="husband_dob" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('husband_dob') is-invalid @enderror" 
                        id="husband_dob" name="husband_dob" value="{{ old('husband_dob', isset($requestLetter->husband_dob) ? date('Y-m-d', strtotime($requestLetter->husband_dob)) : '') }}" required>
                    @error('husband_dob')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label for="husband_job" class="form-label">Pekerjaan <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('husband_job') is-invalid @enderror" 
                        id="husband_job" name="husband_job" value="{{ old('husband_job', isset($requestLetter) ? $requestLetter->husband_job : '') }}" required>
                    @error('husband_job')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="husband_gender" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                    <select class="form-select @error('husband_gender') is-invalid @enderror" 
                        id="husband_gender" name="husband_gender" required>
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="Laki-laki" {{ old('husband_gender', isset($requestLetter) ? $requestLetter->husband_gender : '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    </select>
                    @error('husband_gender')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="husband_religion" class="form-label">Agama <span class="text-danger">*</span></label>
                    <select class="form-select @error('husband_religion') is-invalid @enderror" 
                        id="husband_religion" name="husband_religion" required>
                        <option value="">Pilih Agama</option>
                        <option value="Islam" {{ old('husband_religion', isset($requestLetter) ? $requestLetter->husband_religion : '') == 'Islam' ? 'selected' : '' }}>Islam</option>
                        <option value="Kristen" {{ old('husband_religion', isset($requestLetter) ? $requestLetter->husband_religion : '') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                        <option value="Katolik" {{ old('husband_religion', isset($requestLetter) ? $requestLetter->husband_religion : '') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                        <option value="Hindu" {{ old('husband_religion', isset($requestLetter) ? $requestLetter->husband_religion : '') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                        <option value="Buddha" {{ old('husband_religion', isset($requestLetter) ? $requestLetter->husband_religion : '') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                        <option value="Konghucu" {{ old('husband_religion', isset($requestLetter) ? $requestLetter->husband_religion : '') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                    </select>
                    @error('husband_religion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="husband_address" class="form-label">Alamat <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('husband_address') is-invalid @enderror" 
                        id="husband_address" name="husband_address" rows="3" required>{{ old('husband_address', isset($requestLetter) ? $requestLetter->husband_address : '') }}</textarea>
                    @error('husband_address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <h5 class="mb-4 mt-4">II. Data Istri</h5>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="wife_name" class="form-label">Nama <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('wife_name') is-invalid @enderror" 
                        id="wife_name" name="wife_name" value="{{ old('wife_name', isset($requestLetter) ? $requestLetter->wife_name : '') }}" required>
                    @error('wife_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="wife_pob" class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('wife_pob') is-invalid @enderror" 
                        id="wife_pob" name="wife_pob" value="{{ old('wife_pob', isset($requestLetter) ? $requestLetter->wife_pob : '') }}" required>
                    @error('wife_pob')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label for="wife_dob" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('wife_dob') is-invalid @enderror" 
                        id="wife_dob" name="wife_dob" value="{{ old('wife_dob', isset($requestLetter->wife_dob) ? date('Y-m-d', strtotime($requestLetter->wife_dob)) : '') }}" required>
                    @error('wife_dob')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label for="wife_job" class="form-label">Pekerjaan <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('wife_job') is-invalid @enderror" 
                        id="wife_job" name="wife_job" value="{{ old('wife_job', isset($requestLetter) ? $requestLetter->wife_job : '') }}" required>
                    @error('wife_job')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="wife_gender" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                    <select class="form-select @error('wife_gender') is-invalid @enderror" 
                        id="wife_gender" name="wife_gender" required>
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="Perempuan" {{ old('wife_gender', isset($requestLetter) ? $requestLetter->wife_gender : '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('wife_gender')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="wife_religion" class="form-label">Agama <span class="text-danger">*</span></label>
                    <select class="form-select @error('wife_religion') is-invalid @enderror" 
                        id="wife_religion" name="wife_religion" required>
                        <option value="">Pilih Agama</option>
                        <option value="Islam" {{ old('wife_religion', isset($requestLetter) ? $requestLetter->wife_religion : '') == 'Islam' ? 'selected' : '' }}>Islam</option>
                        <option value="Kristen" {{ old('wife_religion', isset($requestLetter) ? $requestLetter->wife_religion : '') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                        <option value="Katolik" {{ old('wife_religion', isset($requestLetter) ? $requestLetter->wife_religion : '') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                        <option value="Hindu" {{ old('wife_religion', isset($requestLetter) ? $requestLetter->wife_religion : '') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                        <option value="Buddha" {{ old('wife_religion', isset($requestLetter) ? $requestLetter->wife_religion : '') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                        <option value="Konghucu" {{ old('wife_religion', isset($requestLetter) ? $requestLetter->wife_religion : '') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                    </select>
                    @error('wife_religion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="wife_address" class="form-label">Alamat <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('wife_address') is-invalid @enderror" 
                        id="wife_address" name="wife_address" rows="3" required>{{ old('wife_address', isset($requestLetter) ? $requestLetter->wife_address : '') }}</textarea>
                    @error('wife_address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="marriage_place" class="form-label">Tempat Pernikahan <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('marriage_place') is-invalid @enderror" 
                        id="marriage_place" name="marriage_place" value="{{ old('marriage_place', isset($requestLetter) ? $requestLetter->marriage_place : '') }}" required>
                    @error('marriage_place')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="marriage_date" class="form-label">Tanggal Pernikahan <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('marriage_date') is-invalid @enderror" 
                        id="marriage_date" name="marriage_date" value="{{ old('marriage_date', isset($requestLetter->marriage_date) ? date('Y-m-d', strtotime($requestLetter->marriage_date)) : '') }}" required>
                    @error('marriage_date')
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