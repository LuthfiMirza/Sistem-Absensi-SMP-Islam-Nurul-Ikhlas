<header class="navbar navbar-dark navbar-expand-md">
    <div class="container-fluid px-0">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="{{ auth()->user()->isUser() ? route('home.index') : route('dashboard.index') }}">
            <img src="/assets/img/smp-logo.png" alt="logo" class="me-2">
            <span class="fw-bold">SMP Islam Nurul Ikhlas</span>
        </a>
        
        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler d-md-none" type="button"
            data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Right side content -->
        <div class="navbar-nav flex-row ms-auto me-3">
            <div class="nav-item text-nowrap">
                <span class="navbar-text">
                    <i class="fas fa-user-circle me-1"></i>
                    {{ auth()->user()->name }}
                </span>
            </div>
        </div>
    </div>
</header>