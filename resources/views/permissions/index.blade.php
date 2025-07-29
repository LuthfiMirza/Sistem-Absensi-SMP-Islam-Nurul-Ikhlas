@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
        @if(auth()->user()->isKaryawan())
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

    <!-- Permissions Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-list me-2"></i>Daftar Izin
            </h6>
        </div>
        <div class="card-body">
            @if($permissions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                @if(auth()->user()->isOperator())
                                    <th>Nama</th>
                                @endif
                                <th>Judul</th>
                                <th>Jenis</th>
                                <th>Tanggal Izin</th>
                                <th>Status</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($permissions as $index => $permission)
                                <tr>
                                    <td>{{ $permissions->firstItem() + $index }}</td>
                                    @if(auth()->user()->isOperator())
                                        <td>{{ $permission->user->name }}</td>
                                    @endif
                                    <td>{{ $permission->title }}</td>
                                    <td>
                                        @if($permission->type === 'same_day')
                                            <span class="badge bg-primary">Hari yang Sama</span>
                                        @else
                                            <span class="badge bg-success">Cuti</span>
                                        @endif
                                    </td>
                                    <td>{{ $permission->permission_date->format('d/m/Y') }}</td>
                                    <td>
                                        @switch($permission->status)
                                            @case('pending')
                                                <span class="badge bg-warning">Menunggu</span>
                                                @break
                                            @case('accepted')
                                                <span class="badge bg-success">Diterima</span>
                                                @break
                                            @case('rejected')
                                                <span class="badge bg-danger">Ditolak</span>
                                                @break
                                            @default
                                                <span class="badge bg-secondary">Unknown</span>
                                        @endswitch
                                    </td>
                                    <td>{{ $permission->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('my-permissions.show', $permission) }}" 
                                               class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            
                                            @if(auth()->user()->isOperator())
                                                @if($permission->isPending())
                                                    <button type="button" 
                                                            class="btn btn-success btn-sm" 
                                                            onclick="updatePermissionStatusFromList({{ $permission->id }}, 'accept')"
                                                            title="Terima">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                    <button type="button" 
                                                            class="btn btn-danger btn-sm" 
                                                            onclick="updatePermissionStatusFromList({{ $permission->id }}, 'reject')"
                                                            title="Tolak">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                @endif
                                            @else
                                                @if($permission->user_id === auth()->id() && $permission->isPending())
                                                    <a href="{{ route('my-permissions.edit', $permission) }}" 
                                                       class="btn btn-warning btn-sm">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('my-permissions.destroy', $permission) }}" 
                                                          method="POST" 
                                                          class="d-inline"
                                                          onsubmit="return confirm('Yakin ingin menghapus izin ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $permissions->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum ada data izin</h5>
                    @if(auth()->user()->isKaryawan())
                        <a href="{{ route('my-permissions.create') }}" class="btn btn-primary mt-3">
                            <i class="fas fa-plus me-2"></i>Ajukan Izin Pertama
                        </a>
                    @endif
                </div>
            @endif
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
                                  placeholder="Masukkan alasan penolakan..."></textarea>
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
.table th {
    background-color: #f8f9fc;
    border-color: #e3e6f0;
    font-weight: 600;
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
</style>
@endpush

@push('script')
@if(auth()->user()->isOperator())
<script>
// Ensure permissions.js is only loaded once
if (!window.permissionsJsLoaded) {
    window.permissionsJsLoaded = true;
    const script = document.createElement('script');
    script.src = '{{ asset('js/permissions.js') }}';
    script.onload = function() {
        console.log('Permissions.js loaded successfully from index page');
    };
    script.onerror = function() {
        console.error('Failed to load permissions.js');
    };
    document.head.appendChild(script);
}
</script>
@endif
@endpush