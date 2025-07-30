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
                                    <form action="{{ route('presences.present', $attendance->id) }}" method="post" class="d-inline present-form" data-user-id="{{ $user['id'] }}" data-user-name="{{ $user['name'] }}">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ $user['id'] }}">
                                        <input type="hidden" name="presence_date" value="{{ $data['not_presence_date'] }}">
                                        <button class="action-badge badge-present present-btn" type="submit">
                                            <i class="fas fa-check me-1"></i>
                                            <span class="btn-text">Tandai Hadir</span>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle present form submissions with AJAX
        const presentForms = document.querySelectorAll('.present-form');
        
        presentForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const userId = this.dataset.userId;
                const userName = this.dataset.userName;
                const submitBtn = this.querySelector('.present-btn');
                const btnText = submitBtn.querySelector('.btn-text');
                const btnIcon = submitBtn.querySelector('i');
                const tableRow = this.closest('tr');
                
                // Show confirmation dialog
                Swal.fire({
                    title: 'Konfirmasi Kehadiran',
                    text: `Apakah Anda yakin ingin menandai ${userName} sebagai hadir?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Tandai Hadir!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading state
                        submitBtn.disabled = true;
                        btnIcon.className = 'fas fa-spinner fa-spin me-1';
                        btnText.textContent = 'Memproses...';
                        
                        // Submit form via AJAX
                        const formData = new FormData(this);
                        
                        fetch(this.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Show success message
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: data.message || `${userName} berhasil ditandai hadir.`,
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                                
                                // Animate row removal
                                tableRow.style.transition = 'all 0.5s ease';
                                tableRow.style.backgroundColor = '#d4edda';
                                tableRow.style.transform = 'scale(0.95)';
                                tableRow.style.opacity = '0.7';
                                
                                setTimeout(() => {
                                    tableRow.style.height = '0';
                                    tableRow.style.padding = '0';
                                    tableRow.style.margin = '0';
                                    tableRow.style.border = 'none';
                                    
                                    setTimeout(() => {
                                        tableRow.remove();
                                        updateEmployeeCount();
                                        checkIfAllPresent();
                                    }, 300);
                                }, 1000);
                                
                            } else {
                                // Show error message
                                Swal.fire({
                                    title: 'Gagal!',
                                    text: data.message || 'Terjadi kesalahan saat menandai kehadiran.',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                                
                                // Reset button state
                                resetButtonState(submitBtn, btnIcon, btnText);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                title: 'Error!',
                                text: 'Terjadi kesalahan jaringan. Silakan coba lagi.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                            
                            // Reset button state
                            resetButtonState(submitBtn, btnIcon, btnText);
                        });
                    }
                });
            });
        });
        
        function resetButtonState(btn, icon, text) {
            btn.disabled = false;
            icon.className = 'fas fa-check me-1';
            text.textContent = 'Tandai Hadir';
        }
        
        function updateEmployeeCount() {
            const dateHeaders = document.querySelectorAll('.date-header');
            dateHeaders.forEach(header => {
                const table = header.nextElementSibling;
                const rows = table.querySelectorAll('tbody tr');
                const countElement = header.querySelector('.date-item:last-child .fw-bold');
                const newCount = rows.length;
                countElement.textContent = `${newCount} Karyawan`;
            });
        }
        
        function checkIfAllPresent() {
            const allTables = document.querySelectorAll('.absent-table tbody');
            let totalRows = 0;
            
            allTables.forEach(tbody => {
                totalRows += tbody.querySelectorAll('tr').length;
            });
            
            if (totalRows === 0) {
                // Show all present message
                setTimeout(() => {
                    const contentSection = document.querySelector('.container-fluid');
                    const emptyStateHTML = `
                        <div class="empty-state">
                            <i class="fas fa-check-circle"></i>
                            <h4 class="text-success mb-3">Semua Karyawan Sudah Absen!</h4>
                            <p class="text-muted mb-4">Semua karyawan telah berhasil ditandai hadir.</p>
                            <button onclick="window.location.reload()" class="btn btn-primary">
                                <i class="fas fa-refresh me-2"></i>
                                Refresh Halaman
                            </button>
                        </div>
                    `;
                    
                    // Remove existing content and show empty state
                    const existingContent = contentSection.querySelectorAll('.date-header, .absent-table');
                    existingContent.forEach(el => el.remove());
                    
                    contentSection.insertAdjacentHTML('beforeend', emptyStateHTML);
                }, 500);
            }
        }
        
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
        
        // Auto-refresh functionality (reduced frequency since we have real-time updates)
        function autoRefresh() {
            const refreshInterval = 600000; // 10 minutes (increased since we have AJAX)
            
            setTimeout(() => {
                if (confirm('Data akan diperbarui otomatis untuk sinkronisasi. Lanjutkan?')) {
                    window.location.reload();
                }
            }, refreshInterval);
        }
        
        // Start auto-refresh if there are absent employees
        if (document.querySelectorAll('.absent-table').length > 0) {
            autoRefresh();
        }
    });
</script>
@endpush