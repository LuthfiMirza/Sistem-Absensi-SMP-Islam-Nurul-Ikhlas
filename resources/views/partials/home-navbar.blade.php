<nav class="navbar navbar-expand-md navbar-dark py-3 shadow-sm" style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);">
    <div class="container">
        <a class="navbar-brand bg-transparent fw-bold d-flex align-items-center" href="{{ route('home.index') }}">
            <img src="/assets/img/smp-logo.png" alt="logo" style="height:40px" class="me-2">
            <div>
                <div class="fw-bold">SMP Islam Nurul Ikhlas</div>
                <small class="opacity-75" style="font-size: 0.7rem;">Sistem Absensi Digital</small>
            </div>
        </a>
        
        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
            <ul class="navbar-nav align-items-md-center gap-md-3 py-2 py-md-0">
                <li class="nav-item px-3 py-1 px-md-0 py-md-0">
                    <a class="nav-link {{ request()->routeIs('home.index') ? 'active fw-bold' : '' }}" 
                       href="{{ route('home.index') }}">
                        <i class="fas fa-home me-1"></i>
                        Beranda
                    </a>
                </li>
                
                <!-- User Info -->
                <li class="nav-item dropdown px-3 py-1 px-md-0 py-md-0">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" 
                       data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="/assets/img/profile.png" alt="Profile" class="rounded-circle me-2" 
                             style="width: 32px; height: 32px;">
                        <div class="d-none d-md-block">
                            <div style="font-size: 0.85rem;">{{ auth()->user()->name }}</div>
                            <small class="opacity-75" style="font-size: 0.7rem;">
                                @if(auth()->user()->role->name === 'guru')
                                    🎓 Guru
                                @else
                                    👔 Karyawan
                                @endif
                            </small>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <div class="dropdown-header">
                                <strong>{{ auth()->user()->name }}</strong>
                                <br>
                                <small class="text-muted">{{ auth()->user()->email }}</small>
                            </div>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('home.index') }}">
                                <i class="fas fa-user me-2"></i>
                                Profil Saya
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('auth.logout') }}" method="post" class="d-inline">
                                @method('DELETE')
                                @csrf
                                <button class="dropdown-item text-danger" type="submit">
                                    <i class="fas fa-sign-out-alt me-2"></i>
                                    Keluar
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>