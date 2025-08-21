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

            <h5 class="mb-4">Data Almarhum/Almarhumah</h5>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="deceased_name" class="form-label">Nama <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('deceased_name') is-invalid @enderror" 
                        id="deceased_name" name="deceased_name" value="{{ old('deceased_name', isset($requestLetter) ? $requestLetter->deceased_name : '') }}" required>
                    @error('deceased_name')
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
                    <label for="birth_date" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('birth_date') is-invalid @enderror" 
                        id="birth_date" name="birth_date" value="{{ old('birth_date', isset($requestLetter) ? date('Y-m-d', strtotime($requestLetter->birth_date)) : '') }}" required>
                    @error('birth_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-12 mb-3">
                    <label for="occupation" class="form-label">Pekerjaan <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('occupation') is-invalid @enderror" 
                        id="occupation" name="occupation" value="{{ old('occupation', isset($requestLetter) ? $requestLetter->occupation : '') }}" required>
                    @error('occupation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="gender" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                    <select class="form-select @error('gender') is-invalid @enderror" 
                        id="gender" name="gender" required>
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="Laki-laki" {{ old('gender', isset($requestLetter) ? $requestLetter->gender : '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('gender', isset($requestLetter) ? $requestLetter->gender : '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('gender')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="religion" class="form-label">Agama <span class="text-danger">*</span></label>
                    <select class="form-select @error('religion') is-invalid @enderror" 
                        id="religion" name="religion" required>
                        <option value="">Pilih Agama</option>
                        <option value="Islam" {{ old('religion', isset($requestLetter) ? $requestLetter->religion : '') == 'Islam' ? 'selected' : '' }}>Islam</option>
                        <option value="Kristen" {{ old('religion', isset($requestLetter) ? $requestLetter->religion : '') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                        <option value="Katolik" {{ old('religion', isset($requestLetter) ? $requestLetter->religion : '') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                        <option value="Hindu" {{ old('religion', isset($requestLetter) ? $requestLetter->religion : '') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                        <option value="Buddha" {{ old('religion', isset($requestLetter) ? $requestLetter->religion : '') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                        <option value="Konghucu" {{ old('religion', isset($requestLetter) ? $requestLetter->religion : '') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                    </select>
                    @error('religion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-12 mb-3">
                    <label for="address" class="form-label">Alamat <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('address') is-invalid @enderror" 
                        id="address" name="address" rows="3" required>{{ old('address', isset($requestLetter) ? $requestLetter->address : '') }}</textarea>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <h5 class="mb-4">Data Kematian</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="death_date" class="form-label">Hari/Tanggal Meninggal <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('death_date') is-invalid @enderror" 
                        id="death_date" name="death_date" value="{{ old('death_date', isset($requestLetter) ? date('Y-m-d', strtotime($requestLetter->death_date)) : '') }}" required>
                    @error('death_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="death_place" class="form-label">Tempat Kematian <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('death_place') is-invalid @enderror" 
                        id="death_place" name="death_place" value="{{ old('death_place', isset($requestLetter) ? $requestLetter->death_place : '') }}" required>
                    @error('death_place')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-12 mb-3">
                    <label for="death_cause" class="form-label">Sebab Kematian <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('death_cause') is-invalid @enderror" 
                        id="death_cause" name="death_cause" rows="3" required>{{ old('death_cause', isset($requestLetter) ? $requestLetter->death_cause : '') }}</textarea>
                    @error('death_cause')
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