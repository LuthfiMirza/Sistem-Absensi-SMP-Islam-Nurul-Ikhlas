@extends('layouts.app')

@section('buttons')
<div class="btn-toolbar mb-2 mb-md-0">
    <div>
        <a href="{{ route('employees.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i>
            Kembali
        </a>
        <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-sm btn-warning">
            <i class="fas fa-edit me-1"></i>
            Edit
        </a>
        @if($employee->id !== auth()->user()->id)
            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $employee->id }}, '{{ $employee->name }}')">
                <i class="fas fa-trash me-1"></i>
                Hapus
            </button>
        @endif
    </div>
</div>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        @include('partials.alerts')
        
        <!-- Employee Info Card -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    @if($employee->role->name === 'guru')
                        <i class="fas fa-chalkboard-teacher text-success me-2"></i>
                    @elseif($employee->role->name === 'karyawan')
                        <i class="fas fa-user-tie text-info me-2"></i>
                    @else
                        <i class="fas fa-user text-secondary me-2"></i>
                    @endif
                    Detail Pegawai: {{ $employee->name }}
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 text-center">
                        <img src="/assets/img/profile.png" alt="Profile" 
                             class="rounded-circle mb-3" width="120" height="120">
                        <h6 class="fw-bold">{{ $employee->name }}</h6>
                        @if($employee->role->name === 'guru')
                            <span class="badge bg-success fs-6">🎓 Guru</span>
                        @elseif($employee->role->name === 'karyawan')
                            <span class="badge bg-info fs-6">👔 Karyawan</span>
                        @else
                            <span class="badge bg-secondary fs-6">{{ ucfirst($employee->role->name) }}</span>
                        @endif
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="150"><strong>ID:</strong></td>
                                        <td>{{ $employee->id }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Nama Lengkap:</strong></td>
                                        <td>{{ $employee->name }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email:</strong></td>
                                        <td>{{ $employee->email }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>No. Telepon:</strong></td>
                                        <td>{{ $employee->phone ?: '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="150"><strong>Role:</strong></td>
                                        <td>
                                            @if($employee->role->name === 'guru')
                                                <span class="badge bg-success">🎓 Guru</span>
                                            @elseif($employee->role->name === 'karyawan')
                                                <span class="badge bg-info">👔 Karyawan</span>
                                            @else
                                                <span class="badge bg-secondary">{{ ucfirst($employee->role->name) }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Posisi:</strong></td>
                                        <td>
                                            @if($employee->position)
                                                @if($employee->position->type === 'guru')
                                                    <span class="text-success">📚 {{ $employee->position->name }}</span>
                                                @else
                                                    <span class="text-info">🏢 {{ $employee->position->name }}</span>
                                                @endif
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Bergabung:</strong></td>
                                        <td>{{ $employee->created_at->format('d F Y, H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Diupdate:</strong></td>
                                        <td>{{ $employee->updated_at->format('d F Y, H:i') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Info Cards -->
        <div class="row mt-4">
            <!-- Position Details -->
            @if($employee->position)
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">
                            @if($employee->position->type === 'guru')
                                <i class="fas fa-book me-2"></i>
                                Mata Pelajaran
                            @else
                                <i class="fas fa-building me-2"></i>
                                Divisi
                            @endif
                        </h6>
                    </div>
                    <div class="card-body">
                        <h6>{{ $employee->position->name }}</h6>
                        <p class="text-muted mb-2">
                            @if($employee->position->type === 'guru')
                                Mata pelajaran yang diampu
                            @else
                                Divisi tempat bekerja
                            @endif
                        </p>
                        <small class="text-muted">
                            Total {{ $employee->position->users()->count() }} orang di posisi ini
                        </small>
                    </div>
                </div>
            </div>
            @endif
            
            <!-- Account Status -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">
                            <i class="fas fa-user-check me-2"></i>
                            Status Akun
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Status:</span>
                            <span class="badge bg-success">Aktif</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Terakhir Login:</span>
                            <span class="text-muted">-</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span>Akun Dibuat:</span>
                            <span class="text-muted">{{ $employee->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-cogs me-2"></i>
                    Aksi Cepat
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-warning btn-sm w-100">
                            <i class="fas fa-edit me-1"></i>
                            Edit Data
                        </a>
                    </div>
                    @if($employee->position)
                    <div class="col-md-3">
                        <a href="{{ route('positions.show', $employee->position->id) }}" class="btn btn-info btn-sm w-100">
                            <i class="fas fa-eye me-1"></i>
                            Lihat Posisi
                        </a>
                    </div>
                    @endif
                    <div class="col-md-3">
                        <a href="{{ route('employees.index') }}" class="btn btn-secondary btn-sm w-100">
                            <i class="fas fa-list me-1"></i>
                            Daftar Pegawai
                        </a>
                    </div>
                    @if($employee->id !== auth()->user()->id)
                    <div class="col-md-3">
                        <button type="button" class="btn btn-danger btn-sm w-100" onclick="confirmDelete({{ $employee->id }}, '{{ $employee->name }}')">
                            <i class="fas fa-trash me-1"></i>
                            Hapus Data
                        </button>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Form -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('script')
<script>
function confirmDelete(id, name) {
    Swal.fire({
        title: 'Konfirmasi Hapus',
        text: `Apakah Anda yakin ingin menghapus data pegawai "${name}"?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('deleteForm');
            form.action = `{{ route('employees.destroy', '') }}/${id}`;
            form.submit();
        }
    });
}
</script>
@endpush