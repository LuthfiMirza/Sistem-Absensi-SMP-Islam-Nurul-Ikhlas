<div>
    @include('partials.alerts')
    
    <!-- Controls -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('employees.index') }}" class="row align-items-center">
                <div class="col-md-6">
                    <div class="d-flex align-items-center">
                        <label for="search" class="form-label me-2 mb-0">Cari:</label>
                        <input type="text" id="search" name="search" class="form-control" 
                               value="{{ request('search') }}"
                               placeholder="Nama, email, telepon, status, atau divisi...">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="d-flex align-items-center">
                        <label for="perPage" class="form-label me-2 mb-0">Tampilkan:</label>
                        <select id="perPage" name="perPage" class="form-select" onchange="this.form.submit()">
                            <option value="5" {{ request('perPage') == 5 ? 'selected' : '' }}>5</option>
                            <option value="10" {{ request('perPage', 10) == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ request('perPage') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-search me-1"></i>
                        Cari
                    </button>
                    @if(request()->hasAny(['search', 'perPage']))
                        <a href="{{ route('employees.index') }}" class="btn btn-secondary btn-sm ms-2">
                            <i class="fas fa-times me-1"></i>
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Bulk Delete Form -->
    <form id="bulkDeleteForm" method="POST" action="{{ route('employees.bulk-delete') }}" style="display: none;">
        @csrf
        @method('DELETE')
        <input type="hidden" name="selected_ids" id="selectedIds">
    </form>

    <!-- Table -->
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-primary">
                        <tr>
                            <th width="50">
                                <input type="checkbox" class="form-check-input" id="selectAll">
                            </th>
                            <th width="80">ID</th>
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            <th>No. Telepon</th>
                            <th>Status</th>
                            <th>Divisi/Mata Pelajaran</th>
                            <th>Tanggal Dibuat</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td>
                                <input type="checkbox" class="form-check-input user-checkbox" 
                                       value="{{ $user->id }}" data-user-id="{{ $user->id }}">
                            </td>
                            <td>{{ $user->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="/assets/img/profile.png" alt="Profile" 
                                         class="rounded-circle me-2" width="32" height="32">
                                    <div>
                                        <div class="fw-bold">{{ $user->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone ?: '-' }}</td>
                            <td>
                                @if($user->role->name === 'guru')
                                    <span class="badge bg-success">🎓 Guru</span>
                                @elseif($user->role->name === 'karyawan')
                                    <span class="badge bg-info">👔 Karyawan</span>
                                @elseif($user->role->name === 'operator')
                                    <span class="badge bg-primary">⚙️ Operator</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($user->role->name) }}</span>
                                @endif
                            </td>
                            <td>
                                @if($user->position)
                                    @if($user->role->name === 'guru')
                                        <span class="text-success">📚 {{ $user->position->name }}</span>
                                    @else
                                        <span class="text-info">🏢 {{ $user->position->name }}</span>
                                    @endif
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <small class="text-muted">
                                    {{ $user->created_at->format('d/m/Y H:i') }}
                                </small>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('employees.show', $user->id) }}" 
                                       class="btn btn-sm btn-outline-info" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('employees.edit', $user->id) }}" 
                                       class="btn btn-sm btn-outline-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($user->id !== auth()->user()->id)
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger" 
                                                title="Hapus"
                                                onclick="confirmDeleteUser({{ $user->id }}, '{{ $user->name }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @else
                                        <button class="btn btn-sm btn-outline-danger" 
                                                title="Tidak dapat menghapus akun sendiri" 
                                                disabled>
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-search fa-2x mb-2"></i>
                                    <p>Tidak ada data yang ditemukan</p>
                                    @if(request('search'))
                                        <small>Coba ubah kata kunci pencarian</small>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        @if($users->hasPages())
        <div class="card-footer bg-light border-top">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="text-muted small">
                        <i class="fas fa-info-circle me-1"></i>
                        Menampilkan <strong>{{ $users->firstItem() }}</strong> - <strong>{{ $users->lastItem() }}</strong> 
                        dari <strong>{{ $users->total() }}</strong> total data pegawai
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-end">
                        {{ $users->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Bulk Actions -->
    <div id="bulkActions" class="card mt-3" style="display: none;">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span id="selectedCount">0</span> item dipilih
                </div>
                <div>
                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmBulkDeleteUsers()">
                        <i class="fas fa-trash me-1"></i>
                        Hapus Terpilih
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Card -->
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card border-left-success">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Guru
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ \App\Models\User::whereHas('role', function($q) { $q->where('name', 'guru'); })->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chalkboard-teacher fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-left-info">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Karyawan
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ \App\Models\User::whereHas('role', function($q) { $q->where('name', 'karyawan'); })->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-tie fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-left-primary">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Semua
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ \App\Models\User::whereIn('role_id', [2, 3])->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Form -->
<form id="deleteUserForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<style>
.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}

.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}

.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}

.text-xs {
    font-size: 0.7rem;
}

.font-weight-bold {
    font-weight: 700 !important;
}

.text-gray-300 {
    color: #dddfeb !important;
}

.text-gray-800 {
    color: #5a5c69 !important;
}

.table th {
    border-top: none;
    font-weight: 600;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.table-hover tbody tr:hover {
    background-color: rgba(78, 115, 223, 0.05);
}

.btn-link:hover {
    text-decoration: none !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('selectAll');
    const userCheckboxes = document.querySelectorAll('.user-checkbox');
    const bulkActions = document.getElementById('bulkActions');
    const selectedCount = document.getElementById('selectedCount');
    
    // Select all functionality
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            userCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateBulkActions();
        });
    }
    
    // Individual checkbox functionality
    userCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateSelectAll();
            updateBulkActions();
        });
    });
    
    function updateSelectAll() {
        if (selectAllCheckbox) {
            const checkedBoxes = document.querySelectorAll('.user-checkbox:checked');
            selectAllCheckbox.checked = checkedBoxes.length === userCheckboxes.length;
            selectAllCheckbox.indeterminate = checkedBoxes.length > 0 && checkedBoxes.length < userCheckboxes.length;
        }
    }
    
    function updateBulkActions() {
        const checkedBoxes = document.querySelectorAll('.user-checkbox:checked');
        if (bulkActions && selectedCount) {
            if (checkedBoxes.length > 0) {
                bulkActions.style.display = 'block';
                selectedCount.textContent = checkedBoxes.length;
            } else {
                bulkActions.style.display = 'none';
            }
        }
    }
});

// Individual delete function with SweetAlert
function confirmDeleteUser(id, name) {
    Swal.fire({
        title: 'Konfirmasi Hapus',
        text: `Apakah Anda yakin ingin menghapus data pegawai "${name}"?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('deleteUserForm');
            form.action = `{{ route('employees.destroy', '') }}/${id}`;
            form.submit();
        }
    });
}

// Bulk delete function with SweetAlert
function confirmBulkDeleteUsers() {
    const checkedBoxes = document.querySelectorAll('.user-checkbox:checked');
    if (checkedBoxes.length === 0) {
        Swal.fire({
            title: 'Peringatan',
            text: 'Pilih data yang ingin dihapus terlebih dahulu.',
            icon: 'warning',
            confirmButtonText: 'OK'
        });
        return;
    }
    
    Swal.fire({
        title: 'Konfirmasi Hapus Massal',
        text: `Apakah Anda yakin ingin menghapus ${checkedBoxes.length} pegawai yang dipilih?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus Semua!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            const selectedIds = Array.from(checkedBoxes).map(cb => cb.value);
            const selectedIdsInput = document.getElementById('selectedIds');
            const bulkDeleteForm = document.getElementById('bulkDeleteForm');
            
            if (selectedIdsInput && bulkDeleteForm) {
                selectedIdsInput.value = selectedIds.join(',');
                bulkDeleteForm.submit();
            }
        }
    });
}
</script>