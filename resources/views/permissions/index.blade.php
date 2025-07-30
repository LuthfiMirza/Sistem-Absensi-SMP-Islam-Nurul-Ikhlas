@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
        @if(!auth()->user()->isOperator())
            <a href="{{ route('my-permissions.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Ajukan Izin
            </a>
        @endif
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Error Messages -->
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Filter Section -->
    @if(auth()->user()->isOperator())
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-filter me-2"></i>Filter Data
            </h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('permissions.index') }}">
                <div class="row">
                    <div class="col-md-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                            <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Diterima</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="type" class="form-label">Jenis</label>
                        <select name="type" id="type" class="form-select">
                            <option value="">Semua Jenis</option>
                            <option value="same_day" {{ request('type') == 'same_day' ? 'selected' : '' }}>Hari yang Sama</option>
                            <option value="leave" {{ request('type') == 'leave' ? 'selected' : '' }}>Cuti</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="date_from" class="form-label">Dari Tanggal</label>
                        <input type="date" name="date_from" id="date_from" class="form-control" value="{{ request('date_from') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="date_to" class="form-label">Sampai Tanggal</label>
                        <input type="date" name="date_to" id="date_to" class="form-control" value="{{ request('date_to') }}">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-2"></i>Filter
                        </button>
                        <a href="{{ route('permissions.index') }}" class="btn btn-secondary">
                            <i class="fas fa-refresh me-2"></i>Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- Permissions Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-list me-2"></i>Daftar Izin
            </h6>
            <span class="badge bg-info">Total: {{ $permissions->total() }} izin</span>
        </div>
        <div class="card-body">
            @if($permissions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                @if(auth()->user()->isOperator())
                                    <th width="15%">Nama Karyawan</th>
                                @endif
                                <th width="20%">Judul</th>
                                <th width="10%">Jenis</th>
                                <th width="12%">Tanggal Izin</th>
                                <th width="10%">Status</th>
                                <th width="15%">Tanggal Pengajuan</th>
                                <th width="{{ auth()->user()->isOperator() ? '13%' : '28%' }}">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($permissions as $index => $permission)
                                <tr>
                                    <td class="text-center">{{ $permissions->firstItem() + $index }}</td>
                                    @if(auth()->user()->isOperator())
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                                    <i class="fas fa-user fa-sm"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold">{{ $permission->user->name }}</div>
                                                    <small class="text-muted">{{ $permission->user->position->name ?? 'N/A' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                    @endif
                                    <td>
                                        <div class="fw-bold">{{ $permission->title }}</div>
                                        <small class="text-muted">{{ Str::limit($permission->description, 50) }}</small>
                                    </td>
                                    <td>
                                        @if($permission->type === 'same_day')
                                            <span class="badge bg-primary">
                                                <i class="fas fa-clock me-1"></i>Hari yang Sama
                                            </span>
                                        @else
                                            <span class="badge bg-success">
                                                <i class="fas fa-calendar-days me-1"></i>Cuti
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ $permission->permission_date->format('d/m/Y') }}</div>
                                        <small class="text-muted">{{ $permission->permission_date->format('l') }}</small>
                                    </td>
                                    <td>
                                        @switch($permission->status)
                                            @case('pending')
                                                <span class="badge bg-warning text-dark">
                                                    <i class="fas fa-clock me-1"></i>Menunggu
                                                </span>
                                                @break
                                            @case('accepted')
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check me-1"></i>Diterima
                                                </span>
                                                @break
                                            @case('rejected')
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-times me-1"></i>Ditolak
                                                </span>
                                                @break
                                            @default
                                                <span class="badge bg-secondary">Unknown</span>
                                        @endswitch
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ $permission->created_at->format('d/m/Y') }}</div>
                                        <small class="text-muted">{{ $permission->created_at->format('H:i') }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <!-- View Detail Button -->
                                            <a href="{{ route('my-permissions.show', $permission) }}" 
                                               class="btn btn-info btn-sm"
                                               title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            
                                            <!-- Operator Actions (Delete any permission) -->
                                            @if(auth()->user()->isOperator())
                                                <button type="button" 
                                                        class="btn btn-danger btn-sm"
                                                        onclick="deletePermission({{ $permission->id }}, '{{ $permission->user->name }}', '{{ $permission->title }}')"
                                                        title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @endif
                                            
                                            <!-- User Actions (Edit/Delete for own pending permissions) -->
                                            @if(!auth()->user()->isOperator() && $permission->user_id === auth()->id() && $permission->isPending())
                                                <a href="{{ route('my-permissions.edit', $permission) }}" 
                                                   class="btn btn-warning btn-sm"
                                                   title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-danger btn-sm"
                                                        onclick="deletePermission({{ $permission->id }}, '{{ $permission->user->name }}', '{{ $permission->title }}')"
                                                        title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">
                        Menampilkan {{ $permissions->firstItem() }} sampai {{ $permissions->lastItem() }} 
                        dari {{ $permissions->total() }} data
                    </div>
                    <div>
                        {{ $permissions->appends(request()->query())->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum ada data izin</h5>
                    <p class="text-muted">
                        @if(auth()->user()->isOperator())
                            Belum ada pengajuan izin dari karyawan.
                        @else
                            Anda belum pernah mengajukan izin.
                        @endif
                    </p>
                    @if(!auth()->user()->isOperator())
                        <a href="{{ route('my-permissions.create') }}" class="btn btn-primary mt-3">
                            <i class="fas fa-plus me-2"></i>Ajukan Izin Pertama
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fas fa-exclamation-triangle text-danger me-2"></i>
                    Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <i class="fas fa-warning me-2"></i>
                    <strong>Peringatan!</strong> Tindakan ini tidak dapat dibatalkan.
                </div>
                <p>Apakah Anda yakin ingin menghapus izin berikut?</p>
                <div class="card bg-light">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4"><strong>Nama:</strong></div>
                            <div class="col-sm-8" id="deleteUserName">-</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4"><strong>Judul:</strong></div>
                            <div class="col-sm-8" id="deletePermissionTitle">-</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Batal
                </button>
                <form id="deleteForm" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-2"></i>Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('style')
<style>
.table th {
    background-color: #f8f9fc;
    border-color: #e3e6f0;
    font-weight: 600;
    font-size: 0.875rem;
}

.table td {
    vertical-align: middle;
    font-size: 0.875rem;
}

.badge {
    font-size: 0.75rem;
    padding: 0.5rem 0.75rem;
}

.btn-group .btn {
    margin-right: 2px;
}

.btn-group .btn:last-child {
    margin-right: 0;
}

.card {
    border: none;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
}

.card-header {
    background-color: #f8f9fc;
    border-bottom: 1px solid #e3e6f0;
}

.avatar-sm {
    font-size: 0.75rem;
}

.table-hover tbody tr:hover {
    background-color: rgba(0, 0, 0, 0.025);
}

.form-select, .form-control {
    font-size: 0.875rem;
}

.btn-sm {
    font-size: 0.75rem;
    padding: 0.375rem 0.5rem;
}

.modal-content {
    border-radius: 10px;
}

.modal-header {
    border-bottom: 1px solid #e3e6f0;
}

.modal-footer {
    border-top: 1px solid #e3e6f0;
}

@media (max-width: 768px) {
    .table-responsive {
        font-size: 0.8rem;
    }
    
    .btn-group .btn {
        padding: 0.25rem 0.4rem;
    }
    
    .badge {
        font-size: 0.7rem;
        padding: 0.4rem 0.6rem;
    }
}
</style>
@endpush

@push('script')
<script>
function deletePermission(permissionId, userName, permissionTitle) {
    // Set the data in the modal
    document.getElementById('deleteUserName').textContent = userName;
    document.getElementById('deletePermissionTitle').textContent = permissionTitle;
    
    // Set the form action
    const deleteForm = document.getElementById('deleteForm');
    deleteForm.action = `/permissions/${permissionId}`;
    
    // Show the modal
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}

// Add loading state to delete form
document.getElementById('deleteForm').addEventListener('submit', function() {
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menghapus...';
    
    // Reset after 5 seconds if something goes wrong
    setTimeout(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    }, 5000);
});
</script>
@endpush