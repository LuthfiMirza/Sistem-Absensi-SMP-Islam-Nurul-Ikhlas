@extends('layouts.app')

@section('content')

<!-- Welcome Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 bg-gradient-primary text-white">
            <div class="card-body text-center py-5">
                <img src="assets/img/smp-logo.png" style="width: 80px; height: 80px;" alt="Logo" class="mb-3">
                <h2 class="fw-bold mb-2">Selamat Datang di Sistem Absensi</h2>
                <h4 class="fw-light">SMP Islam Nurul Ikhlas</h4>
                <p class="mb-0 opacity-75">Kelola data absensi guru dan karyawan dengan mudah</p>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card border-left-primary h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Divisi
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $positionCount }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-building fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card border-left-success h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Guru
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $userCount }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-chalkboard-teacher fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card border-left-info h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Absensi Hari Ini
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">-</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card border-left-warning h-100">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Status Sistem
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Aktif</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-server fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Clock and Date -->
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-clock me-2"></i>Waktu Saat Ini
                </h6>
            </div>
            <div class="card-body text-center">
                <div id="date-and-clock">
                    <h3 id="clocknow" class="text-primary mb-2"></h3>
                    <h4 id="datenow" class="text-gray-600"></h4>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-info-circle me-2"></i>Informasi Sistem
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted">Versi Sistem:</small>
                    <div class="fw-bold">v1.0.0</div>
                </div>
                <div class="mb-3">
                    <small class="text-muted">Terakhir Update:</small>
                    <div class="fw-bold">{{ date('d F Y') }}</div>
                </div>
                <div class="mb-0">
                    <small class="text-muted">Status:</small>
                    <span class="badge bg-success">Online</span>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection 

@push('style')
<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
}

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

.text-xs {
    font-size: 0.7rem;
}

.font-weight-bold {
    font-weight: 700 !important;
}

.text-primary {
    color: #4e73df !important;
}

.text-success {
    color: #1cc88a !important;
}

.text-info {
    color: #36b9cc !important;
}

.text-warning {
    color: #f6c23e !important;
}

.text-gray-300 {
    color: #dddfeb !important;
}

#clocknow {
    font-family: 'Courier New', monospace;
    font-weight: bold;
}

#datenow {
    font-weight: 500;
}
</style>
@endpush

@push('script')
<script type="module" src="{{ asset('js/time.js') }}"></script>
@endpush