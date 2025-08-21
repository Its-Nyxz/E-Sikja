@extends('layouts.cms')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title"></h3>
                    <a href="{{ route('pengajuan-saya.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('pengajuan-saya.update', $requestLetter->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group mb-3">
                            <input type="hidden" name="id" id="id" value="{{ $requestLetter->id }}">
                            
                            <label for="request_type_id">Jenis Surat <span class="text-danger">*</span></label>
                            <select name="request_type_id" id="request_type_id" class="form-control @error('request_type_id') is-invalid @enderror" required>
                                @if(isset($requestLetter))
                                <option value="{{ $requestLetter->request_type_id }}" selected data-code="{{ $requestLetter->requestType->code }}" data-fields="{{ $requestLetter->requestType->additional_fields }}" data-documents="{{ $requestLetter->requestType->required_documents }}">
                                    {{ $requestLetter->requestType->name }}
                                </option>
                                @else
                                <option value="">Pilih Jenis Surat</option>
                                    @foreach($requestTypes as $type)
                                        <option value="{{ $type->id }}" data-code="{{ $type->code }}" data-fields="{{ $type->additional_fields }}" data-documents="{{ $type->required_documents }}" {{ old('request_type_id') == $type->id ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            @error('request_type_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div id="form-container">
                            <!-- Dynamic form will be loaded here -->
                        </div>

                        <div class="form-group text-end">
                            <a href="{{ route('pengajuan-saya.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Update Pengajuan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const requestTypeSelect = document.getElementById('request_type_id');
    const formContainer = document.getElementById('form-container');

    // Function to load form
    function loadForm(requestTypeCode) {
        if (!requestTypeCode) {
            formContainer.innerHTML = '';
            return;
        }

        const oldData = {{ Illuminate\Support\Js::from(old()) }};
        const requestData = {{ Illuminate\Support\Js::from($requestLetter->toArray()) }};

        // Merge old data with request data
        const mergedData = { id: requestData.id, ...oldData };

        // Convert mergedData to URLSearchParams format
        const params = new URLSearchParams(mergedData);

        // Load the specific form view based on request type code
        fetch(`/pengajuan-saya/form/${requestTypeCode}?${params.toString()}`, {
            method: 'GET'
        })
        .then(response => response.text())
        .then(html => {
            formContainer.innerHTML = html;
        })
        .catch(error => {
            console.error('Error loading form:', error);
            formContainer.innerHTML = '<div class="alert alert-danger">Error loading form. Please try again.</div>';
        })
        .finally(() => {
            // Hide loading spinner and enable form
            loadingSpinner.classList.add('d-none');
            toggleFormElements(false);
        });
    }

    // Load form on change
    requestTypeSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const requestTypeCode = selectedOption.dataset.code;
        loadForm(requestTypeCode);
    });

    // Load form on page load if there's a selected value
    if (requestTypeSelect.value) {
        const selectedOption = requestTypeSelect.options[requestTypeSelect.selectedIndex];
        const requestTypeCode = selectedOption.dataset.code;
        loadForm(requestTypeCode);
    }
});
</script>
@endpush
@endsection
