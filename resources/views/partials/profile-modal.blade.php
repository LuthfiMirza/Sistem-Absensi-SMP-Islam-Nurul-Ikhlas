<!-- Profile Modal -->
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="profileModalLabel">
                    <i class="fas fa-user-circle me-2"></i>
                    Profil Saya
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Profile Picture Section -->
                    <div class="col-md-4 text-center mb-4">
                        <div class="profile-picture-container">
                            <img src="/assets/img/profile.png" alt="Profile Picture" 
                                 class="rounded-circle profile-picture mb-3" 
                                 width="150" height="150">
                            <h5 class="fw-bold text-primary">{{ auth()->user()->name }}</h5>
                            <span class="badge bg-{{ auth()->user()->isGuru() ? 'success' : 'info' }} fs-6 px-3 py-2">
                                {{ auth()->user()->role->name }}
                            </span>
                        </div>
                    </div>
                    
                    <!-- Profile Information Section -->
                    <div class="col-md-8">
                        <div class="profile-info">
                            <h6 class="text-muted mb-3">
                                <i class="fas fa-info-circle me-2"></i>
                                Informasi Personal
                            </h6>
                            
                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <strong>
                                        <i class="fas fa-user me-2 text-primary"></i>
                                        Nama Lengkap
                                    </strong>
                                </div>
                                <div class="col-sm-8">
                                    {{ auth()->user()->name }}
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <strong>
                                        <i class="fas fa-envelope me-2 text-primary"></i>
                                        Email
                                    </strong>
                                </div>
                                <div class="col-sm-8">
                                    <a href="mailto:{{ auth()->user()->email }}" class="text-decoration-none">
                                        {{ auth()->user()->email }}
                                    </a>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <strong>
                                        <i class="fas fa-phone me-2 text-primary"></i>
                                        Nomor Telepon
                                    </strong>
                                </div>
                                <div class="col-sm-8">
                                    @if(auth()->user()->phone)
                                        <a href="tel:{{ auth()->user()->phone }}" class="text-decoration-none">
                                            {{ auth()->user()->phone }}
                                        </a>
                                    @else
                                        <span class="text-muted">Belum diisi</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <strong>
                                        <i class="fas fa-briefcase me-2 text-primary"></i>
                                        Posisi/Jabatan
                                    </strong>
                                </div>
                                <div class="col-sm-8">
                                    <span class="badge bg-light text-dark border px-3 py-2">
                                        {{ auth()->user()->position->name ?? 'Tidak ada posisi' }}
                                    </span>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <strong>
                                        <i class="fas fa-id-badge me-2 text-primary"></i>
                                        ID Karyawan
                                    </strong>
                                </div>
                                <div class="col-sm-8">
                                    <code class="bg-light px-2 py-1 rounded">{{ str_pad(auth()->user()->id, 4, '0', STR_PAD_LEFT) }}</code>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <strong>
                                        <i class="fas fa-calendar-plus me-2 text-primary"></i>
                                        Bergabung Sejak
                                    </strong>
                                </div>
                                <div class="col-sm-8">
                                    {{ auth()->user()->created_at->format('d F Y') }}
                                    <small class="text-muted">
                                        ({{ auth()->user()->created_at->diffForHumans() }})
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Statistics Section -->
                <div class="row mt-4">
                    <div class="col-12">
                        <h6 class="text-muted mb-3">
                            <i class="fas fa-chart-bar me-2"></i>
                            Statistik Kehadiran Bulan Ini
                        </h6>
                        
                        @php
                            $currentMonth = now()->format('Y-m');
                            $totalPresences = \App\Models\Presence::where('user_id', auth()->user()->id)
                                ->where('presence_date', 'like', $currentMonth . '%')
                                ->count();
                            
                            $totalPermissions = \App\Models\Presence::where('user_id', auth()->user()->id)
                                ->where('presence_date', 'like', $currentMonth . '%')
                                ->where('is_permission', true)
                                ->count();
                            
                            // Calculate work days more accurately
                            $startOfMonth = now()->startOfMonth();
                            $endOfMonth = now()->endOfMonth();
                            $totalWorkDays = 0;
                            
                            for ($date = $startOfMonth->copy(); $date->lte($endOfMonth); $date->addDay()) {
                                if (!$date->isWeekend()) {
                                    $totalWorkDays++;
                                }
                            }
                            
                            $attendanceRate = $totalWorkDays > 0 ? round(($totalPresences / $totalWorkDays) * 100, 1) : 0;
                        @endphp
                        
                        <div class="row text-center">
                            <div class="col-md-3 mb-3">
                                <div class="card border-0 bg-light">
                                    <div class="card-body py-3">
                                        <div class="text-primary">
                                            <i class="fas fa-calendar-check fa-2x mb-2"></i>
                                        </div>
                                        <h4 class="fw-bold text-primary mb-1">{{ $totalPresences }}</h4>
                                        <small class="text-muted">Total Kehadiran</small>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <div class="card border-0 bg-light">
                                    <div class="card-body py-3">
                                        <div class="text-warning">
                                            <i class="fas fa-file-medical fa-2x mb-2"></i>
                                        </div>
                                        <h4 class="fw-bold text-warning mb-1">{{ $totalPermissions }}</h4>
                                        <small class="text-muted">Total Izin</small>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <div class="card border-0 bg-light">
                                    <div class="card-body py-3">
                                        <div class="text-success">
                                            <i class="fas fa-percentage fa-2x mb-2"></i>
                                        </div>
                                        <h4 class="fw-bold text-success mb-1">{{ $attendanceRate }}%</h4>
                                        <small class="text-muted">Tingkat Kehadiran</small>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <div class="card border-0 bg-light">
                                    <div class="card-body py-3">
                                        <div class="text-info">
                                            <i class="fas fa-calendar-day fa-2x mb-2"></i>
                                        </div>
                                        <h4 class="fw-bold text-info mb-1">{{ $totalWorkDays }}</h4>
                                        <small class="text-muted">Hari Kerja</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer bg-light">
                <div class="d-flex justify-content-between w-100">
                    <div class="text-muted small">
                        <i class="fas fa-clock me-1"></i>
                        Terakhir diperbarui: {{ auth()->user()->updated_at->format('d/m/Y H:i') }}
                    </div>
                    <div>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>
                            Tutup
                        </button>
                        <form action="{{ route('auth.logout') }}" method="post" class="d-inline"
                              onsubmit="return confirm('Apakah anda yakin ingin keluar?')">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-sign-out-alt me-1"></i>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Profile Modal Styles */
#profileModal .modal-dialog {
    max-width: 900px;
    margin: 1.75rem auto;
}

#profileModal .modal-content {
    border: none;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    overflow: hidden;
}

#profileModal .modal-header {
    border-radius: 15px 15px 0 0;
    border-bottom: none;
    background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
}

#profileModal .modal-footer {
    border-radius: 0 0 15px 15px;
    border-top: 1px solid #dee2e6;
    background-color: #f8f9fa;
}

#profileModal .profile-picture {
    border: 4px solid #fff;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

#profileModal .profile-picture:hover {
    transform: scale(1.05);
}

#profileModal .profile-picture-container {
    position: relative;
}

#profileModal .card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    border: none;
    border-radius: 10px;
}

#profileModal .card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

#profileModal .profile-info .row {
    padding: 0.5rem 0;
    border-bottom: 1px solid #f8f9fa;
}

#profileModal .profile-info .row:last-child {
    border-bottom: none;
}

/* Ensure modal is properly centered */
#profileModal.modal {
    z-index: 1055;
}

#profileModal .modal-backdrop {
    z-index: 1050;
}

/* Better responsive design */
@media (max-width: 768px) {
    #profileModal .modal-dialog {
        margin: 0.5rem;
        max-width: calc(100% - 1rem);
    }
    
    #profileModal .profile-picture {
        width: 120px !important;
        height: 120px !important;
    }
    
    #profileModal .row .col-sm-4,
    #profileModal .row .col-sm-8 {
        margin-bottom: 0.5rem;
    }
    
    #profileModal .modal-body {
        padding: 1rem;
    }
    
    #profileModal .modal-footer {
        padding: 0.75rem;
    }
    
    #profileModal .modal-footer .d-flex {
        flex-direction: column;
        gap: 1rem;
    }
    
    #profileModal .modal-footer .text-muted {
        text-align: center;
        order: 2;
    }
    
    #profileModal .modal-footer > div > div:last-child {
        order: 1;
        text-align: center;
    }
}

/* Animation for modal */
#profileModal.fade .modal-dialog {
    transform: translate(0, -50px);
    transition: transform 0.3s ease-out;
}

#profileModal.show .modal-dialog {
    transform: translate(0, 0);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Ensure profile modal works properly
    const profileModal = document.getElementById('profileModal');
    const profileBtn = document.querySelector('.profile-btn');
    
    if (profileBtn && profileModal) {
        // Add click event listener to profile button
        profileBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            // Create Bootstrap modal instance
            const modal = new bootstrap.Modal(profileModal, {
                backdrop: true,
                keyboard: true,
                focus: true
            });
            
            // Show the modal
            modal.show();
        });
        
        // Add animation when modal is shown
        profileModal.addEventListener('shown.bs.modal', function() {
            profileModal.querySelector('.modal-dialog').style.transform = 'translate(0, 0)';
        });
        
        // Reset animation when modal is hidden
        profileModal.addEventListener('hidden.bs.modal', function() {
            profileModal.querySelector('.modal-dialog').style.transform = 'translate(0, -50px)';
        });
    }
    
    // Debug: Log if elements are found
    console.log('Profile button found:', !!profileBtn);
    console.log('Profile modal found:', !!profileModal);
    console.log('Bootstrap available:', typeof bootstrap !== 'undefined');
});
</script>