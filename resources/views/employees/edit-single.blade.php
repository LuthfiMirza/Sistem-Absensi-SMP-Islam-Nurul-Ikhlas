@extends('layouts.app')

@section('buttons')
<div class="btn-toolbar mb-2 mb-md-0">
    <div>
        <a href="{{ route('employees.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i>
            Kembali
        </a>
        <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-sm btn-info">
            <i class="fas fa-eye me-1"></i>
            Lihat Detail
        </a>
    </div>
</div>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        @include('partials.alerts')
        
        <!-- Form Card -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-edit me-2"></i>
                    Edit Data Pegawai
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('employees.update', $employee->id) }}" method="POST" id="editEmployeeForm">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $employee->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', $employee->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="phone" class="form-label">No. Telepon</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" name="phone" value="{{ old('phone', $employee->phone) }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="role_id" class="form-label">Role <span class="text-danger">*</span></label>
                                <select class="form-select @error('role_id') is-invalid @enderror" 
                                        id="role_id" name="role_id" required>
                                    <option value="">Pilih Role</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" {{ old('role_id', $employee->role_id) == $role->id ? 'selected' : '' }}>
                                            @if($role->name === 'guru')
                                                🎓 Guru
                                            @elseif($role->name === 'karyawan')
                                                👔 Karyawan
                                            @else
                                                {{ ucfirst($role->name) }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('role_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="position_id" class="form-label">Posisi <span class="text-danger">*</span></label>
                                <select class="form-select @error('position_id') is-invalid @enderror" 
                                        id="position_id" name="position_id" required>
                                    <option value="">Pilih Posisi</option>
                                    @foreach($positions as $position)
                                        <option value="{{ $position->id }}" {{ old('position_id', $employee->position_id) == $position->id ? 'selected' : '' }}>
                                            @if($position->type === 'guru')
                                                📚 {{ $position->name }}
                                            @else
                                                🏢 {{ $position->name }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('position_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password" class="form-label">Password Baru</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Kosongkan jika tidak ingin mengubah password</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                <input type="password" class="form-control" 
                                       id="password_confirmation" name="password_confirmation" 
                                       placeholder="Konfirmasi password baru">
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-secondary">
                            <i class="fas fa-times me-1"></i>
                            Batal
                        </a>
                        <button type="button" class="btn btn-primary" onclick="confirmUpdate()">
                            <i class="fas fa-save me-1"></i>
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Current Data Card -->
        <div class="card mt-4">
            <div class="card-header bg-light">
                <h6 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Data Saat Ini
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-sm">
                            <tr>
                                <td><strong>Nama:</strong></td>
                                <td>{{ $employee->name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Email:</strong></td>
                                <td>{{ $employee->email }}</td>
                            </tr>
                            <tr>
                                <td><strong>Telepon:</strong></td>
                                <td>{{ $employee->phone ?: '-' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm">
                            <tr>
                                <td><strong>Role:</strong></td>
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
                                            📚 {{ $employee->position->name }}
                                        @else
                                            🏢 {{ $employee->position->name }}
                                        @endif
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Bergabung:</strong></td>
                                <td>{{ $employee->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
function confirmUpdate() {
    Swal.fire({
        title: 'Konfirmasi Update',
        text: 'Apakah Anda yakin ingin mengupdate data pegawai ini?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Update!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('editEmployeeForm').submit();
        }
    });
}
</script>
@endpush