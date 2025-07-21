@extends('layouts.home')

@section('content')
<div class="container py-4">
    <!-- Back Button -->
    <div class="row mb-3">
        <div class="col-12">
            <a href="{{ route('home.show', $attendance->id) }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-2"></i>
                Kembali ke Detail Absensi
            </a>
        </div>
    </div>

    <!-- Permission Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="permission-header">
                <div class="d-flex align-items-center mb-3">
                    <div class="permission-icon">
                        <i class="fas fa-file-medical"></i>
                    </div>
                    <div class="ms-3">
                        <h2 class="mb-1">Form Pengajuan Izin</h2>
                        <p class="text-muted mb-0">Silakan isi form di bawah untuk mengajukan izin kehadiran</p>
                    </div>
                </div>
                
                <!-- Attendance Info -->
                <div class="attendance-info">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="mb-1">{{ $attendance->title }}</h6>
                            <small class="opacity-75">{{ $attendance->description }}</small>
                        </div>
                        <div class="attendance-status">
                            @include('partials.attendance-badges')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Permission Form Card -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-gradient-warning text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-edit me-2"></i>
                        Formulir Izin Kehadiran
                    </h5>
                    <small class="opacity-75">{{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</small>
                </div>
                <div class="card-body">
                    <livewire:permission-form attendanceId="{{ $attendance->id }}">
                </div>
            </div>

            <!-- Information Card -->
            <div class="card shadow-sm border-0 mt-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Informasi Penting
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-primary">Ketentuan Izin:</h6>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="fas fa-check text-success me-2"></i>
                                    Izin harus diajukan sebelum waktu absensi berakhir
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check text-success me-2"></i>
                                    Alasan izin harus jelas dan dapat dipertanggungjawabkan
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check text-success me-2"></i>
                                    Izin akan diverifikasi oleh admin
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-primary">Jenis Izin yang Diterima:</h6>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="fas fa-thermometer-half text-danger me-2"></i>
                                    Sakit (dengan surat keterangan dokter)
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-home text-info me-2"></i>
                                    Keperluan keluarga mendesak
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-briefcase text-warning me-2"></i>
                                    Tugas dinas resmi
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="alert alert-warning mt-3">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Perhatian:</strong> Pengajuan izin yang tidak sesuai ketentuan dapat ditolak oleh admin.
                    </div>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="card shadow-sm border-0 mt-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0">
                        <i class="fas fa-phone me-2"></i>
                        Butuh Bantuan?
                    </h6>
                </div>
                <div class="card-body">
                    <p class="mb-3">Jika Anda mengalami kesulitan dalam mengajukan izin, silakan hubungi:</p>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="contact-item">
                                <i class="fas fa-user-tie text-primary me-2"></i>
                                <div>
                                    <strong>Admin Sekolah</strong>
                                    <div class="text-muted">Tata Usaha SMP Islam Nurul Ikhlas</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="contact-item">
                                <i class="fas fa-clock text-success me-2"></i>
                                <div>
                                    <strong>Jam Operasional</strong>
                                    <div class="text-muted">Senin - Jumat: 07:00 - 16:00</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('style')
<style>
.permission-header {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    border-radius: 15px;
    padding: 2rem;
    color: white;
    position: relative;
    overflow: hidden;
}

.permission-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
}

.permission-icon {
    width: 70px;
    height: 70px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    color: white;
}

.attendance-info {
    background: rgba(255, 255, 255, 0.15);
    border-radius: 12px;
    padding: 1rem;
    margin-top: 1.5rem;
}

.bg-gradient-warning {
    background: linear-gradient(135deg, #ffc107 0%, #ff8c00 100%);
}

.contact-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1rem;
}

.contact-item i {
    width: 20px;
    text-align: center;
}

@media (max-width: 768px) {
    .permission-header {
        padding: 1.5rem;
    }
    
    .permission-icon {
        width: 60px;
        height: 60px;
        font-size: 1.5rem;
    }
}
</style>
@endpush
@endsection