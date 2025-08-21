<div class="container">
    <div class="row justify-content-center">
        <div class="mb-4">
            <input type="hidden" name="village_head" value="Budi Triyono S.Sos.MM">
            <input type="hidden" name="village_head_position" value="Lurah Jantiharjo">
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
            </div>

            <h5 class="mb-4">Data Ibu</h5>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="mother_name" class="form-label">Nama Ibu <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('mother_name') is-invalid @enderror" 
                        id="mother_name" name="mother_name" value="{{ old('mother_name', isset($requestLetter) ? $requestLetter->mother_name : '') }}" required>
                    @error('mother_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label for="mother_age" class="form-label">Umur Ibu <span class="text-danger">*</span></label>
                    <input type="number" min="0" class="form-control @error('mother_age') is-invalid @enderror" 
                        id="mother_age" name="mother_age" value="{{ old('mother_age', isset($requestLetter) ? $requestLetter->mother_age : '') }}" required>
                    @error('mother_age')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-8 mb-3">
                    <label for="mother_occupation" class="form-label">Pekerjaan Ibu <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('mother_occupation') is-invalid @enderror" 
                        id="mother_occupation" name="mother_occupation" value="{{ old('mother_occupation', isset($requestLetter) ? $requestLetter->mother_occupation : '') }}" required>
                    @error('mother_occupation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <h5 class="mb-4">Data Ayah</h5>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="father_name" class="form-label">Nama Ayah <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('father_name') is-invalid @enderror" 
                        id="father_name" name="father_name" value="{{ old('father_name', isset($requestLetter) ? $requestLetter->father_name : '') }}" required>
                    @error('father_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label for="father_age" class="form-label">Umur Ayah <span class="text-danger">*</span></label>
                    <input type="number" min="0" class="form-control @error('father_age') is-invalid @enderror" 
                        id="father_age" name="father_age" value="{{ old('father_age', isset($requestLetter) ? $requestLetter->father_age : '') }}" required>
                    @error('father_age')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-8 mb-3">
                    <label for="father_occupation" class="form-label">Pekerjaan Ayah <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('father_occupation') is-invalid @enderror" 
                        id="father_occupation" name="father_occupation" value="{{ old('father_occupation', isset($requestLetter) ? $requestLetter->father_occupation : '') }}" required>
                    @error('father_occupation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="address" class="form-label">Alamat <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('address') is-invalid @enderror" 
                        id="address" name="address" rows="3" required>{{ old('address', isset($requestLetter) ? $requestLetter->address : '') }}</textarea>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <h5 class="mb-4">Data Kelahiran</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="birth_date" class="form-label">Hari/Tanggal Lahir <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('birth_date') is-invalid @enderror" 
                        id="birth_date" name="birth_date" value="{{ old('birth_date', isset($requestLetter) ? date('Y-m-d', strtotime($requestLetter->birth_date)) : '') }}" required>
                    @error('birth_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="birth_time" class="form-label">Jam Lahir <span class="text-danger">*</span></label>
                    <input type="time" class="form-control @error('birth_time') is-invalid @enderror" 
                        id="birth_time" name="birth_time" value="{{ old('birth_time', isset($requestLetter) ? $requestLetter->birth_time : '') }}" required>
                    @error('birth_time')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-12 mb-3">
                    <label for="child_name" class="form-label">Nama Anak <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('child_name') is-invalid @enderror" 
                        id="child_name" name="child_name" value="{{ old('child_name', isset($requestLetter) ? $requestLetter->child_name : '') }}" required>
                    @error('child_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="child_gender" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                    <select class="form-select @error('child_gender') is-invalid @enderror" 
                        id="child_gender" name="child_gender" required>
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="Laki-laki" {{ old('child_gender', isset($requestLetter) ? $requestLetter->child_gender : '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('child_gender', isset($requestLetter) ? $requestLetter->child_gender : '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('child_gender')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="birth_weight" class="form-label">Berat Badan (kg) <span class="text-danger">*</span></label>
                    <input type="number" min="0" step="0.01" class="form-control @error('birth_weight') is-invalid @enderror" 
                        id="birth_weight" name="birth_weight" value="{{ old('birth_weight', isset($requestLetter) ? $requestLetter->birth_weight : '') }}" required>
                    @error('birth_weight')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="birth_length" class="form-label">Panjang Badan (cm) <span class="text-danger">*</span></label>
                    <input type="number" min="0" step="0.01" class="form-control @error('birth_length') is-invalid @enderror" 
                        id="birth_length" name="birth_length" value="{{ old('birth_length', isset($requestLetter) ? $requestLetter->birth_length : '') }}" required>
                    @error('birth_length')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="birth_place" class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('birth_place') is-invalid @enderror" 
                        id="birth_place" name="birth_place" value="{{ old('birth_place', isset($requestLetter) ? $requestLetter->birth_place : '') }}" required>
                    @error('birth_place')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="child_order" class="form-label">Anak Ke <span class="text-danger">*</span></label>
                    <input type="number" min="0" class="form-control @error('child_order') is-invalid @enderror" 
                        id="child_order" name="child_order" value="{{ old('child_order', isset($requestLetter) ? $requestLetter->child_order : '') }}" required>
                    @error('child_order')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="child_religion" class="form-label">Agama <span class="text-danger">*</span></label>
                    <select class="form-select @error('child_religion') is-invalid @enderror" 
                        id="child_religion" name="child_religion" required>
                        <option value="">Pilih Agama</option>
                        <option value="Islam" {{ old('child_religion', isset($requestLetter) ? $requestLetter->child_religion : '') == 'Islam' ? 'selected' : '' }}>Islam</option>
                        <option value="Kristen" {{ old('child_religion', isset($requestLetter) ? $requestLetter->child_religion : '') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                        <option value="Katolik" {{ old('child_religion', isset($requestLetter) ? $requestLetter->child_religion : '') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                        <option value="Hindu" {{ old('child_religion', isset($requestLetter) ? $requestLetter->child_religion : '') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                        <option value="Buddha" {{ old('child_religion', isset($requestLetter) ? $requestLetter->child_religion : '') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                        <option value="Konghucu" {{ old('child_religion', isset($requestLetter) ? $requestLetter->child_religion : '') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                    </select>
                    @error('child_religion')
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