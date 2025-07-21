@extends('layouts.app')

@push('style')
<style>
    .attendance-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 15px;
        color: white;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .info-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        border: none;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        height: 100%;
    }
    
    .info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    }
    
    .info-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }
    
    .time-badge {
        background: linear-gradient(45deg, #28a745, #20c997);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-weight: 600;
        display: inline-block;
        margin: 0.25rem;
        text-decoration: none;
        transition: transform 0.2s ease;
    }
    
    .time-badge:hover {
        transform: scale(1.05);
        color: white;
    }
    
    .action-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        margin-top: 1.5rem;
    }
    
    .action-btn {
        padding: 0.75rem 1.5rem;
        border-radius: 25px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
    
    .btn-permission {
        background: linear-gradient(45deg, #17a2b8, #138496);
        color: white;
    }
    
    .btn-absent {
        background: linear-gradient(45deg, #dc3545, #c82333);
        color: white;
    }
    
    .btn-qrcode {
        background: linear-gradient(45deg, #28a745, #20c997);
        color: white;
    }
    
    .position-badge {
        background: linear-gradient(45deg, #6f42c1, #e83e8c);
        color: white;
        padding: 0.4rem 0.8rem;
        border-radius: 15px;
        font-size: 0.85rem;
        font-weight: 500;
        margin: 0.2rem;
        display: inline-block;
    }
    
    .presence-table-container {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        margin-top: 2rem;
    }
    
    .section-title {
        color: #2c3e50;
        font-weight: 700;
        margin-bottom: 1.5rem;
        position: relative;
        padding-bottom: 0.5rem;
    }
    
    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50px;
        height: 3px;
        background: linear-gradient(45deg, #667eea, #764ba2);
        border-radius: 2px;
    }
    
    @media (max-width: 768px) {
        .attendance-header {
            padding: 1.5rem;
            text-align: center;
        }
        
        .action-buttons {
            justify-content: center;
        }
        
        .info-card {
            margin-bottom: 1rem;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="attendance-header">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h2 class="mb-2 fw-bold">{{ $attendance->title }}</h2>
                <p class="mb-0 opacity-90">{{ $attendance->description }}</p>
                
                <!-- Status Badges -->
                <div class="mt-3">
                    @include('partials.attendance-badges')
                </div>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <div class="action-buttons">
                    <a href="{{ route('presences.permissions', $attendance->id) }}" class="action-btn btn-permission">
                        <i class="fas fa-file-alt"></i>
                        Ajukan Izin
                    </a>
                    <a href="{{ route('presences.not-present', $attendance->id) }}" class="action-btn btn-absent">
                        <i class="fas fa-user-times"></i>
                        Belum Absen
                    </a>
                    @if ($attendance->code)
                    <a href="{{ route('presences.qrcode', ['code' => $attendance->code]) }}" class="action-btn btn-qrcode">
                        <i class="fas fa-qrcode"></i>
                        QR Code
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Info Cards -->
    <div class="row mb-4">
        <div class="col-lg-6 mb-3">
            <div class="info-card">
                <div class="info-icon bg-success bg-opacity-10 text-success">
                    <i class="fas fa-clock"></i>
                </div>
                <h5 class="fw-bold text-dark mb-3">Jadwal Absensi</h5>
                
                <div class="mb-3">
                    <small class="text-muted fw-semibold d-block mb-2">Jam Masuk</small>
                    <div class="time-badge">
                        <i class="fas fa-sign-in-alt me-2"></i>
                        {{ $attendance->start_time }} - {{ $attendance->batas_start_time }}
                    </div>
                </div>
                
                <div>
                    <small class="text-muted fw-semibold d-block mb-2">Jam Pulang</small>
                    <div class="time-badge">
                        <i class="fas fa-sign-out-alt me-2"></i>
                        {{ $attendance->end_time }} - {{ $attendance->batas_end_time }}
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-6 mb-3">
            <div class="info-card">
                <div class="info-icon bg-primary bg-opacity-10 text-primary">
                    <i class="fas fa-users"></i>
                </div>
                <h5 class="fw-bold text-dark mb-3">Divisi / Jurusan</h5>
                
                <div class="d-flex flex-wrap">
                    @forelse ($attendance->positions as $position)
                        <span class="position-badge">
                            <i class="fas fa-tag me-1"></i>
                            {{ $position->name }}
                        </span>
                    @empty
                        <span class="text-muted">Tidak ada divisi yang ditentukan</span>
                    @endforelse
                </div>
                
                @if($attendance->positions->count() > 0)
                <div class="mt-3">
                    <small class="text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        Total {{ $attendance->positions->count() }} divisi terdaftar
                    </small>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Presence Table -->
    <div class="presence-table-container">
        <h4 class="section-title">
            <i class="fas fa-table me-2"></i>
            Data Kehadiran
        </h4>
        <livewire:presence-table attendanceId="{{ $attendance->id }}" />
    </div>
</div>
@endsection

@push('script')
<script src="{{ asset('jquery/jquery-3.6.0.min.js') }}"></script>
<script>
    // Add smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
    
    // Add loading state for action buttons
    document.querySelectorAll('.action-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const icon = this.querySelector('i');
            const originalClass = icon.className;
            icon.className = 'fas fa-spinner fa-spin';
            
            setTimeout(() => {
                icon.className = originalClass;
            }, 2000);
        });
    });
</script>
@endpush