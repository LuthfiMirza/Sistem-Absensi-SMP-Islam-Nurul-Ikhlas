    <div>
    @include('partials.alerts')
    
    <!-- Controls -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('positions.index') }}" class="row align-items-center">
                <div class="col-md-4">
                    <div class="d-flex align-items-center">
                        <label for="search" class="form-label me-2 mb-0">Cari:</label>
                        <input type="text" id="search" name="search" class="form-control" 
                               value="{{ request('search') }}"
                               placeholder="Nama posisi...">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="d-flex align-items-center">
                        <label for="filterType" class="form-label me-2 mb-0">Filter:</label>
                        <select id="filterType" name="filterType" class="form-select" onchange="this.form.submit()">
                            <option value="">Semua</option>
                            <option value="guru" {{ request('filterType') == 'guru' ? 'selected' : '' }}>Mata Pelajaran (Guru)</option>
                            <option value="karyawan" {{ request('filterType') == 'karyawan' ? 'selected' : '' }}>Divisi (Karyawan)</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
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
                    @if(request()->hasAny(['search', 'filterType', 'perPage']))
                        <a href="{{ route('positions.index') }}" class="btn btn-secondary btn-sm ms-2">
                            <i class="fas fa-times me-1"></i>
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Bulk Delete Form -->
    <form id="bulkDeleteForm" method="POST" action="{{ route('positions.bulk-delete') }}" style="display: none;">
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
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Jumlah Pengguna</th>
                            <th>Tanggal Dibuat</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($positions as $position)
                        <tr>
                            <td>
                                <input type="checkbox" class="form-check-input position-checkbox" 
                                       value="{{ $position->id }}" data-position-id="{{ $position->id }}">
                            </td>
                            <td>{{ $position->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($position->type === 'guru')
                                        <i class="fas fa-book text-success me-2"></i>
                                    @else
                                        <i class="fas fa-building text-info me-2"></i>
                                    @endif
                                    <div>
                                        <div class="fw-bold">{{ $position->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($position->type === 'guru')
                                    <span class="badge bg-success">📚 Mata Pelajaran</span>
                                @else
                                    <span class="badge bg-info">🏢 Divisi</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-secondary">
                                    {{ $position->users()->count() }} orang
                                </span>
                            </td>
                            <td>
                                <small class="text-muted">
                                    {{ $position->created_at->format('d/m/Y H:i') }}
                                </small>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('positions.show', $position->id) }}" 
                                       class="btn btn-sm btn-outline-info" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('positions.edit', $position->id) }}" 
                                       class="btn btn-sm btn-outline-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-danger" 
                                            title="Hapus"
                                            onclick="confirmDelete({{ $position->id }}, '{{ $position->name }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
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
        
        @if($positions->hasPages())
        <div class="card-footer bg-light border-top">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="text-muted small">
                        <i class="fas fa-info-circle me-1"></i>
                        Menampilkan <strong>{{ $positions->firstItem() }}</strong> - <strong>{{ $positions->lastItem() }}</strong> 
                        dari <strong>{{ $positions->total() }}</strong> total data divisi/posisi
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-end">
                        {{ $positions->appends(request()->query())->links('pagination::bootstrap-5') }}
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
                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmBulkDelete()">
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
                                Mata Pelajaran
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ \App\Models\Position::where('type', 'guru')->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-book fa-2x text-gray-300"></i>
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
                                Divisi Karyawan
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ \App\Models\Position::where('type', 'karyawan')->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-building fa-2x text-gray-300"></i>
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
                                {{ \App\Models\Position::count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Form -->
<form id="deleteForm" method="POST" style="display: none;">
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
    const positionCheckboxes = document.querySelectorAll('.position-checkbox');
    const bulkActions = document.getElementById('bulkActions');
    const selectedCount = document.getElementById('selectedCount');
    
    // Select all functionality
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            positionCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateBulkActions();
        });
    }
    
    // Individual checkbox functionality
    positionCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateSelectAll();
            updateBulkActions();
        });
    });
    
    function updateSelectAll() {
        if (selectAllCheckbox) {
            const checkedBoxes = document.querySelectorAll('.position-checkbox:checked');
            selectAllCheckbox.checked = checkedBoxes.length === positionCheckboxes.length;
            selectAllCheckbox.indeterminate = checkedBoxes.length > 0 && checkedBoxes.length < positionCheckboxes.length;
        }
    }
    
    function updateBulkActions() {
        const checkedBoxes = document.querySelectorAll('.position-checkbox:checked');
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
function confirmDelete(id, name) {
    Swal.fire({
        title: 'Konfirmasi Hapus',
        text: `Apakah Anda yakin ingin menghapus posisi "${name}"?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('deleteForm');
            form.action = `{{ route('positions.destroy', '') }}/${id}`;
            form.submit();
        }
    });
}

// Bulk delete function with SweetAlert
function confirmBulkDelete() {
    const checkedBoxes = document.querySelectorAll('.position-checkbox:checked');
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
        text: `Apakah Anda yakin ingin menghapus ${checkedBoxes.length} posisi yang dipilih?`,
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