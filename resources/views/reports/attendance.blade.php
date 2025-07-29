@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
        <a href="{{ route('reports.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
        </a>
    </div>

    <!-- Filter Info -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-filter me-2"></i>Filter Laporan
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <strong>Periode:</strong><br>
                    {{ $start_date->format('d F Y') }} - {{ $end_date->format('d F Y') }}
                </div>
                <div class="col-md-3">
                    <strong>Karyawan:</strong><br>
                    {{ $user ? $user->name : 'Semua Karyawan' }}
                </div>
                <div class="col-md-3">
                    <strong>Total Absensi:</strong><br>
                    {{ $attendances->count() }} absensi
                </div>
                <div class="col-md-3">
                    <strong>Total Kehadiran:</strong><br>
                    {{ $attendances->sum(function($att) { return $att->presences->count(); }) }} kehadiran
                </div>
            </div>
        </div>
    </div>

    <!-- Attendance Data -->
    @if($attendances->count() > 0)
        @foreach($attendances as $attendance)
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-calendar-check me-2"></i>{{ $attendance->title }}
                        <small class="text-muted ms-2">{{ $attendance->created_at->format('d F Y') }}</small>
                    </h6>
                </div>
                <div class="card-body">
                    <!-- Attendance Info -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Deskripsi:</strong> {{ $attendance->description }}
                        </div>
                        <div class="col-md-6">
                            <strong>Waktu:</strong> {{ $attendance->start_time }} - {{ $attendance->end_time }}
                        </div>
                    </div>

                    <!-- Statistics -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <div class="card border-success">
                                <div class="card-body text-center">
                                    <h4 class="text-success">{{ $attendance->presences->count() }}</h4>
                                    <small>Hadir</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-warning">
                                <div class="card-body text-center">
                                    <h4 class="text-warning">{{ $attendance->permissions->where('is_accepted', true)->count() }}</h4>
                                    <small>Izin</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-info">
                                <div class="card-body text-center">
                                    <h4 class="text-info">{{ $attendance->permissions->whereNull('is_accepted')->count() }}</h4>
                                    <small>Pending</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-danger">
                                <div class="card-body text-center">
                                    <h4 class="text-danger">{{ $attendance->permissions->where('is_accepted', false)->count() }}</h4>
                                    <small>Ditolak</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Presence List -->
                    @if($attendance->presences->count() > 0)
                        <h6 class="text-success mb-3">
                            <i class="fas fa-user-check me-2"></i>Daftar Kehadiran ({{ $attendance->presences->count() }})
                        </h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead class="table-success">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Jam Masuk</th>
                                        <th>Jam Keluar</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($attendance->presences as $index => $presence)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $presence->user->name }}</td>
                                            <td>{{ $presence->presence_enter_time }}</td>
                                            <td>{{ $presence->presence_out_time ?? '-' }}</td>
                                            <td>
                                                @if($presence->presence_enter_time > $attendance->start_time)
                                                    <span class="badge bg-warning">Terlambat</span>
                                                @else
                                                    <span class="badge bg-success">Tepat Waktu</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    <!-- Permission List -->
                    @if($attendance->permissions->count() > 0)
                        <h6 class="text-warning mb-3 mt-4">
                            <i class="fas fa-file-alt me-2"></i>Daftar Izin ({{ $attendance->permissions->count() }})
                        </h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead class="table-warning">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Judul</th>
                                        <th>Jenis</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($attendance->permissions as $index => $permission)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $permission->user->name }}</td>
                                            <td>{{ $permission->title }}</td>
                                            <td>
                                                @if($permission->type === 'same_day')
                                                    <span class="badge bg-primary">Hari yang Sama</span>
                                                @else
                                                    <span class="badge bg-success">Cuti</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($permission->is_accepted === null)
                                                    <span class="badge bg-warning">Pending</span>
                                                @elseif($permission->is_accepted)
                                                    <span class="badge bg-success">Disetujui</span>
                                                @else
                                                    <span class="badge bg-danger">Ditolak</span>
                                                @endif
                                            </td>
                                            <td>{{ $permission->permission_date->format('d/m/Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    @else
        <div class="card shadow">
            <div class="card-body text-center py-5">
                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Tidak ada data absensi</h5>
                <p class="text-muted">Tidak ditemukan data absensi untuk periode yang dipilih</p>
            </div>
        </div>
    @endif

    <!-- Export Options -->
    <div class="card shadow mt-4">
        <div class="card-body">
            <h6 class="mb-3">Export Laporan</h6>
            <form action="{{ route('reports.attendance') }}" method="GET" class="d-inline">
                <input type="hidden" name="start_date" value="{{ $start_date->format('Y-m-d') }}">
                <input type="hidden" name="end_date" value="{{ $end_date->format('Y-m-d') }}">
                @if($user)
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                @endif
                <input type="hidden" name="format" value="pdf">
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-file-pdf me-2"></i>Download PDF
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('style')
<style>
.card {
    border: none;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
}

.table th {
    background-color: #f8f9fc;
    border-color: #e3e6f0;
    font-weight: 600;
}
</style>
@endpush