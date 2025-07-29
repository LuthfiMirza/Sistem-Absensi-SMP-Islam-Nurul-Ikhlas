<div>
    <form wire:submit.prevent="save" method="post" novalidate enctype="multipart/form-data">
        @include('partials.alerts')

        <!-- Permission Type Selection -->
        <div class="mb-4">
            <label class="form-label fw-bold">Jenis Izin</label>
            <div class="row">
                <div class="col-md-6">
                    <div class="permission-type-card {{ $type == 'same_day' ? 'selected' : '' }}" 
                         wire:click="$set('type', 'same_day')">
                        <div class="card-body text-center">
                            <i class="fas fa-clock fa-2x text-primary mb-2"></i>
                            <h6>Izin Hari yang Sama</h6>
                            <p class="text-muted small mb-0">Datang terlambat atau pulang lebih cepat</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="permission-type-card {{ $type == 'leave' ? 'selected' : '' }}" 
                         wire:click="$set('type', 'leave')">
                        <div class="card-body text-center">
                            <i class="fas fa-calendar-times fa-2x text-success mb-2"></i>
                            <h6>Izin Cuti</h6>
                            <p class="text-muted small mb-0">Tidak masuk beberapa hari</p>
                        </div>
                    </div>
                </div>
            </div>
            @error('type') <div class="text-danger mt-2">{{ $message }}</div> @enderror
        </div>

        <!-- Same Day Permission Fields -->
        @if($type === 'same_day')
        <div class="card border-primary mb-4">
            <div class="card-header bg-primary text-white">
                <h6 class="mb-0"><i class="fas fa-clock me-2"></i>Detail Izin Hari yang Sama</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <label for="late_arrival_time" class="form-label">Jam Datang Terlambat (Opsional)</label>
                        <input type="time" 
                               class="form-control @error('late_arrival_time') is-invalid @enderror" 
                               id="late_arrival_time" 
                               wire:model.defer="late_arrival_time">
                        <div class="form-text">Kosongkan jika tidak datang terlambat</div>
                        @error('late_arrival_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="early_departure_time" class="form-label">Jam Pulang Lebih Cepat (Opsional)</label>
                        <input type="time" 
                               class="form-control @error('early_departure_time') is-invalid @enderror" 
                               id="early_departure_time" 
                               wire:model.defer="early_departure_time">
                        <div class="form-text">Kosongkan jika tidak pulang lebih cepat</div>
                        @error('early_departure_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Leave Permission Fields -->
        @if($type === 'leave')
        <div class="card border-success mb-4">
            <div class="card-header bg-success text-white">
                <h6 class="mb-0"><i class="fas fa-calendar-times me-2"></i>Detail Izin Cuti</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <label for="leave_start_date" class="form-label">Tanggal Mulai Cuti</label>
                        <input type="date" 
                               class="form-control @error('leave_start_date') is-invalid @enderror" 
                               id="leave_start_date" 
                               wire:model.defer="leave_start_date">
                        @error('leave_start_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="leave_end_date" class="form-label">Tanggal Selesai Cuti</label>
                        <input type="date" 
                               class="form-control @error('leave_end_date') is-invalid @enderror" 
                               id="leave_end_date" 
                               wire:model.defer="leave_end_date">
                        @error('leave_end_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="medical_certificate" class="form-label">Surat Dokter (Opsional)</label>
                        <div class="file-upload-container">
                            <input type="file" 
                                   class="form-control file-input @error('medical_certificate') is-invalid @enderror" 
                                   id="medical_certificate" 
                                   wire:model="medical_certificate"
                                   accept=".pdf,.jpg,.jpeg,.png"
                                   onchange="previewFile(this, 'medical_preview')">
                            <div class="form-text">Format: PDF, JPG, JPEG, PNG. Maksimal 2MB</div>
                            @error('medical_certificate') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            
                            <!-- Preview Container -->
                            <div id="medical_preview" class="file-preview mt-3" style="display: none;">
                                <div class="preview-card">
                                    <div class="preview-header">
                                        <span class="preview-title">Preview Surat Dokter</span>
                                        <button type="button" class="btn-close-preview" onclick="removePreview('medical_certificate', 'medical_preview')">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                    <div class="preview-content">
                                        <img class="preview-image" style="display: none;" alt="Preview">
                                        <div class="preview-file" style="display: none;">
                                            <i class="fas fa-file-pdf fa-3x text-danger"></i>
                                            <p class="preview-filename mt-2"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Common Fields -->
        <div class="mb-3">
            <x-form-label id="title" label='Judul Izin' />
            <x-form-input id="title" name="title" wire:model.defer="permission.title" placeholder="Contoh: Izin Sakit, Izin Keperluan Keluarga" />
            <x-form-error key="permission.title" />
        </div>

        <div class="mb-3">
            <x-form-label id="description" label='Keterangan Izin (Alasan Lengkap)' />
            <textarea id="description" name="description" class="form-control @error('permission.description') is-invalid @enderror"
                wire:model.defer="permission.description" rows="4" placeholder="Jelaskan alasan izin Anda secara detail..."></textarea>
            <x-form-error key="permission.description" />
        </div>

        <!-- Proof Document Upload -->
        <div class="mb-4">
            <label for="proof_document" class="form-label">Dokumen Pendukung (Opsional)</label>
            <div class="file-upload-container">
                <input type="file" 
                       class="form-control file-input @error('proof_document') is-invalid @enderror" 
                       id="proof_document" 
                       wire:model="proof_document"
                       accept=".pdf,.jpg,.jpeg,.png"
                       onchange="previewFile(this, 'proof_preview')">
                <div class="form-text">Format: PDF, JPG, JPEG, PNG. Maksimal 2MB</div>
                @error('proof_document') <div class="invalid-feedback">{{ $message }}</div> @enderror
                
                <!-- Preview Container -->
                <div id="proof_preview" class="file-preview mt-3" style="display: none;">
                    <div class="preview-card">
                        <div class="preview-header">
                            <span class="preview-title">Preview Dokumen Pendukung</span>
                            <button type="button" class="btn-close-preview" onclick="removePreview('proof_document', 'proof_preview')">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="preview-content">
                            <img class="preview-image" style="display: none;" alt="Preview">
                            <div class="preview-file" style="display: none;">
                                <i class="fas fa-file-pdf fa-3x text-danger"></i>
                                <p class="preview-filename mt-2"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Loading Indicator -->
        <div wire:loading wire:target="save" class="text-center mb-3">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <div class="mt-2">Sedang memproses izin...</div>
        </div>

        <!-- Submit Button -->
        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('home.show', $attendanceId) }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                <i class="fas fa-paper-plane me-2"></i>Ajukan Izin
            </button>
        </div>
    </form>
</div>

@push('styles')
<style>
/* Permission Type Cards */
.permission-type-card {
    cursor: pointer;
    transition: all 0.3s ease;
    border: 2px solid #dee2e6;
    border-radius: 10px;
    height: 100%;
}

.permission-type-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.permission-type-card.selected {
    border-color: #007bff;
    background-color: #f8f9ff;
    box-shadow: 0 4px 15px rgba(0,123,255,0.2);
}

/* File Upload Styles */
.file-upload-container {
    position: relative;
}

.file-preview {
    animation: slideDown 0.3s ease-in-out;
}

@keyframes slideDown {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.preview-card {
    border: 2px dashed #dee2e6;
    border-radius: 8px;
    background: #f8f9fa;
    overflow: hidden;
}

.preview-header {
    background: #e9ecef;
    padding: 10px 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #dee2e6;
}

.preview-title {
    font-weight: 600;
    color: #495057;
    font-size: 0.9rem;
}

.btn-close-preview {
    background: none;
    border: none;
    color: #6c757d;
    cursor: pointer;
    padding: 5px;
    border-radius: 50%;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}

.btn-close-preview:hover {
    background: #dc3545;
    color: white;
}

.preview-content {
    padding: 20px;
    text-align: center;
}

.preview-image {
    max-width: 100%;
    max-height: 200px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.preview-file {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.preview-filename {
    font-size: 0.9rem;
    color: #495057;
    margin: 0;
    word-break: break-all;
}

.file-input:focus {
    border-color: #80bdff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

/* Drag and Drop Styles */
.file-upload-container.drag-over {
    background-color: #e3f2fd;
    border: 2px dashed #2196f3;
    border-radius: 8px;
}

.file-upload-container.drag-over .file-input {
    border-color: #2196f3;
    background-color: #e3f2fd;
}

/* Enhanced file input styling */
.file-input::file-selector-button {
    background: #007bff;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 4px;
    margin-right: 10px;
    cursor: pointer;
    transition: background-color 0.2s ease;
}

.file-input::file-selector-button:hover {
    background: #0056b3;
}

/* Card styling */
.card {
    border-radius: 10px;
    border: none;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.card-header {
    border-radius: 10px 10px 0 0 !important;
}
</style>
@endpush

@push('scripts')
<script>
// File Preview Functions
function previewFile(input, previewId) {
    const file = input.files[0];
    const previewContainer = document.getElementById(previewId);
    const previewImage = previewContainer.querySelector('.preview-image');
    const previewFile = previewContainer.querySelector('.preview-file');
    const previewFilename = previewContainer.querySelector('.preview-filename');
    
    if (file) {
        // Check file size (2MB = 2 * 1024 * 1024 bytes)
        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran file terlalu besar. Maksimal 2MB.');
            input.value = '';
            return;
        }
        
        // Show preview container
        previewContainer.style.display = 'block';
        
        // Set filename
        previewFilename.textContent = file.name;
        
        if (file.type.startsWith('image/')) {
            // Show image preview
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewImage.style.display = 'block';
                previewFile.style.display = 'none';
            };
            reader.readAsDataURL(file);
        } else {
            // Show file icon for PDF
            previewImage.style.display = 'none';
            previewFile.style.display = 'flex';
        }
    } else {
        previewContainer.style.display = 'none';
    }
}

function removePreview(inputId, previewId) {
    const input = document.getElementById(inputId);
    const previewContainer = document.getElementById(previewId);
    
    // Clear input
    input.value = '';
    
    // Hide preview
    previewContainer.style.display = 'none';
    
    // Reset preview content
    const previewImage = previewContainer.querySelector('.preview-image');
    const previewFile = previewContainer.querySelector('.preview-file');
    
    previewImage.src = '';
    previewImage.style.display = 'none';
    previewFile.style.display = 'none';
    
    // Trigger Livewire update
    input.dispatchEvent(new Event('change'));
}

// Drag and drop functionality
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.file-input').forEach(input => {
        const container = input.closest('.file-upload-container');
        
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            container.addEventListener(eventName, preventDefaults, false);
        });
        
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        ['dragenter', 'dragover'].forEach(eventName => {
            container.addEventListener(eventName, highlight, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            container.addEventListener(eventName, unhighlight, false);
        });
        
        function highlight(e) {
            container.classList.add('drag-over');
        }
        
        function unhighlight(e) {
            container.classList.remove('drag-over');
        }
        
        container.addEventListener('drop', handleDrop, false);
        
        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            
            if (files.length > 0) {
                input.files = files;
                const previewId = input.getAttribute('onchange').match(/'([^']+)'/)[1];
                previewFile(input, previewId);
                
                // Trigger Livewire update
                input.dispatchEvent(new Event('change'));
            }
        }
    });
});
</script>
@endpush