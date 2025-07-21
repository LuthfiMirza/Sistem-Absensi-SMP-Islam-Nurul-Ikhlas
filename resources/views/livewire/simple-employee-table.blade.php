<div>
    @include('partials.alerts')
    
    <!-- Controls -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="d-flex align-items-center">
                        <label for="search" class="form-label me-2 mb-0">Cari:</label>
                        <input type="text" id="search" class="form-control" wire:model.debounce.300ms="search" 
                               placeholder="Nama, email, telepon, status, atau divisi...">
                    </div>
                </div>
                <div class="col-md-3">
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
                    @if(count($selectedUsers) > 0)
                    <button class="btn btn-danger btn-sm" wire:click="deleteSelected" 
                            onclick="return confirm('Yakin ingin menghapus {{ count($selectedUsers) }} data yang dipilih?')">
                        <i class="fas fa-trash me-1"></i>
                        Hapus Terpilih ({{ count($selectedUsers) }})
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
                                    Nama Lengkap
                                    @if($sortField === 'name')
                                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </button>
                            </th>
                            <th>
                                <button class="btn btn-link p-0 text-decoration-none text-dark fw-bold" 
                                        wire:click="sortBy('email')">
                                    Email
                                    @if($sortField === 'email')
                                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </button>
                            </th>
                            <th>No. Telepon</th>
                            <th>Status</th>
                            <th>Divisi/Mata Pelajaran</th>
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
                        @forelse($users as $user)
                        <tr>
                            <td>
                                <input type="checkbox" class="form-check-input" 
                                       wire:model="selectedUsers" value="{{ $user->id }}">
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
                            <td>{{ $user->phone }}</td>
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
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
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
        
        @if($users->hasPages())
        <div class="card-footer">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Menampilkan {{ $users->firstItem() }} - {{ $users->lastItem() }} 
                    dari {{ $users->total() }} data
                </div>
                <div>
                    {{ $users->links() }}
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