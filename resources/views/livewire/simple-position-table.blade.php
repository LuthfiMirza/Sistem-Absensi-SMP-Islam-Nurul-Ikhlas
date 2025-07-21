<div>
    @include('partials.alerts')
    
    <!-- Controls -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <div class="d-flex align-items-center">
                        <label for="search" class="form-label me-2 mb-0">Cari:</label>
                        <input type="text" id="search" class="form-control" wire:model.debounce.300ms="search" 
                               placeholder="Nama divisi atau mata pelajaran...">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="d-flex align-items-center">
                        <label for="filterType" class="form-label me-2 mb-0">Filter:</label>
                        <select id="filterType" class="form-select" wire:model="filterType">
                            <option value="">Semua</option>
                            <option value="guru">Mata Pelajaran (Guru)</option>
                            <option value="karyawan">Divisi (Karyawan)</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="d-flex align-items-center">
                        <label for="perPage" class="form-label me-2 mb-0">Tampilkan:</label>
                        <select id="perPage" class="form-select" wire:model="perPage">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    @if(count($selectedPositions) > 0)
                    <button class="btn btn-danger btn-sm" wire:click="deleteSelected" 
                            onclick="return confirm('Yakin ingin menghapus {{ count($selectedPositions) }} data yang dipilih?')">
                        <i class="fas fa-trash me-1"></i>
                        Hapus Terpilih ({{ count($selectedPositions) }})
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-primary">
                        <tr>
                            <th width="50">
                                <input type="checkbox" class="form-check-input" wire:model="selectAll">
                            </th>
                            <th width="80">
                                <button class="btn btn-link p-0 text-decoration-none text-dark fw-bold" 
                                        wire:click="sortBy('id')">
                                    ID
                                    @if($sortField === 'id')
                                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </button>
                            </th>
                            <th>
                                <button class="btn btn-link p-0 text-decoration-none text-dark fw-bold" 
                                        wire:click="sortBy('name')">
                                    Nama
                                    @if($sortField === 'name')
                                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </button>
                            </th>
                            <th>
                                <button class="btn btn-link p-0 text-decoration-none text-dark fw-bold" 
                                        wire:click="sortBy('type')">
                                    Kategori
                                    @if($sortField === 'type')
                                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </button>
                            </th>
                            <th>Jumlah Pengguna</th>
                            <th>
                                <button class="btn btn-link p-0 text-decoration-none text-dark fw-bold" 
                                        wire:click="sortBy('created_at')">
                                    Tanggal Dibuat
                                    @if($sortField === 'created_at')
                                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </button>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($positions as $position)
                        <tr>
                            <td>
                                <input type="checkbox" class="form-check-input" 
                                       wire:model="selectedPositions" value="{{ $position->id }}">
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
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-search fa-2x mb-2"></i>
                                    <p>Tidak ada data yang ditemukan</p>
                                    @if($search)
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
        <div class="card-footer">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Menampilkan {{ $positions->firstItem() }} - {{ $positions->lastItem() }} 
                    dari {{ $positions->total() }} data
                </div>
                <div>
                    {{ $positions->links() }}
                </div>
            </div>
        </div>
        @endif
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

@push('style')
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
@endpush