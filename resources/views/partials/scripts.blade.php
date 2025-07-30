{{-- Bootstrap 5.2 JS --}}
<script src="{{ asset('bootstrap5/js/bootstrap.bundle.min.js') }}"></script>

{{-- SweetAlert2 JS --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"
    integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous">
</script>

<script>
    feather.replace({ 'aria-hidden': 'true' })
    
    // Sidebar toggle functionality
    document.addEventListener('DOMContentLoaded', function() {
        const sidebarToggle = document.querySelector('.navbar-toggler');
        const sidebar = document.querySelector('#sidebarMenu');
        
        console.log('Sidebar toggle:', sidebarToggle);
        console.log('Sidebar element:', sidebar);
        
        if (sidebarToggle && sidebar) {
            sidebarToggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                sidebar.classList.toggle('show');
                console.log('Sidebar toggled, classes:', sidebar.className);
            });
            
            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(e) {
                if (window.innerWidth <= 767.98) {
                    if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                        sidebar.classList.remove('show');
                    }
                }
            });
            
            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth > 767.98) {
                    sidebar.classList.remove('show');
                }
            });
        } else {
            console.error('Sidebar toggle or sidebar element not found');
        }
        
        // Debug: Log current user role and check sidebar visibility
        console.log('Current page:', window.location.pathname);
        console.log('Sidebar should be visible for users');
    });
</script>

{{-- Main JS --}}
<script type="module" src="{{ asset('js/main.js') }}"></script>
{{-- Livewire JS --}}
@livewireScripts