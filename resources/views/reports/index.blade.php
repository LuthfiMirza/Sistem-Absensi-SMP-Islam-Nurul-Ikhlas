@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
    </div>

    <!-- Report Cards -->
    <div class="row">
        <!-- Attendance Report -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Laporan Absensi
                            </div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">
                                Laporan kehadiran berdasarkan periode
                            </div>
                            <div class="mt-3">
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#attendanceReportModal">
                                    <i class="fas fa-chart-line me-2"></i>Generate Laporan
                                </button>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recapitulation Report -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Rekapitulasi Absensi
                            </div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">
                                Rekapitulasi bulanan semua karyawan
                            </div>
                            <div class="mt-3">
                                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#recapReportModal">
                                    <i class="fas fa-chart-bar me-2"></i>Generate Laporan
                                </button>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-pie fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Permission Report -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Laporan Izin
                            </div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">
                                Laporan data izin karyawan
                            </div>
                            <div class="mt-3">
                                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#permissionReportModal">
                                    <i class="fas fa-file-alt me-2"></i>Generate Laporan
                                </button>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-signature fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Absensi Bulan Ini
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ \App\Models\Attendance::whereMonth('created_at', now()->month)->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Kehadiran Hari Ini
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ \App\Models\Presence::whereDate('created_at', today())->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-check fa-2x text-gray-300"></i>
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
                                Izin Disetujui Bulan Ini
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ \App\Models\Permission::where('status', 'accepted')->whereMonth('created_at', now()->month)->count() }}
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
                                Izin Pending
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ \App\Models\Permission::where('status', 'pending')->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Info -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-info-circle me-2"></i>Informasi Laporan
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <h6 class="text-primary">Laporan Absensi</h6>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-check text-success me-2"></i>Data kehadiran per periode</li>
                        <li><i class="fas fa-check text-success me-2"></i>Filter berdasarkan karyawan</li>
                        <li><i class="fas fa-check text-success me-2"></i>Export ke PDF</li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h6 class="text-success">Rekapitulasi</h6>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-check text-success me-2"></i>Ringkasan bulanan</li>
                        <li><i class="fas fa-check text-success me-2"></i>Semua karyawan</li>
                        <li><i class="fas fa-check text-success me-2"></i>Statistik lengkap</li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h6 class="text-info">Laporan Izin</h6>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-check text-success me-2"></i>Data izin per periode</li>
                        <li><i class="fas fa-check text-success me-2"></i>Filter berdasarkan jenis</li>
                        <li><i class="fas fa-check text-success me-2"></i>Status persetujuan</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Attendance Report Modal -->
<div class="modal fade" id="attendanceReportModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Generate Laporan Absensi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('reports.attendance') }}" method="GET">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="end_date" class="form-label">Tanggal Selesai</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="user_id" class="form-label">Karyawan (Opsional)</label>
                        <select class="form-select" id="user_id" name="user_id">
                            <option value="">Semua Karyawan</option>
                            @php
                                $users = \App\Models\User::whereHas('role', function($q) { 
                                    $q->whereIn('name', ['karyawan', 'guru']); 
                                })->get();
                            @endphp
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="format" class="form-label">Format Output</label>
                        <select class="form-select" id="format" name="format" required>
                            <option value="view">Lihat di Browser</option>
                            <option value="pdf">Download PDF</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Generate Laporan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Recapitulation Report Modal -->
<div class="modal fade" id="recapReportModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Generate Rekapitulasi Absensi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('reports.recapitulation') }}" method="GET">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="month" class="form-label">Bulan</label>
                        <select class="form-select" id="month" name="month" required>
                            @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ $i == now()->month ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create(null, $i, 1)->format('F') }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="year" class="form-label">Tahun</label>
                        <select class="form-select" id="year" name="year" required>
                            @for($i = now()->year; $i >= 2020; $i--)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="format2" class="form-label">Format Output</label>
                        <select class="form-select" id="format2" name="format" required>
                            <option value="view">Lihat di Browser</option>
                            <option value="pdf">Download PDF</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Generate Laporan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Permission Report Modal -->
<div class="modal fade" id="permissionReportModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Generate Laporan Izin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('reports.permissions') }}" method="GET">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="start_date3" class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="start_date3" name="start_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="end_date3" class="form-label">Tanggal Selesai</label>
                        <input type="date" class="form-control" id="end_date3" name="end_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Jenis Izin (Opsional)</label>
                        <select class="form-select" id="type" name="type">
                            <option value="">Semua Jenis</option>
                            <option value="same_day">Izin Hari yang Sama</option>
                            <option value="leave">Izin Cuti</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status (Opsional)</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">Semua Status</option>
                            <option value="pending">Menunggu</option>
                            <option value="accepted">Disetujui</option>
                            <option value="rejected">Ditolak</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="format3" class="form-label">Format Output</label>
                        <select class="form-select" id="format3" name="format" required>
                            <option value="view">Lihat di Browser</option>
                            <option value="pdf">Download PDF</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-info">Generate Laporan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('style')
<style>
.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}

.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}

.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}

.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}

.border-left-danger {
    border-left: 0.25rem solid #e74a3b !important;
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