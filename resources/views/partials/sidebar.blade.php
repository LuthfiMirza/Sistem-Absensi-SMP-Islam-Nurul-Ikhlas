<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
    <div class="position-sticky pt-3">
        <!-- User Profile Section -->
        <div class="user-profile mb-4 px-3">
            <div class="d-flex align-items-center">
                <div class="profile-img me-3">
                    <img src="/assets/img/profile.png" alt="Profile" class="rounded-circle" width="40" height="40">
                </div>
                <div class="profile-info">
                    <h6 class="mb-0 text-white">{{ auth()->user()->name }}</h6>
                    <small class="text-light opacity-75">{{ auth()->user()->role->name }}</small>
                </div>
            </div>
        </div>

        <!-- Navigation Menu -->
        <ul class="nav flex-column px-2">
            @if (auth()->user()->isAdmin() or auth()->user()->isOperator())
                <!-- Admin/Operator Menu -->
                <li class="nav-item mb-1">
                    <a class="nav-link {{ request()->routeIs('dashboard.*') ? 'active' : '' }}" 
                       href="{{ route('dashboard.index') }}">
                        <i class="fas fa-tachometer-alt me-3"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ request()->routeIs('positions.*') ? 'active' : '' }}"
                       href="{{ route('positions.index') }}">
                        <i class="fas fa-sitemap me-3"></i>
                        <span>Divisi Pegawai</span>
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ request()->routeIs('employees.*') ? 'active' : '' }}"
                       href="{{ route('employees.index') }}">
                        <i class="fas fa-users me-3"></i>
                        <span>Pegawai</span>
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ request()->routeIs('attendances.*') ? 'active' : '' }}"
                       href="{{ route('attendances.index') }}">
                        <i class="fas fa-calendar-check me-3"></i>
                        <span>Absensi</span>
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ request()->routeIs('presences.*') ? 'active' : '' }}"
                       href="{{ route('presences.index') }}">
                        <i class="fas fa-chart-line me-3"></i>
                        <span>Data Kehadiran</span>
                    </a>
                </li>
            @endif

            @if (auth()->user()->isUser())
                <!-- Guru/Karyawan Menu -->
                <li class="nav-item mb-1">
                    <a class="nav-link {{ request()->routeIs('home.index') ? 'active' : '' }}" 
                       href="{{ route('home.index') }}">
                        <i class="fas fa-home me-3"></i>
                        <span>Beranda</span>
                    </a>
                </li>
                
                <!-- Absensi Section -->
                <li class="nav-item mb-2">
                    <div class="nav-section-header px-3 py-2">
                        <small class="text-light opacity-75 fw-bold">ABSENSI</small>
                    </div>
                </li>
                
                @php
                    // Get available attendances for current user
                    $availableAttendances = \App\Models\Attendance::whereHas('positions', function($query) {
                        $query->where('position_id', auth()->user()->position_id);
                    })->get();
                @endphp
                
                @forelse($availableAttendances as $attendance)
                    <li class="nav-item mb-1">
                        <a class="nav-link {{ request()->routeIs('home.show') && request()->route('attendance')?->id == $attendance->id ? 'active' : '' }}"
                           href="{{ route('home.show', $attendance->id) }}">
                            <i class="fas fa-calendar-day me-3"></i>
                            <span>{{ $attendance->title }}</span>
                        </a>
                    </li>
                @empty
                    <li class="nav-item mb-1">
                        <div class="nav-link text-muted">
                            <i class="fas fa-info-circle me-3"></i>
                            <span>Tidak ada absensi tersedia</span>
                        </div>
                    </li>
                @endforelse
        
                <!-- Quick Actions Section -->
                <li class="nav-item mb-2 mt-3">
                    <div class="nav-section-header px-3 py-2">
                        <small class="text-light opacity-75 fw-bold">AKSI CEPAT</small>
                    </div>
                </li>
                
                @if($availableAttendances->count() > 0)
                    @php $firstAttendance = $availableAttendances->first(); @endphp
                    
                    <li class="nav-item mb-1">
                        <a class="nav-link {{ request()->routeIs('home.permission') ? 'active' : '' }}"
                           href="{{ route('home.permission', $firstAttendance->id) }}">
                            <i class="fas fa-file-medical me-3"></i>
                            <span>Ajukan Izin</span>
                        </a>
                    </li>
                    
                    @if($firstAttendance->code)
                        <li class="nav-item mb-1">
                            <a class="nav-link" 
                               href="{{ route('presences.qrcode', ['code' => $firstAttendance->code]) }}"
                               target="_blank">
                                <i class="fas fa-qrcode me-3"></i>
                                <span>QR Code Absensi</span>
                                <i class="fas fa-external-link-alt ms-2 small"></i>
                            </a>
                        </li>
                    @endif
                @endif

                <!-- Izin Section -->
                <li class="nav-item mb-2 mt-3">
                    <div class="nav-section-header px-3 py-2">
                        <small class="text-light opacity-75 fw-bold">IZIN</small>
                    </div>
                </li>
                
                <li class="nav-item mb-1">
                    <a class="nav-link {{ request()->routeIs('my-permissions.*') ? 'active' : '' }}"
                       href="{{ route('my-permissions.index') }}">
                        <i class="fas fa-list me-3"></i>
                        <span>Data Izin Saya</span>
                    </a>
                </li>
                
                @if(auth()->user()->isKaryawan())
                    <li class="nav-item mb-1">
                        <a class="nav-link {{ request()->routeIs('my-permissions.create') ? 'active' : '' }}"
                           href="{{ route('my-permissions.create') }}">
                            <i class="fas fa-plus me-3"></i>
                            <span>Ajukan Izin Baru</span>
                        </a>
                    </li>
                @endif

                <!-- Profile Section -->
                <li class="nav-item mb-2 mt-3">
                    <div class="nav-section-header px-3 py-2">
                        <small class="text-light opacity-75 fw-bold">PROFIL</small>
                    </div>
                </li>
                
                <li class="nav-item mb-1">
                    <a class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}"
                       href="{{ route('profile.index') }}">
                        <i class="fas fa-user me-3"></i>
                        <span>Profil Saya</span>
                    </a>
                </li>
            @endif

            @if (auth()->user()->isAdmin() or auth()->user()->isOperator())
                <!-- Admin Menu Additions -->
                
                <li class="nav-item mb-1">
                    <a class="nav-link {{ request()->routeIs('permissions.*') ? 'active' : '' }}"
                       href="{{ route('permissions.index') }}">
                        <i class="fas fa-file-signature me-3"></i>
                        <span>Kelola Izin</span>
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}"
                       href="{{ route('reports.index') }}">
                        <i class="fas fa-chart-bar me-3"></i>
                        <span>Laporan</span>
                    </a>
                </li>
                
                <!-- Profile Section for Admin -->
                <li class="nav-item mb-2 mt-3">
                    <div class="nav-section-header px-3 py-2">
                        <small class="text-light opacity-75 fw-bold">PROFIL</small>
                    </div>
                </li>
                
                <li class="nav-item mb-1">
                    <a class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}"
                       href="{{ route('profile.index') }}">
                        <i class="fas fa-user me-3"></i>
                        <span>Profil Saya</span>
                    </a>
                </li>
            @endif
        </ul>

        <!-- Logout Button -->
        <div class="mt-auto px-3 pb-3">
            <form action="{{ route('auth.logout') }}" method="post"
                onsubmit="return confirm('Apakah anda yakin ingin keluar?')">
                @method('DELETE')
                @csrf
                <button class="btn btn-outline-light btn-sm w-100 logout-btn">
                    <i class="fas fa-sign-out-alt me-2"></i>
                    Keluar
                </button>
            </form>
        </div>
    </div>
</nav>