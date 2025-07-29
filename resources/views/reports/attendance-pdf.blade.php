<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        
        .header h1 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }
        
        .header h2 {
            margin: 5px 0;
            font-size: 16px;
            color: #666;
        }
        
        .info-section {
            margin-bottom: 20px;
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        
        .info-item {
            flex: 1;
            text-align: center;
        }
        
        .info-label {
            font-weight: bold;
            color: #333;
        }
        
        .info-value {
            color: #666;
            margin-top: 5px;
        }
        
        .attendance-section {
            margin-bottom: 30px;
            page-break-inside: avoid;
        }
        
        .attendance-header {
            background-color: #007bff;
            color: white;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
        }
        
        .attendance-info {
            background-color: #e9ecef;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
        }
        
        .stats-row {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }
        
        .stat-card {
            text-align: center;
            padding: 10px;
            border-radius: 5px;
            min-width: 80px;
        }
        
        .stat-success { background-color: #d4edda; border: 1px solid #c3e6cb; }
        .stat-warning { background-color: #fff3cd; border: 1px solid #ffeaa7; }
        .stat-info { background-color: #d1ecf1; border: 1px solid #bee5eb; }
        .stat-danger { background-color: #f8d7da; border: 1px solid #f5c6cb; }
        
        .stat-number {
            font-size: 18px;
            font-weight: bold;
        }
        
        .stat-label {
            font-size: 10px;
            margin-top: 5px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        th, td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
        }
        
        th {
            background-color: #f8f9fa;
            font-weight: bold;
            text-align: center;
            font-size: 11px;
        }
        
        .text-center {
            text-align: center;
        }
        
        .badge {
            padding: 2px 6px;
            border-radius: 3px;
            color: white;
            font-size: 9px;
            font-weight: bold;
        }
        
        .badge-success { background-color: #28a745; }
        .badge-warning { background-color: #ffc107; color: #212529; }
        .badge-primary { background-color: #007bff; }
        .badge-danger { background-color: #dc3545; }
        
        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        
        .no-data {
            text-align: center;
            padding: 50px;
            color: #666;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>SMP Islam Nurul Ikhlas</h1>
        <h2>{{ $title }}</h2>
        <p>Periode: {{ $start_date->format('d F Y') }} - {{ $end_date->format('d F Y') }}</p>
    </div>

    <!-- Info Section -->
    <div class="info-section">
        <div class="info-row">
            <div class="info-item">
                <div class="info-label">Periode</div>
                <div class="info-value">{{ $start_date->format('d F Y') }} - {{ $end_date->format('d F Y') }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Karyawan</div>
                <div class="info-value">{{ $user ? $user->name : 'Semua Karyawan' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Total Absensi</div>
                <div class="info-value">{{ $attendances->count() }} absensi</div>
            </div>
            <div class="info-item">
                <div class="info-label">Total Kehadiran</div>
                <div class="info-value">{{ $attendances->sum(function($att) { return $att->presences->count(); }) }} kehadiran</div>
            </div>
        </div>
    </div>

    <!-- Attendance Data -->
    @if($attendances->count() > 0)
        @foreach($attendances as $attendance)
            <div class="attendance-section">
                <div class="attendance-header">
                    <strong>{{ $attendance->title }}</strong>
                    <span style="float: right;">{{ $attendance->created_at->format('d F Y') }}</span>
                </div>
                
                <div class="attendance-info">
                    <strong>Deskripsi:</strong> {{ $attendance->description }}<br>
                    <strong>Waktu:</strong> {{ $attendance->start_time }} - {{ $attendance->end_time }}
                </div>

                <!-- Statistics -->
                <div class="stats-row">
                    <div class="stat-card stat-success">
                        <div class="stat-number">{{ $attendance->presences->count() }}</div>
                        <div class="stat-label">Hadir</div>
                    </div>
                    <div class="stat-card stat-warning">
                        <div class="stat-number">{{ $attendance->permissions->where('is_accepted', true)->count() }}</div>
                        <div class="stat-label">Izin</div>
                    </div>
                    <div class="stat-card stat-info">
                        <div class="stat-number">{{ $attendance->permissions->whereNull('is_accepted')->count() }}</div>
                        <div class="stat-label">Pending</div>
                    </div>
                    <div class="stat-card stat-danger">
                        <div class="stat-number">{{ $attendance->permissions->where('is_accepted', false)->count() }}</div>
                        <div class="stat-label">Ditolak</div>
                    </div>
                </div>

                <!-- Presence List -->
                @if($attendance->presences->count() > 0)
                    <div class="section-title">Daftar Kehadiran ({{ $attendance->presences->count() }})</div>
                    <table>
                        <thead>
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
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $presence->user->name }}</td>
                                    <td class="text-center">{{ $presence->presence_enter_time }}</td>
                                    <td class="text-center">{{ $presence->presence_out_time ?? '-' }}</td>
                                    <td class="text-center">
                                        @if($presence->presence_enter_time > $attendance->start_time)
                                            <span class="badge badge-warning">Terlambat</span>
                                        @else
                                            <span class="badge badge-success">Tepat Waktu</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

                <!-- Permission List -->
                @if($attendance->permissions->count() > 0)
                    <div class="section-title">Daftar Izin ({{ $attendance->permissions->count() }})</div>
                    <table>
                        <thead>
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
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $permission->user->name }}</td>
                                    <td>{{ $permission->title }}</td>
                                    <td class="text-center">
                                        @if($permission->type === 'same_day')
                                            <span class="badge badge-primary">Hari yang Sama</span>
                                        @else
                                            <span class="badge badge-success">Cuti</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($permission->is_accepted === null)
                                            <span class="badge badge-warning">Pending</span>
                                        @elseif($permission->is_accepted)
                                            <span class="badge badge-success">Disetujui</span>
                                        @else
                                            <span class="badge badge-danger">Ditolak</span>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $permission->permission_date->format('d/m/Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        @endforeach
    @else
        <div class="no-data">
            <h3>Tidak ada data absensi</h3>
            <p>Tidak ditemukan data absensi untuk periode yang dipilih</p>
        </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>Laporan digenerate pada: {{ now()->format('d F Y, H:i:s') }}</p>
        <p>© {{ date('Y') }} SMP Islam Nurul Ikhlas - Sistem Absensi</p>
    </div>
</body>
</html>