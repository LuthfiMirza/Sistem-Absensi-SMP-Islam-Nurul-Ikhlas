@extends('layouts.home')

@section('content')
<div class="container py-4">
    <!-- Back Button -->
    <div class="row mb-3">
        <div class="col-12">
            <a href="{{ route('home.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-2"></i>
                Kembali ke Beranda
            </a>
        </div>
    </div>

    <!-- Attendance Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="attendance-header">
                <div class="d-flex align-items-start justify-content-between mb-3">
                    <div class="flex-grow-1">
                        <div class="d-flex align-items-center mb-2">
                            <div class="attendance-icon-large">
                                <i class="fas fa-clipboard-check"></i>
                            </div>
                            <div class="ms-3">
                                <h2 class="mb-1">{{ $attendance->title }}</h2>
                                <p class="text-muted mb-0">{{ $attendance->description }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="attendance-status-large">
                        @include('partials.attendance-badges')
                    </div>
                </div>

                <!-- Time Info -->
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
        </div>
    </div>

    @include('partials.alerts')

    <div class="row">
        <!-- Absensi Form -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-gradient-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-fingerprint me-2"></i>
                        Form Absensi
                    </h5>
                    <small class="opacity-75">{{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</small>
                </div>
                <div class="card-body">
                    @if (!$attendance->data->is_using_qrcode)
                        <livewire:presence-form :attendance="$attendance" :data="$data" :holiday="$holiday">
                    @else
                        @include('home.partials.qrcode-presence')
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow-sm border-0 mt-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0">
                        <i class="fas fa-bolt me-2"></i>
                        Aksi Cepat
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('home.permission', $attendance->id) }}" class="btn btn-warning">
                            <i class="fas fa-file-medical me-2"></i>
                            Ajukan Izin
                        </a>
                        <button class="btn btn-outline-secondary" onclick="location.reload()">
                            <i class="fas fa-sync-alt me-2"></i>
                            Refresh Status
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- History -->
        <div class="col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-history me-2"></i>
                        Riwayat Kehadiran
                    </h5>
                    <span class="badge bg-primary">30 Hari Terakhir</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center" width="50">#</th>
                                    <th>Tanggal</th>
                                    <th class="text-center">Masuk</th>
                                    <th class="text-center">Pulang</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($priodDate as $date)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    @php
                                    $histo = $history->where('presence_date', $date)->first();
                                    $isToday = $date == now()->toDateString();
                                    @endphp
                                    
                                    @if (!$histo)
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-calendar text-muted me-2"></i>
                                            <div>
                                                <div class="fw-medium">{{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</div>
                                                <small class="text-muted">{{ \Carbon\Carbon::parse($date)->locale('id')->isoFormat('dddd') }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td colspan="3" class="text-center">
                                        @if($isToday)
                                            <span class="badge bg-info">
                                                <i class="fas fa-clock me-1"></i>
                                                Belum Hadir
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                <i class="fas fa-times me-1"></i>
                                                Tidak Hadir
                                            </span>
                                        @endif
                                    </td>
                                    @else
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-calendar-check text-success me-2"></i>
                                            <div>
                                                <div class="fw-medium">{{ \Carbon\Carbon::parse($histo->presence_date)->format('d/m/Y') }}</div>
                                                <small class="text-muted">{{ \Carbon\Carbon::parse($histo->presence_date)->locale('id')->isoFormat('dddd') }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="time-badge bg-success">
                                            {{ substr($histo->presence_enter_time, 0, -3) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if($histo->presence_out_time)
                                            <span class="time-badge bg-info">
                                                {{ substr($histo->presence_out_time, 0, -3) }}
                                            </span>
                                        @else
                                            <span class="badge bg-warning">
                                                <i class="fas fa-exclamation-triangle me-1"></i>
                                                Belum Pulang
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($histo->is_permission)
                                            <span class="badge bg-warning">
                                                <i class="fas fa-file-medical me-1"></i>
                                                Izin
                                            </span>
                                        @else
                                            <span class="badge bg-success">
                                                <i class="fas fa-check me-1"></i>
                                                Hadir
                                            </span>
                                        @endif
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Summary Footer -->
                <div class="card-footer bg-light">
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="summary-item">
                                <div class="fw-bold text-success">{{ $history->count() }}</div>
                                <small class="text-muted">Hadir</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="summary-item">
                                <div class="fw-bold text-warning">{{ $history->where('is_permission', true)->count() }}</div>
                                <small class="text-muted">Izin</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="summary-item">
                                <div class="fw-bold text-danger">{{ count($priodDate) - $history->count() }}</div>
                                <small class="text-muted">Tidak Hadir</small>
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
.attendance-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 15px;
    padding: 2rem;
    color: white;
    position: relative;
    overflow: hidden;
}

.attendance-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
}

.attendance-icon-large {
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

.attendance-status-large .badge {
    font-size: 0.9rem;
    padding: 0.5rem 1rem;
}

.time-info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
    margin-top: 1.5rem;
}

.time-card {
    background: rgba(255, 255, 255, 0.15);
    border-radius: 12px;
    padding: 1rem;
    display: flex;
    align-items: center;
    color: white;
}

.time-icon {
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 10px;
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

.bg-gradient-primary {
    background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
}

.time-badge {
    padding: 0.25rem 0.5rem;
    border-radius: 8px;
    font-size: 0.8rem;
    font-weight: 500;
    color: white;
}

.summary-item {
    padding: 0.5rem;
}

.table th {
    font-weight: 600;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-top: none;
}

.table-hover tbody tr:hover {
    background-color: rgba(78, 115, 223, 0.05);
}

@media (max-width: 768px) {
    .attendance-header {
        padding: 1.5rem;
    }
    
    .attendance-icon-large {
        width: 60px;
        height: 60px;
        font-size: 1.5rem;
    }
    
    .time-info-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush
@endsection