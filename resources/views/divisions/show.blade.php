@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-eye me-2"></i>{{ $title }}
                    </h6>
                </div>
                <div class="card-body">
                    <!-- Division Info -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label text-muted">Nama Divisi</label>
                            <div class="fw-bold fs-5">{{ $division->name }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">Tanggal Dibuat</label>
                            <div class="fw-bold">{{ $division->created_at->format('d F Y, H:i') }}</div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12">
                            <label class="form-label text-muted">Deskripsi</label>
                            <div class="border rounded p-3 bg-light">
                                {{ $division->description ?: 'Tidak ada deskripsi' }}
                            </div>
                        </div>
                    </div>

                    <!-- Statistics -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card border-primary">
                                <div class="card-body text-center">
                                    <i class="fas fa-users fa-2x text-primary mb-2"></i>
                                    <h4 class="text-primary">{{ $division->users->count() }}</h4>
                                    <p class="text-muted mb-0">Total Karyawan</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-success">
                                <div class="card-body text-center">
                                    <i class="fas fa-chalkboard-teacher fa-2x text-success mb-2"></i>
                                    <h4 class="text-success">{{ $division->users->where('role.name', 'guru')->count() }}</h4>
                                    <p class="text-muted mb-0">Guru</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-info">
                                <div class="card-body text-center">
                                    <i class="fas fa-user-tie fa-2x text-info mb-2"></i>
                                    <h4 class="text-info">{{ $division->users->where('role.name', 'karyawan')->count() }}</h4>
                                    <p class="text-muted mb-0">Karyawan</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Members List -->
                    @if($division->users->count() > 0)
                        <div class="card border-0 bg-light">
                            <div class="card-header bg-transparent">
                                <h6 class="mb-0">
                                    <i class="fas fa-users me-2"></i>Anggota Divisi
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach($division->users as $user)
                                        <div class="col-md-6 mb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="user-avatar me-3">
                                                    <i class="fas fa-user-circle fa-2x text-secondary"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold">{{ $user->name }}</div>
                                                    <small class="text-muted">{{ $user->email }}</small>
                                                    <div>
                                                        <span class="badge bg-{{ $user->role->name === 'guru' ? 'success' : 'primary' }}">
                                                            {{ ucfirst($user->role->name) }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <h6 class="text-muted">Belum ada anggota di divisi ini</h6>
                            <p class="text-muted">Tambahkan karyawan atau guru ke divisi ini</p>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('divisions.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                        <div>
                            <a href="{{ route('divisions.edit', $division) }}" class="btn btn-warning me-2">
                                <i class="fas fa-edit me-2"></i>Edit
                            </a>
                            <form action="{{ route('divisions.destroy', $division) }}" 
                                  method="POST" 
                                  class="d-inline"
                                  onsubmit="return confirm('Yakin ingin menghapus divisi ini? Semua data terkait akan ikut terhapus.')">
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
        </div>
    </div>
</div>
@endsection

@push('style')
<style>
.user-avatar {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.card {
    border-radius: 10px;
    border: none;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
}

.form-label {
    font-weight: 600;
    margin-bottom: 5px;
}
</style>
@endpush
@endsection