@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
        <a href="{{ route('reports.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
        </a>
    </div>

    <!-- Filter Info -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-filter me-2"></i>Filter Laporan
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <strong>Periode:</strong><br>
                    {{ $start_date->format('d F Y') }} - {{ $end_date->format('d F Y') }}
                </div>
                <div class="col-md-3">
                    <strong>Jenis Izin:</strong><br>
                    @if($type === 'same_day')
                        Izin Hari yang Sama
                    @elseif($type === 'leave')
                        Izin Cuti
                    @else
                        Semua Jenis
                    @endif
                </div>
                <div class="col-md-3">
                    <strong>Status:</strong><br>
                    @if($status === 'pending')
                        Menunggu
                    @elseif($status === 'accepted')
                        Disetujui
                    @elseif($status === 'rejected')
                        Ditolak
                    @else
                        Semua Status
                    @endif
                </div>
                <div class="col-md-3">
                    <strong>Total Izin:</strong><br>
                    {{ $permissions->count() }} izin
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Statistics -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Menunggu Persetujuan
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $permissions->whereNull('is_accepted')->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Disetujui
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $permissions->where('is_accepted', true)->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Ditolak
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $permissions->where('is_accepted', false)->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Izin Cuti
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $permissions->where('type', 'leave')->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-times fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Permissions Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-table me-2"></i>Daftar Izin
            </h6>
        </div>
        <div class="card-body">
            @if($permissions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Judul</th>
                                <th>Jenis</th>
                                <th>Tanggal Izin</th>
                                <th>Detail</th>
                                <th>Status</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($permissions as $index => $permission)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="user-avatar me-3">
                                                <i class="fas fa-user-circle fa-2x text-secondary"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold">{{ $permission->user->name }}</div>
                                                <small class="text-muted">{{ $permission->user->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $permission->title }}</td>
                                    <td>
                                        @if($permission->type === 'same_day')
                                            <span class="badge bg-primary">
                                                <i class="fas fa-clock me-1"></i>Hari yang Sama
                                            </span>
                                        @else
                                            <span class="badge bg-success">
                                                <i class="fas fa-calendar-times me-1"></i>Cuti
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $permission->permission_date->format('d/m/Y') }}</td>
                                    <td>
                                        @if($permission->type === 'same_day')
                                            @if($permission->late_arrival_time)
                                                <small>Datang: {{ $permission->late_arrival_time->format('H:i') }}</small><br>
                                            @endif
                                            @if($permission->early_departure_time)
                                                <small>Pulang: {{ $permission->early_departure_time->format('H:i') }}</small>
                                            @endif
                                        @else
                                            @if($permission->leave_start_date && $permission->leave_end_date)
                                                <small>{{ $permission->leave_start_date->format('d/m/Y') }} - {{ $permission->leave_end_date->format('d/m/Y') }}</small>
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        @if($permission->is_accepted === null)
                                            <span class="badge bg-warning">
                                                <i class="fas fa-clock me-1"></i>Menunggu
                                            </span>
                                        @elseif($permission->is_accepted)
                                            <span class="badge bg-success">
                                                <i class="fas fa-check me-1"></i>Disetujui
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                <i class="fas fa-times me-1"></i>Ditolak
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $permission->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <button class="btn btn-info btn-sm" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#detailModal{{ $permission->id }}"
                                                title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        @if($permission->medical_certificate)
                                            <a href="{{ Storage::url($permission->medical_certificate) }}" 
                                               target="_blank" 
                                               class="btn btn-success btn-sm"
                                               title="Lihat Surat Dokter">
                                                <i class="fas fa-file-medical"></i>
                                            </a>
                                        @endif
                                        @if($permission->proof_document)
                                            <a href="{{ Storage::url($permission->proof_document) }}" 
                                               target="_blank" 
                                               class="btn btn-primary btn-sm"
                                               title="Lihat Dokumen">
                                                <i class="fas fa-file-alt"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>

                                <!-- Detail Modal -->
                                <div class="modal fade" id="detailModal{{ $permission->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Detail Izin - {{ $permission->user->name }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <strong>Judul:</strong><br>
                                                        {{ $permission->title }}
                                                    </div>
                                                    <div class="col-md-6">
                                                        <strong>Jenis:</strong><br>
                                                        {{ $permission->type === 'same_day' ? 'Izin Hari yang Sama' : 'Izin Cuti' }}
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <strong>Keterangan:</strong><br>
                                                        {{ $permission->description }}
                                                    </div>
                                                </div>
                                                @if($permission->rejection_reason)
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <strong>Alasan Penolakan:</strong><br>
                                                            <div class="alert alert-danger">{{ $permission->rejection_reason }}</div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Tidak ada data izin</h5>
                    <p class="text-muted">Tidak ditemukan data izin untuk filter yang dipilih</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Export Options -->
    <div class="card shadow">
        <div class="card-body">
            <h6 class="mb-3">Export Laporan</h6>
            <form action="{{ route('reports.permissions') }}" method="GET" class="d-inline">
                <input type="hidden" name="start_date" value="{{ $start_date->format('Y-m-d') }}">
                <input type="hidden" name="end_date" value="{{ $end_date->format('Y-m-d') }}">
                @if($type)
                    <input type="hidden" name="type" value="{{ $type }}">
                @endif
                @if($status)
                    <input type="hidden" name="status" value="{{ $status }}">
                @endif
                <input type="hidden" name="format" value="pdf">
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-file-pdf me-2"></i>Download PDF
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('style')
<style>
.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}

.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}

.border-left-danger {
    border-left: 0.25rem solid #e74a3b !important;
}

.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}

.card {
    border: none;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
}

.table th {
    background-color: #f8f9fc;
    border-color: #e3e6f0;
    font-weight: 600;
}

.user-avatar {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-group .btn {
    margin-right: 2px;
}
</style>
@endpush