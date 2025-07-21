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
                               placeholder="Judul atau deskripsi absensi...">
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
                    @if(count($selectedAttendances) > 0)
                    <button class="btn btn-danger btn-sm" wire:click="deleteSelected" 
                            onclick="return confirm('Yakin ingin menghapus {{ count($selectedAttendances) }} data yang dipilih?')">
                        <i class="fas fa-trash me-1"></i>
                        Hapus Terpilih ({{ count($selectedAttendances) }})
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
                                    Judul Absensi
                                    @if($sortField === 'title')
                                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </button>
                            </th>
                            <th>Deskripsi</th>
                            <th>Waktu Masuk</th>
                            <th>Waktu Pulang</th>
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
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendances as $attendance)
                        <tr>
                            <td>
                                <input type="checkbox" class="form-check-input" 
                                       wire:model="selectedAttendances" value="{{ $attendance->id }}">
                            </td>
                            <td>{{ $attendance->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-calendar-check text-primary me-2"></i>
                                    <div>
                                        <div class="fw-bold">{{ $attendance->title }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <small class="text-muted">
                                    {{ Str::limit($attendance->description, 50) }}
                                </small>
                            </td>
                            <td>
                                <span class="badge bg-success">
                                    <i class="fas fa-clock me-1"></i>
                                    {{ $attendance->start_time }} - {{ $attendance->batas_start_time }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-info">
                                    <i class="fas fa-clock me-1"></i>
                                    {{ $attendance->end_time }} - {{ $attendance->batas_end_time }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $now = now();
                                    $today = $now->format('Y-m-d');
                                    $currentTime = $now->format('H:i');
                                @endphp
                                
                                @if($currentTime >= $attendance->start_time && $currentTime <= $attendance->batas_end_time)
                                    <span class="badge bg-success">🟢 Aktif</span>
                                @elseif($currentTime < $attendance->start_time)
                                    <span class="badge bg-warning">🟡 Belum Dimulai</span>
                                @else
                                    <span class="badge bg-secondary">⚫ Selesai</span>
                                @endif
                            </td>
                            <td>
                                <small class="text-muted">
                                    {{ $attendance->created_at->format('d/m/Y H:i') }}
                                </small>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('attendances.edit', $attendance->id) }}" 
                                       class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('attendances.show', $attendance->id) }}" 
                                       class="btn btn-sm btn-outline-info" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-calendar-times fa-2x mb-2"></i>
                                    <p>Tidak ada data absensi yang ditemukan</p>
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
        
        @if($attendances->hasPages())
        <div class="card-footer">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Menampilkan {{ $attendances->firstItem() }} - {{ $attendances->lastItem() }} 
                    dari {{ $attendances->total() }} data
                </div>
                <div>
                    {{ $attendances->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Summary Card -->
    <div class="row mt-4">
        <div class="col-md-3">
            <div class="card border-left-success">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Absensi
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ \App\Models\Attendance::count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-info">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Aktif Hari Ini
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @php
                                    $now = now();
                                    $currentTime = $now->format('H:i');
                                    $activeCount = \App\Models\Attendance::where(function($q) use ($currentTime) {
                                        $q->where('start_time', '<=', $currentTime)
                                          ->where('batas_end_time', '>=', $currentTime);
                                    })->count();
                                @endphp
                                {{ $activeCount }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-play-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-warning">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Bulan Ini
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ \App\Models\Attendance::whereMonth('created_at', now()->month)->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-primary">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Tahun Ini
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ \App\Models\Attendance::whereYear('created_at', now()->year)->count() }}
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
.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}

.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
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

.btn-group .btn {
    margin-right: 2px;
}

.btn-group .btn:last-child {
    margin-right: 0;
}
</style>
@endpush