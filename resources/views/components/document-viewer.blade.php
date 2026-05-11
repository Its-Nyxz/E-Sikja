{{-- Secure Document Viewer Modal --}}
<div class="modal fade" id="documentViewerModal" tabindex="-1" aria-labelledby="documentViewerLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title" id="documentViewerLabel">
                    <i class="fas fa-file-image me-2 text-primary"></i>
                    <span id="docViewerTitle">Dokumen</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-3">
                <div id="docViewerLoading" class="py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Memuat...</span>
                    </div>
                    <p class="text-muted mt-2 mb-0">Memuat dokumen...</p>
                </div>
                <div id="docViewerContainer" class="doc-viewer-container" style="display: none;">
                    <img id="docViewerImage" src="" alt="Dokumen" class="doc-viewer-image">
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <small class="text-muted me-auto">
                    <i class="fas fa-shield-alt me-1"></i>Dokumen ini dilindungi dan hanya dapat dilihat melalui sistem
                </small>
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<style>
/* Document Viewer Protection Styles */
.doc-viewer-container {
    position: relative;
    overflow: hidden;
    border-radius: 8px;
    background: #f1f3f5;
    max-height: 75vh;
    overflow-y: auto;
}

.doc-viewer-image {
    max-width: 100%;
    height: auto;
    display: block;
    margin: 0 auto;
    user-select: none;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    pointer-events: none;
    -webkit-user-drag: none;
}

/* Transparent overlay to block right-click on image */
.doc-viewer-container::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 10;
    background: transparent;
}

/* Watermark overlay */
.doc-viewer-container::before {
    content: 'E-SIKJA • DOKUMEN RESMI';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) rotate(-30deg);
    font-size: 2.5rem;
    font-weight: 700;
    color: rgba(0, 0, 0, 0.04);
    white-space: nowrap;
    z-index: 11;
    pointer-events: none;
    letter-spacing: 8px;
}

#documentViewerModal .modal-content {
    border: none;
    border-radius: 12px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
}
</style>

<script>
// Document viewer protection
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('documentViewerModal');
    const viewerImage = document.getElementById('docViewerImage');
    const viewerContainer = document.getElementById('docViewerContainer');
    const viewerLoading = document.getElementById('docViewerLoading');
    const viewerTitle = document.getElementById('docViewerTitle');

    // Global function to open document viewer
    window.openDocumentViewer = function(url, title) {
        viewerTitle.textContent = title || 'Dokumen';
        viewerContainer.style.display = 'none';
        viewerLoading.style.display = 'block';
        viewerImage.src = '';

        var bsModal = new bootstrap.Modal(modal);
        bsModal.show();

        // Load image
        viewerImage.onload = function() {
            viewerLoading.style.display = 'none';
            viewerContainer.style.display = 'block';
        };
        viewerImage.onerror = function() {
            viewerLoading.innerHTML = '<div class="py-4"><i class="fas fa-exclamation-triangle text-warning fa-3x mb-3"></i><p class="text-muted">Gagal memuat dokumen</p></div>';
        };
        viewerImage.src = url;
    };

    // Block right-click on modal
    if (modal) {
        modal.addEventListener('contextmenu', function(e) {
            e.preventDefault();
            return false;
        });
    }

    // Block keyboard shortcuts for saving/printing inside modal
    document.addEventListener('keydown', function(e) {
        if (modal && modal.classList.contains('show')) {
            // Block Ctrl+S, Ctrl+P, Ctrl+Shift+I, PrintScreen
            if ((e.ctrlKey && (e.key === 's' || e.key === 'S' || e.key === 'p' || e.key === 'P')) ||
                (e.ctrlKey && e.shiftKey && (e.key === 'i' || e.key === 'I')) ||
                e.key === 'PrintScreen') {
                e.preventDefault();
                return false;
            }
        }
    });

    // Reset loading state when modal is hidden
    if (modal) {
        modal.addEventListener('hidden.bs.modal', function() {
            viewerImage.src = '';
            viewerContainer.style.display = 'none';
            viewerLoading.style.display = 'block';
            viewerLoading.innerHTML = '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Memuat...</span></div><p class="text-muted mt-2 mb-0">Memuat dokumen...</p>';
        });
    }
});
</script>
