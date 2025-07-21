@extends('layouts.home')

@section('content')
<div class="container-fluid">
    <!-- Welcome Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="welcome-header">
                <div class="d-flex align-items-center mb-3">
                    @if(auth()->user()->role->name === 'guru')
                        <div class="welcome-icon bg-success">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                    @else
                        <div class="welcome-icon bg-info">
                            <i class="fas fa-user-tie"></i>
                        </div>
                    @endif
                    <div class="ms-3">
                        <h4 class="mb-1">Selamat Datang, {{ auth()->user()->name }}! 👋</h4>
                        <p class="text-muted mb-0">
                            @if(auth()->user()->role->name === 'guru')
                                🎓 Guru {{ auth()->user()->position->name ?? 'SMP Islam Nurul Ikhlas' }}
                            @else
                                👔 {{ auth()->user()->position->name ?? 'Karyawan' }} SMP Islam Nurul Ikhlas
                            @endif
                        </p>
                    </div>
                </div>
                <div class="current-time">
                    <i class="fas fa-clock me-2"></i>
                    <span id="current-time"></span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Daftar Absensi -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-gradient-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-calendar-check me-2"></i>
                        Daftar Absensi Hari Ini
                    </h5>
                    <small class="opacity-75">{{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</small>
                </div>
                <div class="card-body p-0">
                    @forelse ($attendances as $attendance)
                    <a href="{{ route('home.show', $attendance->id) }}" class="attendance-item">
                        <div class="d-flex align-items-center p-4">
                            <div class="attendance-icon">
                                <i class="fas fa-clipboard-check"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1 fw-bold">{{ $attendance->title }}</h6>
                                <p class="text-muted mb-2 small">{{ $attendance->description }}</p>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="time-badge">
                                        <i class="fas fa-clock me-1"></i>
                                        {{ $attendance->start_time }} - {{ $attendance->end_time }}
                                    </span>
                                </div>
                            </div>
                            <div class="attendance-status">
                                @include('partials.attendance-badges')
                                <i class="fas fa-chevron-right text-muted ms-2"></i>
                            </div>
                        </div>
                    </a>
                    @empty
                    <div class="text-center py-5">
                        <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                        <h6 class="text-muted">Tidak ada absensi hari ini</h6>
                        <p class="text-muted small">Silakan hubungi admin jika ada pertanyaan</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="row">
                <div class="col-md-6">
                    <div class="stat-card bg-success">
                        <div class="stat-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-content">
                            <h6>Kehadiran Bulan Ini</h6>
                            <h4>{{ \App\Models\Presence::where('user_id', auth()->id())->whereMonth('presence_date', now()->month)->count() }}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="stat-card bg-warning">
                        <div class="stat-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="stat-content">
                            <h6>Izin Bulan Ini</h6>
                            <h4>{{ \App\Models\Permission::where('user_id', auth()->id())->whereMonth('permission_date', now()->month)->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile & Info -->
        <div class="col-lg-4">
            <!-- Profile Card -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0">
                        <i class="fas fa-user me-2"></i>
                        Informasi Profil
                    </h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div class="profile-avatar">
                            <img src="/assets/img/profile.png" alt="Profile" class="rounded-circle">
                        </div>
                        <h6 class="mt-2 mb-1">{{ auth()->user()->name }}</h6>
                        @if(auth()->user()->role->name === 'guru')
                            <span class="badge bg-success">🎓 Guru</span>
                        @else
                            <span class="badge bg-info">👔 Karyawan</span>
                        @endif
                    </div>
                    
                    <div class="profile-info">
                        <div class="info-item">
                            <i class="fas fa-envelope text-primary"></i>
                            <div>
                                <small class="text-muted">Email</small>
                                <div>{{ auth()->user()->email }}</div>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-phone text-success"></i>
                            <div>
                                <small class="text-muted">Telepon</small>
                                <div>{{ auth()->user()->phone }}</div>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-briefcase text-info"></i>
                            <div>
                                <small class="text-muted">
                                    @if(auth()->user()->role->name === 'guru')
                                        Mata Pelajaran
                                    @else
                                        Divisi
                                    @endif
                                </small>
                                <div>{{ auth()->user()->position->name ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-calendar text-warning"></i>
                            <div>
                                <small class="text-muted">Bergabung</small>
                                <div>{{ auth()->user()->created_at->format('d M Y') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light">
                    <h6 class="mb-0">
                        <i class="fas fa-bolt me-2"></i>
                        Aksi Cepat
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if($attendances->count() > 0)
                            <a href="{{ route('home.show', $attendances->first()->id) }}" class="btn btn-primary">
                                <i class="fas fa-clipboard-check me-2"></i>
                                Lihat Absensi Aktif
                            </a>
                        @endif
                        <button class="btn btn-outline-secondary" onclick="location.reload()">
                            <i class="fas fa-sync-alt me-2"></i>
                            Refresh Halaman
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('style')
<style>
.welcome-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 15px;
    padding: 2rem;
    color: white;
    position: relative;
    overflow: hidden;
}

.welcome-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
}

.welcome-icon {
    width: 60px;
    height: 60px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
}

.current-time {
    background: rgba(255, 255, 255, 0.2);
    padding: 0.5rem 1rem;
    border-radius: 25px;
    font-weight: 500;
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
}

.attendance-item {
    display: block;
    text-decoration: none;
    color: inherit;
    border-bottom: 1px solid #f1f1f1;
    transition: all 0.3s ease;
}

.attendance-item:hover {
    background-color: #f8f9fc;
    color: inherit;
    text-decoration: none;
    transform: translateX(5px);
}

.attendance-item:last-child {
    border-bottom: none;
}

.attendance-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
}

.time-badge {
    background: #e3f2fd;
    color: #1976d2;
    padding: 0.25rem 0.75rem;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 500;
}

.stat-card {
    border-radius: 15px;
    padding: 1.5rem;
    color: white;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
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

.stat-content h6 {
    margin: 0;
    font-size: 0.9rem;
    opacity: 0.9;
}

.stat-content h4 {
    margin: 0;
    font-size: 1.8rem;
    font-weight: bold;
}

.profile-avatar img {
    width: 80px;
    height: 80px;
    object-fit: cover;
}

.profile-info {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.info-item i {
    width: 20px;
    text-align: center;
}

.info-item div small {
    display: block;
    font-size: 0.75rem;
}

.info-item div div {
    font-weight: 500;
    color: #333;
}

@media (max-width: 768px) {
    .welcome-header {
        padding: 1.5rem;
    }
    
    .welcome-icon {
        width: 50px;
        height: 50px;
        font-size: 1.2rem;
    }
    
    .stat-card {
        padding: 1rem;
    }
}
</style>
@endpush

@push('script')
<script>
function updateTime() {
    const now = new Date();
    const options = {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        timeZone: 'Asia/Jakarta'
    };
    
    document.getElementById('current-time').textContent = now.toLocaleDateString('id-ID', options);
}

// Update time immediately and then every second
updateTime();
setInterval(updateTime, 1000);
</script>
@endpush
@endsection