@extends('layouts.app')

@push('style')
<style>
    .permission-header {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
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
    
    .stats-card {
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
    
    .permission-table {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .permission-table .table {
        margin: 0;
    }
    
    .permission-table .table thead th {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        font-weight: 600;
        padding: 1rem;
    }
    
    .permission-table .table tbody td {
        padding: 1rem;
        vertical-align: middle;
        border-color: #f8f9fa;
    }
    
    .permission-table .table tbody tr:hover {
        background-color: #f8f9fa;
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
    
    .badge-accept {
        background: linear-gradient(45deg, #28a745, #20c997);
        color: white;
    }
    
    .badge-view {
        background: linear-gradient(45deg, #17a2b8, #138496);
        color: white;
    }
    
    .badge-accepted {
        background: linear-gradient(45deg, #28a745, #34ce57);
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
        color: #dee2e6;
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
    
    .modal-content {
        border-radius: 15px;
        border: none;
        box-shadow: 0 20px 60px rgba(0,0,0,0.2);
    }
    
    .modal-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 15px 15px 0 0;
        border: none;
    }
    
    .modal-header .btn-close {
        filter: invert(1);
    }
    
    @media (max-width: 768px) {
        .permission-header {
            padding: 1.5rem;
            text-align: center;
        }
        
        .stats-card {
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
    }
</style>
@endpush

@section('buttons')
<div class="btn-toolbar mb-2 mb-md-0">
    <div>
        <a href="{{ route('presences.show', $attendance->id) }}" class="back-btn">
            <i class="fas fa-arrow-left"></i>
            Kembali
        </a>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">
    @include('partials.alerts')

    <!-- Header Section -->
    <div class="permission-header">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h2 class="mb-2 fw-bold">
                    <i class="fas fa-file-alt me-2"></i>
                    Kelola Izin Karyawan
                </h2>
                <h4 class="mb-1 opacity-90">{{ $attendance->title }}</h4>
                <p class="mb-0 opacity-75">{{ $attendance->description }}</p>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <span class="badge bg-warning bg-opacity-20 text-warning fs-6 px-3 py-2">
                    <i class="fas fa-clock me-1"></i>
                    Menunggu Persetujuan
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

    <!-- Stats Section -->
    <div class="stats-card">
        <div class="row">
            <div class="col-md-4 stats-item">
                <h4>{{ \Carbon\Carbon::parse($date)->dayName }}</h4>
                <p>
                    {{ \Carbon\Carbon::parse($date)->isCurrentDay() ? 'Hari Ini' : 'Hari Dipilih' }}
                </p>
            </div>
            <div class="col-md-4 stats-item">
                <h4>{{ $date }}</h4>
                <p>Tanggal</p>
            </div>
            <div class="col-md-4 stats-item">
                <h4>{{ $permissions->count() }}</h4>
                <p>Total Pengajuan Izin</p>
            </div>
        </div>
    </div>

    <!-- Permissions Table -->
    @if (count($permissions) === 0)
        <div class="empty-state">
            <i class="fas fa-inbox"></i>
            <h4 class="text-muted mb-3">Tidak Ada Data Izin</h4>
            <p class="text-muted mb-4">Belum ada pengajuan izin untuk tanggal yang dipilih.</p>
            <a href="{{ route('presences.permissions', $attendance->id) }}" class="btn btn-primary">
                <i class="fas fa-calendar-day me-2"></i>
                Tampilkan Data Hari Ini
            </a>
        </div>
    @else
        <div class="permission-table">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col" width="5%">#</th>
                            <th scope="col" width="20%">
                                <i class="fas fa-user me-2"></i>
                                Nama Karyawan
                            </th>
                            <th scope="col" width="25%">
                                <i class="fas fa-envelope me-2"></i>
                                Kontak
                            </th>
                            <th scope="col" width="15%">
                                <i class="fas fa-briefcase me-2"></i>
                                Posisi
                            </th>
                            <th scope="col" width="35%">
                                <i class="fas fa-cogs me-2"></i>
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permissions as $permission)
                        <tr>
                            <th scope="row" class="fw-bold text-primary">{{ $loop->iteration }}</th>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold">{{ $permission->user->name }}</div>
                                        <small class="text-muted">ID: {{ $permission->user->id }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="contact-links">
                                <div class="mb-1">
                                    <i class="fas fa-envelope me-2 text-muted"></i>
                                    <a href="mailto:{{ $permission->user->email }}">{{ $permission->user->email }}</a>
                                </div>
                                <div>
                                    <i class="fas fa-phone me-2 text-muted"></i>
                                    <a href="tel:{{ $permission->user->phone }}">{{ $permission->user->phone }}</a>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-info bg-opacity-10 text-info px-3 py-2">
                                    {{ $permission->user->position->name }}
                                </span>
                            </td>
                            <td>
                                @if ($permission->is_accepted)
                                    <span class="action-badge badge-accepted">
                                        <i class="fas fa-check-circle me-1"></i>
                                        Sudah Diterima
                                    </span>
                                @else
                                    <form action="{{ route('presences.acceptPermission', $attendance->id) }}" method="post" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ $permission->user->id }}">
                                        <input type="hidden" name="permission_date" value="{{ $permission->permission_date }}">
                                        <button class="action-badge badge-accept" type="submit">
                                            <i class="fas fa-check me-1"></i>
                                            Terima
                                        </button>
                                    </form>
                                @endif
                                
                                <button class="action-badge badge-view permission-detail-modal-triggers"
                                    data-permission-id="{{ $permission->id }}" data-bs-toggle="modal"
                                    data-bs-target="#permission-detail-modal">
                                    <i class="fas fa-eye me-1"></i>
                                    Lihat Detail
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>

<!-- Permission Detail Modal -->
@if (count($permissions) !== 0)
<div class="modal fade" id="permission-detail-modal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-file-alt me-2"></i>
                    Detail Pengajuan Izin
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted">Judul Izin</label>
                            <div class="p-3 bg-light rounded">
                                <span id="permission-title" class="fw-bold"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted">Tanggal Izin</label>
                            <div class="p-3 bg-light rounded">
                                <span id="permission-date" class="fw-bold"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold text-muted">Keterangan Izin</label>
                    <div class="p-3 bg-light rounded">
                        <p id="permission-description" class="mb-0"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>
                    Tutup
                </button>
                <form action="{{ route('presences.acceptPermission', $attendance->id) }}" method="post" class="d-inline">
                    @csrf
                    <input type="hidden" name="user_id" id="modal-user-id">
                    <input type="hidden" name="permission_date" id="modal-permission-date">
                    <button class="btn btn-success" type="submit">
                        <i class="fas fa-check me-2"></i>
                        Terima Izin
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

@endsection

@push('script')
<script>
    const permissionUrl = "{{ route('api.permissions.show') }}";
    
    // Enhanced permission detail modal functionality
    document.addEventListener('DOMContentLoaded', function() {
        const modalTriggers = document.querySelectorAll('.permission-detail-modal-triggers');
        
        modalTriggers.forEach(trigger => {
            trigger.addEventListener('click', function() {
                const permissionId = this.getAttribute('data-permission-id');
                
                // Add loading state
                const modal = document.getElementById('permission-detail-modal');
                const titleElement = document.getElementById('permission-title');
                const descriptionElement = document.getElementById('permission-description');
                
                titleElement.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memuat...';
                descriptionElement.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memuat...';
                
                // Fetch permission details
                fetch(`${permissionUrl}?id=${permissionId}`)
                    .then(response => response.json())
                    .then(data => {
                        titleElement.textContent = data.title || 'Tidak ada judul';
                        descriptionElement.textContent = data.description || 'Tidak ada keterangan';
                        
                        // Update hidden form fields
                        document.getElementById('modal-user-id').value = data.user_id;
                        document.getElementById('modal-permission-date').value = data.permission_date;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        titleElement.textContent = 'Error memuat data';
                        descriptionElement.textContent = 'Terjadi kesalahan saat memuat data';
                    });
            });
        });
        
        // Add smooth animations
        const actionBadges = document.querySelectorAll('.action-badge');
        actionBadges.forEach(badge => {
            badge.addEventListener('click', function() {
                if (this.type === 'submit') {
                    const icon = this.querySelector('i');
                    const originalClass = icon.className;
                    icon.className = 'fas fa-spinner fa-spin me-1';
                    
                    setTimeout(() => {
                        icon.className = originalClass;
                    }, 2000);
                }
            });
        });
    });
</script>
<script src="{{ asset('js/presences/permissions.js') }}"></script>
@endpush