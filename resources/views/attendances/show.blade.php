@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Back Button -->
    <div class="row mb-3">
        <div class="col-12">
            <a href="{{ route('attendances.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-2"></i>
                Kembali ke Daftar Absensi
            </a>
        </div>
    </div>

    <!-- Attendance Detail Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-gradient-primary text-white">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="attendance-icon-large me-3">
                                <i class="fas fa-clipboard-check"></i>
                            </div>
                            <div>
                                <h4 class="mb-1">{{ $attendance->title }}</h4>
                                <p class="mb-0 opacity-75">{{ $attendance->description }}</p>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="badge bg-light text-dark fs-6 px-3 py-2">
                                ID: {{ $attendance->id }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Time Information -->
                        <div class="col-md-6">
                            <h6 class="text-muted mb-3">
                                <i class="fas fa-clock me-2"></i>
                                Informasi Waktu
                            </h6>
                            <div class="time-info-grid">
                                <div class="time-card bg-success">
                                    <div class="time-icon">
                                        <i class="fas fa-sign-in-alt"></i>
                                    </div>
                                    <div class="time-content">
                                        <small>Waktu Masuk</small>
                                        <div class="fw-bold">{{ substr($attendance->start_time, 0, -3) }} - {{ substr($attendance->batas_start_time, 0, -3) }}</div>
                                    </div>
                                </div>
                                <div class="time-card bg-info">
                                    <div class="time-icon">
                                        <i class="fas fa-sign-out-alt"></i>
                                    </div>
                                    <div class="time-content">
                                        <small>Waktu Pulang</small>
                                        <div class="fw-bold">{{ substr($attendance->end_time, 0, -3) }} - {{ substr($attendance->batas_end_time, 0, -3) }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status Information -->
                        <div class="col-md-6">
                            <h6 class="text-muted mb-3">
                                <i class="fas fa-info-circle me-2"></i>
                                Status & Informasi
                            </h6>
                            <div class="info-list">
                                <div class="info-item">
                                    <span class="info-label">Status Saat Ini:</span>
                                    <span class="info-value">
                                        @php
                                            $now = now();
                                            $currentTime = $now->format('H:i');
                                        @endphp
                                        
                                        @if($currentTime >= $attendance->start_time && $currentTime <= $attendance->batas_end_time)
                                            <span class="badge bg-success">🟢 Aktif</span>
                                        @elseif($currentTime < $attendance->start_time)
                                            <span class="badge bg-warning">🟡 Belum Dimulai</span>
                                        @else
                                            <span class="badge bg-secondary">⚫ Selesai</span>
                                        @endif
                                    </span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">QR Code:</span>
                                    <span class="info-value">
                                        @if($attendance->code)
                                            <span class="badge bg-primary">
                                                <i class="fas fa-qrcode me-1"></i>
                                                Tersedia
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">
                                                <i class="fas fa-times me-1"></i>
                                                Tidak Tersedia
                                            </span>
                                        @endif
                                    </span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Tanggal Dibuat:</span>
                                    <span class="info-value">{{ $attendance->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Terakhir Diupdate:</span>
                                    <span class="info-value">{{ $attendance->updated_at->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Positions Assigned -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="fas fa-users me-2"></i>
                        Posisi yang Terdaftar
                    </h5>
                </div>
                <div class="card-body">
                    @php
                        $positions = $attendance->positions;
                    @endphp
                    
                    @if($positions->count() > 0)
                        <div class="row">
                            @foreach($positions as $position)
                            <div class="col-md-4 mb-3">
                                <div class="position-card">
                                    <div class="position-icon">
                                        <i class="fas fa-briefcase"></i>
                                    </div>
                                    <div class="position-info">
                                        <h6 class="mb-1">{{ $position->name }}</h6>
                                        <small class="text-muted">
                                            {{ $position->users->count() }} orang terdaftar
                                        </small>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                            <h6 class="text-muted">Tidak ada posisi yang terdaftar</h6>
                            <p class="text-muted">Silakan assign posisi untuk absensi ini</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stat-card bg-primary">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-content">
                    <h4>{{ $attendance->positions->sum(function($position) { return $position->users->count(); }) }}</h4>
                    <p>Total Karyawan</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card bg-success">
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-content">
                    <h4>{{ $attendance->presences()->whereDate('presence_date', today())->count() }}</h4>
                    <p>Hadir Hari Ini</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card bg-warning">
                <div class="stat-icon">
                    <i class="fas fa-file-medical"></i>
                </div>
                <div class="stat-content">
                    <h4>{{ $attendance->presences()->where('is_permission', true)->whereDate('presence_date', today())->count() }}</h4>
                    <p>Izin Hari Ini</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card bg-danger">
                <div class="stat-icon">
                    <i class="fas fa-user-times"></i>
                </div>
                <div class="stat-content">
                    @php
                        $totalUsers = $attendance->positions->sum(function($position) { return $position->users->count(); });
                        $presentToday = $attendance->presences()->whereDate('presence_date', today())->count();
                        $absentToday = $totalUsers - $presentToday;
                    @endphp
                    <h4>{{ $absentToday }}</h4>
                    <p>Tidak Hadir</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="fas fa-bolt me-2"></i>
                        Aksi Cepat
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <a href="{{ route('attendances.edit', $attendance->id) }}" class="btn btn-primary w-100 mb-2">
                                <i class="fas fa-edit me-2"></i>
                                Edit Absensi
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('presences.show', $attendance->id) }}" class="btn btn-info w-100 mb-2">
                                <i class="fas fa-chart-line me-2"></i>
                                Lihat Kehadiran
                            </a>
                        </div>
                        <div class="col-md-3">
                            @if($attendance->code)
                            <a href="{{ route('presences.qrcode', ['code' => $attendance->code]) }}" class="btn btn-success w-100 mb-2" target="_blank">
                                <i class="fas fa-qrcode me-2"></i>
                                Lihat QR Code
                            </a>
                            @else
                            <button class="btn btn-outline-secondary w-100 mb-2" disabled>
                                <i class="fas fa-qrcode me-2"></i>
                                QR Code Tidak Tersedia
                            </button>
                            @endif
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('presences.not-present', $attendance->id) }}" class="btn btn-warning w-100 mb-2">
                                <i class="fas fa-user-times me-2"></i>
                                Belum Absen
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('style')
<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
}

.attendance-icon-large {
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
}

.time-info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.time-card {
    border-radius: 12px;
    padding: 1rem;
    color: white;
    display: flex;
    align-items: center;
}

.time-icon {
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 0.75rem;
}

.time-content small {
    display: block;
    opacity: 0.8;
    font-size: 0.75rem;
}

.info-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.info-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0;
    border-bottom: 1px solid #f1f1f1;
}

.info-item:last-child {
    border-bottom: none;
}

.info-label {
    font-weight: 500;
    color: #6c757d;
}

.info-value {
    font-weight: 600;
}

.position-card {
    background: #f8f9fc;
    border-radius: 12px;
    padding: 1rem;
    display: flex;
    align-items: center;
    border: 1px solid #e3e6f0;
    transition: all 0.3s ease;
}

.position-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.position-icon {
    width: 40px;
    height: 40px;
    background: #4e73df;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    margin-right: 0.75rem;
}

.position-info h6 {
    color: #5a5c69;
    margin-bottom: 0.25rem;
}

.stat-card {
    border-radius: 12px;
    padding: 1.5rem;
    color: white;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.stat-icon {
    width: 50px;
    height: 50px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    margin-right: 1rem;
}

.stat-content h4 {
    margin: 0;
    font-size: 1.8rem;
    font-weight: bold;
}

.stat-content p {
    margin: 0;
    font-size: 0.9rem;
    opacity: 0.9;
}

@media (max-width: 768px) {
    .time-info-grid {
        grid-template-columns: 1fr;
    }
    
    .info-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.25rem;
    }
}
</style>
@endpush
@endsection