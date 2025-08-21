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
                    <form action="{{ route('pengajuan-saya.store') }}" method="POST" enctype="multipart/form-data" id="requestForm">
                        @csrf
                        
                        <div class="form-group mb-3">
                            <label for="request_type_id">Jenis Surat <span class="text-danger">*</span></label>
                            <select name="request_type_id" id="request_type_id" class="form-control @error('request_type_id') is-invalid @enderror" required>
                                <option value="">Pilih Jenis Surat</option>
                                @foreach($requestTypes as $type)
                                    <option value="{{ $type->id }}" data-code="{{ $type->code }}" data-fields="{{ $type->additional_fields }}" data-documents="{{ $type->required_documents }}" {{ old('request_type_id') == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('request_type_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div id="form-container">
                            <!-- Dynamic form will be loaded here -->
                        </div>

                        <div id="loading-spinner" class="text-center d-none">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-2">Memuat form...</p>
                        </div>

                        <div class="form-group text-end">
                            <a href="{{ route('pengajuan-saya.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Buat Pengajuan</button>
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
    const loadingSpinner = document.getElementById('loading-spinner');
    const requestForm = document.getElementById('requestForm');

    // Function to toggle form elements
    function toggleFormElements(disabled) {
        const formElements = requestForm.elements;
        for (let i = 0; i < formElements.length; i++) {
            formElements[i].disabled = disabled;
        }
    }

    // Function to load form
    function loadForm(requestTypeCode) {
        if (!requestTypeCode) {
            formContainer.innerHTML = '';
            return;
        }

        // Show loading spinner and disable form
        loadingSpinner.classList.remove('d-none');
        toggleFormElements(true);

        const oldData = {{ Illuminate\Support\Js::from(old()) }};

        // Convert oldData to URLSearchParams format
        const params = new URLSearchParams(oldData);

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
