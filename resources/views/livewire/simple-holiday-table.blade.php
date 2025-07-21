<div>
    @include('partials.alerts')
    
    <!-- Controls -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-5">
                    <div class="d-flex align-items-center">
                        <label for="search" class="form-label me-2 mb-0">Cari:</label>
                        <input type="text" id="search" class="form-control" wire:model.debounce.300ms="search" 
                               placeholder="Nama atau deskripsi hari libur...">
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
                <div class="col-md-5">
                    @if(count($selectedHolidays) > 0)
                    <button class="btn btn-danger btn-sm" wire:click="deleteSelected" 
                            onclick="return confirm('Yakin ingin menghapus {{ count($selectedHolidays) }} data yang dipilih?')">
                        <i class="fas fa-trash me-1"></i>
                        Hapus Terpilih ({{ count($selectedHolidays) }})
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
                                        wire:click="sortBy('title')">
                                    Nama Hari Libur
                                    @if($sortField === 'title')
                                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </button>
                            </th>
                            <th>Deskripsi</th>
                            <th>
                                <button class="btn btn-link p-0 text-decoration-none text-dark fw-bold" 
                                        wire:click="sortBy('holiday_date')">
                                    Tanggal Libur
                                    @if($sortField === 'holiday_date')
                                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </button>
                            </th>
                            <th>Status</th>
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
                        @forelse($holidays as $holiday)
                        <tr>
                            <td>
                                <input type="checkbox" class="form-check-input" 
                                       wire:model="selectedHolidays" value="{{ $holiday->id }}">
                            </td>
                            <td>{{ $holiday->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-calendar-times text-danger me-2"></i>
                                    <div>
                                        <div class="fw-bold">{{ $holiday->title }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <small class="text-muted">
                                    {{ Str::limit($holiday->description, 50) }}
                                </small>
                            </td>
                            <td>
                                <span class="badge bg-info">
                                    <i class="fas fa-calendar me-1"></i>
                                    {{ \Carbon\Carbon::parse($holiday->holiday_date)->format('d/m/Y') }}
                                </span>
                                <br>
                                <small class="text-muted">
                                    {{ \Carbon\Carbon::parse($holiday->holiday_date)->locale('id')->isoFormat('dddd') }}
                                </small>
                            </td>
                            <td>
                                @php
                                    $holidayDate = \Carbon\Carbon::parse($holiday->holiday_date);
                                    $today = \Carbon\Carbon::today();
                                @endphp
                                
                                @if($holidayDate->isToday())
                                    <span class="badge bg-danger">🔴 Hari Ini</span>
                                @elseif($holidayDate->isFuture())
                                    <span class="badge bg-warning">🟡 Akan Datang</span>
                                @else
                                    <span class="badge bg-secondary">⚫ Sudah Lewat</span>
                                @endif
                            </td>
                            <td>
                                <small class="text-muted">
                                    {{ $holiday->created_at->format('d/m/Y H:i') }}
                                </small>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-calendar-times fa-2x mb-2"></i>
                                    <p>Tidak ada data hari libur yang ditemukan</p>
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
        
        @if($holidays->hasPages())
        <div class="card-footer">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Menampilkan {{ $holidays->firstItem() }} - {{ $holidays->lastItem() }} 
                    dari {{ $holidays->total() }} data
                </div>
                <div>
                    {{ $holidays->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Summary Card -->
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card border-left-danger">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Total Hari Libur
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ \App\Models\Holiday::count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-times fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-left-warning">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Bulan Ini
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ \App\Models\Holiday::whereMonth('holiday_date', now()->month)->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
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
                                Tahun Ini
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ \App\Models\Holiday::whereYear('holiday_date', now()->year)->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('style')
<style>
.border-left-danger {
    border-left: 0.25rem solid #e74a3b !important;
}

.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
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