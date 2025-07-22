@extends('layouts.app')

@push('style')
<style>
    .absent-header {
        background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 50%, #fecfef 100%);
        border-radius: 15px;
        color: white;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .filter-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        border: none;
        margin-bottom: 2rem;
    }
    
    .date-stats-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 12px;
        color: white;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .stats-item {
        text-align: center;
        padding: 1rem;
    }
    
    .stats-item h4 {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .stats-item p {
        margin: 0;
        opacity: 0.9;
        font-size: 0.9rem;
    }
    
    .absent-table {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        margin-bottom: 2rem;
    }
    
    .absent-table .table {
        margin: 0;
    }
    
    .absent-table .table thead th {
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
        color: white;
        border: none;
        font-weight: 600;
        padding: 1rem;
    }
    
    .absent-table .table tbody td {
        padding: 1rem;
        vertical-align: middle;
        border-color: #f8f9fa;
    }
    
    .absent-table .table tbody tr:hover {
        background-color: #fff5f5;
    }
    
    .action-badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        margin: 0.2rem;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }
    
    .action-badge:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
    
    .badge-present {
        background: linear-gradient(45deg, #28a745, #20c997);
        color: white;
    }
    
    .contact-links a {
        color: #667eea;
        text-decoration: none;
        font-weight: 500;
    }
    
    .contact-links a:hover {
        color: #764ba2;
        text-decoration: underline;
    }
    
    .empty-state {
        text-align: center;
        padding: 3rem;
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }
    
    .empty-state i {
        font-size: 4rem;
        color: #28a745;
        margin-bottom: 1rem;
    }
    
    .back-btn {
        background: linear-gradient(45deg, #6c757d, #495057);
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 25px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        margin-bottom: 2rem;
    }
    
    .back-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        color: white;
    }
    
    .filter-form .form-control {
        border-radius: 10px;
        border: 2px solid #e9ecef;
        padding: 0.75rem;
        transition: all 0.3s ease;
    }
    
    .filter-form .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    
    .filter-form .btn {
        border-radius: 10px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        background: linear-gradient(45deg, #667eea, #764ba2);
        border: none;
    }
    
    .date-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 10px;
        margin-bottom: 1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .date-info {
        display: flex;
        align-items: center;
        gap: 2rem;
        flex-wrap: wrap;
    }
    
    .date-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .date-item i {
        opacity: 0.8;
    }
    
    @media (max-width: 768px) {
        .absent-header {
            padding: 1.5rem;
            text-align: center;
        }
        
        .date-stats-card {
            text-align: center;
        }
        
        .stats-item {
            margin-bottom: 1rem;
        }
        
        .table-responsive {
            font-size: 0.9rem;
        }
        
        .action-badge {
            font-size: 0.8rem;
            padding: 0.4rem 0.8rem;
        }
        
        .date-header {
            text-align: center;
        }
        
        .date-info {
            justify-content: center;
        }
    }
</style>
@endpush

@section('buttons')
<div class="btn-toolbar mb-2 mb-md-0">
    <div>
        @if(auth()->user()->isOperator())
            <a href="{{ route('presences.show', $attendance->id) }}" class="back-btn">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
        @else
            <a href="{{ route('home.detail', $attendance->id) }}" class="back-btn">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
        @endif
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">
    @include('partials.alerts')

    <!-- Header Section -->
    <div class="absent-header">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h2 class="mb-2 fw-bold">
                    <i class="fas fa-user-times me-2"></i>
                    Daftar Karyawan Belum Absen
                </h2>
                <h4 class="mb-1 opacity-90">{{ $attendance->title }}</h4>
                <p class="mb-0 opacity-75">{{ $attendance->description }}</p>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <span class="badge bg-danger bg-opacity-20 text-danger fs-6 px-3 py-2">
                    <i class="fas fa-exclamation-triangle me-1"></i>
                    Belum Hadir
                </span>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-card">
        <form action="" method="get" class="filter-form">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <label for="filterDate" class="form-label fw-bold text-dark">
                        <i class="fas fa-calendar-alt me-2"></i>
                        Filter Berdasarkan Tanggal
                    </label>
                    <input type="date" class="form-control" id="filterDate" name="display-by-date"
                        value="{{ request('display-by-date') }}">
                </div>
                <div class="col-lg-4 mt-3 mt-lg-0">
                    <button class="btn btn-primary w-100" type="submit">
                        <i class="fas fa-search me-2"></i>
                        Tampilkan Data
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Content Section -->
    @if (count($notPresentData) === 0)
        <div class="empty-state">
            <i class="fas fa-check-circle"></i>
            <h4 class="text-success mb-3">Semua Karyawan Sudah Absen!</h4>
            <p class="text-muted mb-4">Tidak ada karyawan yang belum melakukan absensi untuk tanggal yang dipilih.</p>
            @if(auth()->user()->isOperator())
                <a href="{{ route('presences.not-present', $attendance->id) }}" class="btn btn-primary">
                    <i class="fas fa-calendar-day me-2"></i>
                    Tampilkan Data Hari Ini
                </a>
            @else
                <a href="{{ route('home.not-present', $attendance->id) }}" class="btn btn-primary">
                    <i class="fas fa-calendar-day me-2"></i>
                    Tampilkan Data Hari Ini
                </a>
            @endif
        </div>
    @else
        @foreach ($notPresentData as $data)
            <!-- Date Header -->
            <div class="date-header">
                <div class="date-info">
                    <div class="date-item">
                        <i class="fas fa-calendar-day"></i>
                        <span class="fw-bold">
                            {{ \Carbon\Carbon::parse($data['not_presence_date'])->dayName }}
                            {{ \Carbon\Carbon::parse($data['not_presence_date'])->isCurrentDay() ? '(Hari ini)' : '' }}
                        </span>
                    </div>
                    <div class="date-item">
                        <i class="fas fa-calendar"></i>
                        <span class="fw-bold">{{ $data['not_presence_date'] }}</span>
                    </div>
                </div>
                <div class="date-item">
                    <i class="fas fa-users"></i>
                    <span class="fw-bold">{{ count($data['users']) }} Karyawan</span>
                </div>
            </div>

            <!-- Absent Table -->
            <div class="absent-table">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col" width="5%">#</th>
                                <th scope="col" width="{{ auth()->user()->isOperator() ? '20%' : '25%' }}">
                                    <i class="fas fa-user me-2"></i>
                                    Nama Karyawan
                                </th>
                                <th scope="col" width="{{ auth()->user()->isOperator() ? '30%' : '35%' }}">
                                    <i class="fas fa-envelope me-2"></i>
                                    Kontak
                                </th>
                                <th scope="col" width="{{ auth()->user()->isOperator() ? '20%' : '35%' }}">
                                    <i class="fas fa-briefcase me-2"></i>
                                    Posisi
                                </th>
                                @if(auth()->user()->isOperator())
                                <th scope="col" width="25%">
                                    <i class="fas fa-cogs me-2"></i>
                                    Aksi
                                </th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['users'] as $user)
                            <tr>
                                <th scope="row" class="fw-bold text-danger">{{ $loop->iteration }}</th>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-danger bg-opacity-10 text-danger rounded-circle d-flex align-items-center justify-content-center me-3">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold">{{ $user['name'] }}</div>
                                            <small class="text-muted">ID: {{ $user['id'] }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="contact-links">
                                    <div class="mb-1">
                                        <i class="fas fa-envelope me-2 text-muted"></i>
                                        <a href="mailto:{{ $user['email'] }}">{{ $user['email'] }}</a>
                                    </div>
                                    <div>
                                        <i class="fas fa-phone me-2 text-muted"></i>
                                        <a href="tel:{{ $user['phone'] }}">{{ $user['phone'] }}</a>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info bg-opacity-10 text-info px-3 py-2">
                                        {{ $user['position']['name'] }}
                                    </span>
                                </td>
                                @if(auth()->user()->isOperator())
                                <td>
                                    <form action="{{ route('presences.present', $attendance->id) }}" method="post" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ $user['id'] }}">
                                        <input type="hidden" name="presence_date" value="{{ $data['not_presence_date'] }}">
                                        <button class="action-badge badge-present" type="submit" 
                                                onclick="return confirm('Apakah Anda yakin ingin menandai {{ $user['name'] }} sebagai hadir?')">
                                            <i class="fas fa-check me-1"></i>
                                            Tandai Hadir
                                        </button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection

@push('script')
<script>
    // Add loading state for action buttons
    document.addEventListener('DOMContentLoaded', function() {
        const actionBadges = document.querySelectorAll('.action-badge');
        
        actionBadges.forEach(badge => {
            badge.addEventListener('click', function(e) {
                if (this.type === 'submit') {
                    const icon = this.querySelector('i');
                    const originalClass = icon.className;
                    const originalText = this.innerHTML;
                    
                    // Show loading state
                    this.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Memproses...';
                    this.disabled = true;
                    
                    // Reset after form submission
                    setTimeout(() => {
                        this.innerHTML = originalText;
                        this.disabled = false;
                    }, 3000);
                }
            });
        });
        
        // Add smooth animations
        const tables = document.querySelectorAll('.absent-table');
        tables.forEach((table, index) => {
            table.style.opacity = '0';
            table.style.transform = 'translateY(20px)';
            table.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            
            setTimeout(() => {
                table.style.opacity = '1';
                table.style.transform = 'translateY(0)';
            }, index * 200);
        });
    });
    
    // Auto-refresh functionality
    function autoRefresh() {
        const refreshInterval = 300000; // 5 minutes
        
        setTimeout(() => {
            if (confirm('Data akan diperbarui otomatis. Lanjutkan?')) {
                window.location.reload();
            }
        }, refreshInterval);
    }
    
    // Start auto-refresh if there are absent employees
    if (document.querySelectorAll('.absent-table').length > 0) {
        autoRefresh();
    }
</script>
@endpush