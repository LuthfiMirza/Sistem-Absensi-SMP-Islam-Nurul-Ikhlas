@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-edit me-2"></i>{{ $title }}
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('my-permissions.update', $permission) }}" method="POST" enctype="multipart/form-data" id="permissionForm">
                        @csrf
                        @method('PUT')
                        
                        <!-- Basic Information -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="attendance_id" class="form-label">Pilih Absensi</label>
                                <select class="form-select @error('attendance_id') is-invalid @enderror" 
                                        id="attendance_id" 
                                        name="attendance_id" 
                                        required>
                                    <option value="">Pilih Absensi</option>
                                    @foreach($attendances as $attendance)
                                        <option value="{{ $attendance->id }}" 
                                                {{ (old('attendance_id', $permission->attendance_id) == $attendance->id) ? 'selected' : '' }}>
                                            {{ $attendance->title }} - {{ $attendance->created_at->format('d/m/Y') }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('attendance_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="permission_date" class="form-label">Tanggal Izin</label>
                                <input type="date" 
                                       class="form-control @error('permission_date') is-invalid @enderror" 
                                       id="permission_date" 
                                       name="permission_date" 
                                       value="{{ old('permission_date', $permission->permission_date->format('Y-m-d')) }}" 
                                       required>
                                @error('permission_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Permission Type -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <label class="form-label">Jenis Izin</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card border-primary permission-type-card {{ old('type', $permission->type) == 'same_day' ? 'selected' : '' }}" data-type="same_day">
                                            <div class="card-body text-center">
                                                <div class="form-check">
                                                    <input class="form-check-input" 
                                                           type="radio" 
                                                           name="type" 
                                                           id="same_day" 
                                                           value="same_day" 
                                                           {{ old('type', $permission->type) == 'same_day' ? 'checked' : '' }}>
                                                    <label class="form-check-label w-100" for="same_day">
                                                        <i class="fas fa-clock fa-2x text-primary mb-2"></i>
                                                        <h5>Izin Hari yang Sama</h5>
                                                        <p class="text-muted">Datang terlambat atau pulang lebih cepat</p>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card border-success permission-type-card {{ old('type', $permission->type) == 'leave' ? 'selected' : '' }}" data-type="leave">
                                            <div class="card-body text-center">
                                                <div class="form-check">
                                                    <input class="form-check-input" 
                                                           type="radio" 
                                                           name="type" 
                                                           id="leave" 
                                                           value="leave" 
                                                           {{ old('type', $permission->type) == 'leave' ? 'checked' : '' }}>
                                                    <label class="form-check-label w-100" for="leave">
                                                        <i class="fas fa-calendar-times fa-2x text-success mb-2"></i>
                                                        <h5>Izin Cuti</h5>
                                                        <p class="text-muted">Tidak masuk beberapa hari</p>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @error('type')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Same Day Permission Fields -->
                        <div id="same_day_fields" class="permission-fields" style="display: {{ old('type', $permission->type) == 'same_day' ? 'block' : 'none' }};">
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
                                                   name="late_arrival_time" 
                                                   value="{{ old('late_arrival_time', $permission->late_arrival_time ? $permission->late_arrival_time->format('H:i') : '') }}">
                                            <div class="form-text">Kosongkan jika tidak datang terlambat</div>
                                            @error('late_arrival_time')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="early_departure_time" class="form-label">Jam Pulang Lebih Cepat (Opsional)</label>
                                            <input type="time" 
                                                   class="form-control @error('early_departure_time') is-invalid @enderror" 
                                                   id="early_departure_time" 
                                                   name="early_departure_time" 
                                                   value="{{ old('early_departure_time', $permission->early_departure_time ? $permission->early_departure_time->format('H:i') : '') }}">
                                            <div class="form-text">Kosongkan jika tidak pulang lebih cepat</div>
                                            @error('early_departure_time')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Leave Permission Fields -->
                        <div id="leave_fields" class="permission-fields" style="display: {{ old('type', $permission->type) == 'leave' ? 'block' : 'none' }};">
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
                                                   name="leave_start_date" 
                                                   value="{{ old('leave_start_date', $permission->leave_start_date ? $permission->leave_start_date->format('Y-m-d') : '') }}">
                                            @error('leave_start_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="leave_end_date" class="form-label">Tanggal Selesai Cuti</label>
                                            <input type="date" 
                                                   class="form-control @error('leave_end_date') is-invalid @enderror" 
                                                   id="leave_end_date" 
                                                   name="leave_end_date" 
                                                   value="{{ old('leave_end_date', $permission->leave_end_date ? $permission->leave_end_date->format('Y-m-d') : '') }}">
                                            @error('leave_end_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <label for="medical_certificate" class="form-label">Surat Dokter (Opsional)</label>
                                            @if($permission->medical_certificate)
                                                <div class="mb-2">
                                                    <small class="text-muted">File saat ini: </small>
                                                    <a href="{{ Storage::url($permission->medical_certificate) }}" target="_blank" class="text-primary">
                                                        <i class="fas fa-file-medical me-1"></i>Lihat file
                                                    </a>
                                                </div>
                                            @endif
                                            <div class="file-upload-container">
                                                <input type="file" 
                                                       class="form-control file-input @error('medical_certificate') is-invalid @enderror" 
                                                       id="medical_certificate" 
                                                       name="medical_certificate" 
                                                       accept=".pdf,.jpg,.jpeg,.png"
                                                       onchange="previewFile(this, 'medical_preview')">
                                                <div class="form-text">Format: PDF, JPG, JPEG, PNG. Maksimal 2MB. Kosongkan jika tidak ingin mengubah.</div>
                                                
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
                                            @error('medical_certificate')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Common Fields -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <label for="title" class="form-label">Judul Izin</label>
                                <input type="text" 
                                       class="form-control @error('title') is-invalid @enderror" 
                                       id="title" 
                                       name="title" 
                                       value="{{ old('title', $permission->title) }}" 
                                       placeholder="Contoh: Izin Sakit, Izin Keperluan Keluarga" 
                                       required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <label for="description" class="form-label">Keterangan</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" 
                                          name="description" 
                                          rows="4" 
                                          placeholder="Jelaskan alasan izin Anda secara detail..." 
                                          required>{{ old('description', $permission->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="proof_document" class="form-label">Dokumen Pendukung (Opsional)</label>
                                @if($permission->proof_document)
                                    <div class="mb-2">
                                        <small class="text-muted">File saat ini: </small>
                                        <a href="{{ Storage::url($permission->proof_document) }}" target="_blank" class="text-primary">
                                            <i class="fas fa-file-alt me-1"></i>Lihat file
                                        </a>
                                    </div>
                                @endif
                                <div class="file-upload-container">
                                    <input type="file" 
                                           class="form-control file-input @error('proof_document') is-invalid @enderror" 
                                           id="proof_document" 
                                           name="proof_document" 
                                           accept=".pdf,.jpg,.jpeg,.png"
                                           onchange="previewFile(this, 'proof_preview')">
                                    <div class="form-text">Format: PDF, JPG, JPEG, PNG. Maksimal 2MB. Kosongkan jika tidak ingin mengubah.</div>
                                    
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
                                @error('proof_document')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('my-permissions.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Perbarui Izin
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('style')
<style>
.permission-type-card {
    cursor: pointer;
    transition: all 0.3s ease;
    height: 100%;
}

.permission-type-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.permission-type-card.selected {
    border-width: 2px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

.form-check-input {
    display: none;
}

.form-check-label {
    cursor: pointer;
}

.permission-fields {
    animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.card-header {
    border-radius: 10px 10px 0 0 !important;
}

.card {
    border-radius: 10px;
    border: none;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
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
</style>
@endpush

@push('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeRadios = document.querySelectorAll('input[name="type"]');
    const permissionCards = document.querySelectorAll('.permission-type-card');
    const sameDayFields = document.getElementById('same_day_fields');
    const leaveFields = document.getElementById('leave_fields');

    // Handle permission type selection
    typeRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            // Update card selection
            permissionCards.forEach(card => {
                card.classList.remove('selected');
            });
            
            const selectedCard = document.querySelector(`[data-type="${this.value}"]`);
            if (selectedCard) {
                selectedCard.classList.add('selected');
            }

            // Show/hide relevant fields
            if (this.value === 'same_day') {
                sameDayFields.style.display = 'block';
                leaveFields.style.display = 'none';
            } else if (this.value === 'leave') {
                sameDayFields.style.display = 'none';
                leaveFields.style.display = 'block';
            }
        });
    });

    // Handle card clicks
    permissionCards.forEach(card => {
        card.addEventListener('click', function() {
            const type = this.dataset.type;
            const radio = document.getElementById(type);
            if (radio) {
                radio.checked = true;
                radio.dispatchEvent(new Event('change'));
            }
        });
    });

    // Initialize on page load
    const checkedRadio = document.querySelector('input[name="type"]:checked');
    if (checkedRadio) {
        checkedRadio.dispatchEvent(new Event('change'));
    }

    // Set minimum date to today
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('permission_date').min = today;
    document.getElementById('leave_start_date').min = today;
    
    // Update leave end date minimum when start date changes
    document.getElementById('leave_start_date').addEventListener('change', function() {
        document.getElementById('leave_end_date').min = this.value;
    });
});

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
}
</script>
@endpush