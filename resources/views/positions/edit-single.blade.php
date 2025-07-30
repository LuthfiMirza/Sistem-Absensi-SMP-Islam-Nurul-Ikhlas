@extends('layouts.app')

@section('buttons')
<div class="btn-toolbar mb-2 mb-md-0">
    <div>
        <a href="{{ route('positions.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i>
            Kembali
        </a>
        <a href="{{ route('positions.show', $position->id) }}" class="btn btn-sm btn-info">
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
                    Edit Data Posisi
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('positions.update', $position->id) }}" method="POST" id="editPositionForm">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Posisi <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $position->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="type" class="form-label">Kategori <span class="text-danger">*</span></label>
                                <select class="form-select @error('type') is-invalid @enderror" 
                                        id="type" name="type" required>
                                    <option value="">Pilih Kategori</option>
                                    <option value="karyawan" {{ old('type', $position->type) == 'karyawan' ? 'selected' : '' }}>
                                        🏢 Divisi (Karyawan)
                                    </option>
                                    <option value="guru" {{ old('type', $position->type) == 'guru' ? 'selected' : '' }}>
                                        📚 Mata Pelajaran (Guru)
                                    </option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('positions.show', $position->id) }}" class="btn btn-secondary">
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
                                <td>{{ $position->name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Kategori:</strong></td>
                                <td>
                                    @if($position->type === 'guru')
                                        <span class="badge bg-success">📚 Mata Pelajaran</span>
                                    @else
                                        <span class="badge bg-info">🏢 Divisi</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm">
                            <tr>
                                <td><strong>Jumlah Pengguna:</strong></td>
                                <td>
                                    <span class="badge bg-secondary">
                                        {{ $position->users()->count() }} orang
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Dibuat:</strong></td>
                                <td>{{ $position->created_at->format('d/m/Y H:i') }}</td>
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
        text: 'Apakah Anda yakin ingin mengupdate data posisi ini?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Update!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('editPositionForm').submit();
        }
    });
}
</script>
@endpush