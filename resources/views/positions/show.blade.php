@extends('layouts.app')

@section('buttons')
<div class="btn-toolbar mb-2 mb-md-0">
    <div>
        <a href="{{ route('positions.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i>
            Kembali
        </a>
        <a href="{{ route('positions.edit', $position->id) }}" class="btn btn-sm btn-warning">
            <i class="fas fa-edit me-1"></i>
            Edit
        </a>
        <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $position->id }}, '{{ $position->name }}')">
            <i class="fas fa-trash me-1"></i>
            Hapus
        </button>
    </div>
</div>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        @include('partials.alerts')
        
        <!-- Position Info Card -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    @if($position->type === 'guru')
                        <i class="fas fa-book text-success me-2"></i>
                    @else
                        <i class="fas fa-building text-info me-2"></i>
                    @endif
                    Detail Posisi: {{ $position->name }}
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td width="150"><strong>ID:</strong></td>
                                <td>{{ $position->id }}</td>
                            </tr>
                            <tr>
                                <td><strong>Nama Posisi:</strong></td>
                                <td>{{ $position->name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Kategori:</strong></td>
                                <td>
                                    @if($position->type === 'guru')
                                        <span class="badge bg-success fs-6">📚 Mata Pelajaran (Guru)</span>
                                    @else
                                        <span class="badge bg-info fs-6">🏢 Divisi (Karyawan)</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td width="150"><strong>Jumlah Pengguna:</strong></td>
                                <td>
                                    <span class="badge bg-secondary fs-6">
                                        {{ $position->users()->count() }} orang
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Dibuat:</strong></td>
                                <td>{{ $position->created_at->format('d F Y, H:i') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Diupdate:</strong></td>
                                <td>{{ $position->updated_at->format('d F Y, H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Users List Card -->
        @if($position->users()->count() > 0)
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-users me-2"></i>
                    Daftar Pengguna ({{ $position->users()->count() }} orang)
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Bergabung</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($position->users as $index => $user)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="/assets/img/profile.png" alt="Profile" 
                                             class="rounded-circle me-2" width="32" height="32">
                                        <div>
                                            <div class="fw-bold">{{ $user->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if($user->role->name === 'guru')
                                        <span class="badge bg-success">🎓 Guru</span>
                                    @elseif($user->role->name === 'karyawan')
                                        <span class="badge bg-info">👔 Karyawan</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($user->role->name) }}</span>
                                    @endif
                                </td>
                                <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route('employees.show', $user->id) }}" 
                                       class="btn btn-sm btn-outline-info" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @else
        <div class="card mt-4">
            <div class="card-body text-center py-5">
                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Belum ada pengguna</h5>
                <p class="text-muted">Posisi ini belum digunakan oleh pengguna manapun</p>
            </div>
        </div>
        @endif
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
        text: `Apakah Anda yakin ingin menghapus posisi "${name}"?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('deleteForm');
            form.action = `{{ route('positions.destroy', '') }}/${id}`;
            form.submit();
        }
    });
}
</script>
@endpush