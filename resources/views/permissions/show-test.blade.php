@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <!-- Test Form for Direct Submission -->
            @if(auth()->user()->isOperator() && $permission->isPending())
            <div class="card border-warning mb-4">
                <div class="card-header bg-warning text-dark">
                    <h6 class="mb-0">🧪 Test Direct Form Submission</h6>
                </div>
                <div class="card-body">
                    <p>Test apakah route dan controller berfungsi dengan benar:</p>
                    <form action="{{ route('permissions.updateStatus', $permission) }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="action" value="accept">
                        <button type="submit" class="btn btn-success me-2" onclick="return confirm('Test: Terima izin ini?')">
                            <i class="fas fa-check me-2"></i>Test Terima
                        </button>
                    </form>
                    <form action="{{ route('permissions.updateStatus', $permission) }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="action" value="reject">
                        <input type="hidden" name="rejection_reason" value="Test rejection reason">
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Test: Tolak izin ini?')">
                            <i class="fas fa-times me-2"></i>Test Tolak
                        </button>
                    </form>
                </div>
            </div>
            @endif

            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-eye me-2"></i>{{ $title }}
                    </h6>
                </div>
                <div class="card-body">
                    <!-- Permission Status -->
                    <div class="row mb-4">
                        <div class="col-12">
                            @php
                                $alertClass = match($permission->status) {
                                    'pending' => 'warning',
                                    'accepted' => 'success',
                                    'rejected' => 'danger',
                                    default => 'secondary'
                                };
                                $iconClass = match($permission->status) {
                                    'pending' => 'clock',
                                    'accepted' => 'check-circle',
                                    'rejected' => 'times-circle',
                                    default => 'clock'
                                };
                            @endphp
                            <div class="alert alert-{{ $alertClass }}">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-{{ $iconClass }} fa-2x me-3"></i>
                                    <div>
                                        <h5 class="mb-1">Status: {{ $permission->status_text }}</h5>
                                        @if($permission->isRejected() && $permission->rejection_reason)
                                            <p class="mb-0"><strong>Alasan Penolakan:</strong> {{ $permission->rejection_reason }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Basic Information -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label text-muted">Nama Pemohon</label>
                            <div class="fw-bold">{{ $permission->user->name }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">Tanggal Pengajuan</label>
                            <div class="fw-bold">{{ $permission->created_at->format('d F Y, H:i') }}</div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label text-muted">Jenis Izin</label>
                            <div>
                                @if($permission->type === 'same_day')
                                    <span class="badge bg-primary fs-6">
                                        <i class="fas fa-clock me-1"></i>Izin Hari yang Sama
                                    </span>
                                @else
                                    <span class="badge bg-success fs-6">
                                        <i class="fas fa-calendar-times me-1"></i>Izin Cuti
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">Tanggal Izin</label>
                            <div class="fw-bold">{{ $permission->permission_date->format('d F Y') }}</div>
                        </div>
                    </div>

                    <!-- Permission Content -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <label class="form-label text-muted">Judul Izin</label>
                            <div class="fw-bold">{{ $permission->title }}</div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12">
                            <label class="form-label text-muted">Keterangan</label>
                            <div class="border rounded p-3 bg-light">
                                {{ $permission->description }}
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('my-permissions.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                        
                        <div>
                            @if(auth()->user()->isOperator())
                                @if($permission->isPending())
                                    <button type="button" 
                                            class="btn btn-success me-2" 
                                            onclick="updatePermissionStatus({{ $permission->id }}, 'accept')">
                                        <i class="fas fa-check me-2"></i>Terima (Modal)
                                    </button>
                                    <button type="button" 
                                            class="btn btn-danger" 
                                            onclick="updatePermissionStatus({{ $permission->id }}, 'reject')">
                                        <i class="fas fa-times me-2"></i>Tolak (Modal)
                                    </button>
                                @endif
                            @elseif($permission->user_id === auth()->id() && $permission->isPending())
                                <a href="{{ route('my-permissions.edit', $permission) }}" class="btn btn-warning me-2">
                                    <i class="fas fa-edit me-2"></i>Edit
                                </a>
                                <form action="{{ route('my-permissions.destroy', $permission) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus izin ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash me-2"></i>Hapus
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Status Update Modal -->
@if(auth()->user()->isOperator())
<div class="modal fade" id="statusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Status Izin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="statusForm" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="action" id="actionValue">
                    <div id="rejectionReason" style="display: none;">
                        <label for="rejection_reason" class="form-label">Alasan Penolakan</label>
                        <textarea class="form-control" 
                                  id="rejection_reason" 
                                  name="rejection_reason" 
                                  rows="3" 
                                  placeholder="Masukkan alasan penolakan..." 
                                  required></textarea>
                    </div>
                    <div id="confirmationText"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="confirmButton">Konfirmasi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection

@push('style')
<style>
.badge.fs-6 {
    font-size: 0.9rem !important;
    padding: 0.5rem 1rem;
}

.card {
    border: none;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
}

.card-header {
    border-radius: 10px 10px 0 0 !important;
}

.form-label {
    font-weight: 600;
    margin-bottom: 5px;
}

.alert {
    border-radius: 10px;
}
</style>
@endpush

@push('script')
@if(auth()->user()->isOperator())
<script src="{{ asset('js/permissions.js') }}"></script>
@endif
@endpush