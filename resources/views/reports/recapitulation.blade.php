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
                <i class="fas fa-calendar me-2"></i>Rekapitulasi Bulan {{ $monthName }} {{ $year }}
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <strong>Periode:</strong><br>
                    {{ $start_date->format('d F Y') }} - {{ $end_date->format('d F Y') }}
                </div>
                <div class="col-md-3">
                    <strong>Total Karyawan:</strong><br>
                    {{ count($recapData) }} orang
                </div>
                <div class="col-md-3">
                    <strong>Total Hari Kerja:</strong><br>
                    {{ $recapData[0]['total_days'] ?? 0 }} hari
                </div>
                <div class="col-md-3">
                    <strong>Rata-rata Kehadiran:</strong><br>
                    {{ count($recapData) > 0 ? number_format(collect($recapData)->avg('present_days'), 1) : 0 }} hari
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Statistics -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Kehadiran
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ collect($recapData)->sum('present_days') }}
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
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Total Absen
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ collect($recapData)->sum('absent_days') }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-times fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Izin
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ collect($recapData)->sum('permission_days') }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-alt fa-2x text-gray-300"></i>
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
                                Total Terlambat
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ collect($recapData)->sum('late_days') }}
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

    <!-- Recapitulation Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-table me-2"></i>Detail Rekapitulasi per Karyawan
            </h6>
        </div>
        <div class="card-body">
            @if(count($recapData) > 0)
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Divisi</th>
                                <th>Total Hari</th>
                                <th>Hadir</th>
                                <th>Absen</th>
                                <th>Izin</th>
                                <th>Terlambat</th>
                                <th>Persentase Kehadiran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recapData as $index => $data)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="user-avatar me-3">
                                                <i class="fas fa-user-circle fa-2x text-secondary"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold">{{ $data['user']->name }}</div>
                                                <small class="text-muted">{{ $data['user']->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $data['user']->position->name ?? '-' }}</td>
                                    <td>{{ $data['user']->division->name ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $data['total_days'] }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success">{{ $data['present_days'] }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-danger">{{ $data['absent_days'] }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-warning">{{ $data['permission_days'] }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $data['late_days'] }}</span>
                                    </td>
                                    <td>
                                        @php
                                            $percentage = $data['total_days'] > 0 ? ($data['present_days'] / $data['total_days']) * 100 : 0;
                                        @endphp
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar 
                                                @if($percentage >= 90) bg-success
                                                @elseif($percentage >= 75) bg-warning
                                                @else bg-danger
                                                @endif" 
                                                role="progressbar" 
                                                style="width: {{ $percentage }}%">
                                                {{ number_format($percentage, 1) }}%
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Tidak ada data karyawan</h5>
                    <p class="text-muted">Tidak ditemukan data karyawan untuk periode yang dipilih</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Export Options -->
    <div class="card shadow">
        <div class="card-body">
            <h6 class="mb-3">Export Laporan</h6>
            <form action="{{ route('reports.recapitulation') }}" method="GET" class="d-inline">
                <input type="hidden" name="month" value="{{ $month }}">
                <input type="hidden" name="year" value="{{ $year }}">
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
.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}

.border-left-danger {
    border-left: 0.25rem solid #e74a3b !important;
}

.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
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

.progress {
    background-color: #e9ecef;
}
</style>
@endpush