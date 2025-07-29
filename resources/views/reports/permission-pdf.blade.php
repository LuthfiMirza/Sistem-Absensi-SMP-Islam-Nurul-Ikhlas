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
        
        .summary-stats {
            display: flex;
            justify-content: space-around;
            margin-bottom: 30px;
            background-color: #e9ecef;
            padding: 15px;
            border-radius: 5px;
        }
        
        .stat-item {
            text-align: center;
        }
        
        .stat-number {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
        
        .stat-label {
            font-size: 10px;
            color: #666;
            margin-top: 5px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
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
            padding: 3px 8px;
            border-radius: 3px;
            color: white;
            font-size: 10px;
            font-weight: bold;
        }
        
        .badge-primary { background-color: #007bff; }
        .badge-success { background-color: #28a745; }
        .badge-warning { background-color: #ffc107; color: #212529; }
        .badge-danger { background-color: #dc3545; }
        .badge-info { background-color: #17a2b8; }
        
        .permission-detail {
            font-size: 10px;
            color: #666;
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
        
        .user-info {
            font-size: 11px;
        }
        
        .user-name {
            font-weight: bold;
        }
        
        .user-email {
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
                <div class="info-label">Jenis Izin</div>
                <div class="info-value">
                    @if($type === 'same_day')
                        Izin Hari yang Sama
                    @elseif($type === 'leave')
                        Izin Cuti
                    @else
                        Semua Jenis
                    @endif
                </div>
            </div>
            <div class="info-item">
                <div class="info-label">Status</div>
                <div class="info-value">
                    @if($status === 'pending')
                        Menunggu
                    @elseif($status === 'accepted')
                        Disetujui
                    @elseif($status === 'rejected')
                        Ditolak
                    @else
                        Semua Status
                    @endif
                </div>
            </div>
            <div class="info-item">
                <div class="info-label">Total Izin</div>
                <div class="info-value">{{ $permissions->count() }} izin</div>
            </div>
        </div>
    </div>

    <!-- Summary Statistics -->
    <div class="summary-stats">
        <div class="stat-item">
            <div class="stat-number">{{ $permissions->whereNull('is_accepted')->count() }}</div>
            <div class="stat-label">Menunggu Persetujuan</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ $permissions->where('is_accepted', true)->count() }}</div>
            <div class="stat-label">Disetujui</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ $permissions->where('is_accepted', false)->count() }}</div>
            <div class="stat-label">Ditolak</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ $permissions->where('type', 'leave')->count() }}</div>
            <div class="stat-label">Izin Cuti</div>
        </div>
    </div>

    <!-- Permissions Table -->
    @if($permissions->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Judul</th>
                    <th>Jenis</th>
                    <th>Tanggal Izin</th>
                    <th>Detail</th>
                    <th>Status</th>
                    <th>Tanggal Pengajuan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($permissions as $index => $permission)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td class="user-info">
                            <div class="user-name">{{ $permission->user->name }}</div>
                            <div class="user-email">{{ $permission->user->email }}</div>
                        </td>
                        <td>{{ $permission->title }}</td>
                        <td class="text-center">
                            @if($permission->type === 'same_day')
                                <span class="badge badge-primary">Hari yang Sama</span>
                            @else
                                <span class="badge badge-success">Cuti</span>
                            @endif
                        </td>
                        <td class="text-center">{{ $permission->permission_date->format('d/m/Y') }}</td>
                        <td class="permission-detail">
                            @if($permission->type === 'same_day')
                                @if($permission->late_arrival_time)
                                    Datang: {{ $permission->late_arrival_time->format('H:i') }}<br>
                                @endif
                                @if($permission->early_departure_time)
                                    Pulang: {{ $permission->early_departure_time->format('H:i') }}
                                @endif
                                @if(!$permission->late_arrival_time && !$permission->early_departure_time)
                                    -
                                @endif
                            @else
                                @if($permission->leave_start_date && $permission->leave_end_date)
                                    {{ $permission->leave_start_date->format('d/m/Y') }} - {{ $permission->leave_end_date->format('d/m/Y') }}
                                @else
                                    -
                                @endif
                            @endif
                        </td>
                        <td class="text-center">
                            @if($permission->is_accepted === null)
                                <span class="badge badge-warning">Menunggu</span>
                            @elseif($permission->is_accepted)
                                <span class="badge badge-success">Disetujui</span>
                            @else
                                <span class="badge badge-danger">Ditolak</span>
                            @endif
                        </td>
                        <td class="text-center">{{ $permission->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Permission Details -->
        <div style="margin-top: 30px;">
            <h3 style="font-size: 14px; border-bottom: 1px solid #ddd; padding-bottom: 10px;">Detail Keterangan Izin</h3>
            @foreach($permissions as $index => $permission)
                <div style="margin-bottom: 20px; padding: 10px; background-color: #f8f9fa; border-radius: 5px;">
                    <strong>{{ $index + 1 }}. {{ $permission->user->name }} - {{ $permission->title }}</strong><br>
                    <div style="margin-top: 5px; font-size: 11px; color: #666;">
                        {{ $permission->description }}
                    </div>
                    @if($permission->rejection_reason)
                        <div style="margin-top: 5px; padding: 5px; background-color: #f8d7da; border: 1px solid #f5c6cb; border-radius: 3px;">
                            <strong>Alasan Penolakan:</strong> {{ $permission->rejection_reason }}
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <div class="no-data">
            <h3>Tidak ada data izin</h3>
            <p>Tidak ditemukan data izin untuk filter yang dipilih</p>
        </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>Laporan digenerate pada: {{ now()->format('d F Y, H:i:s') }}</p>
        <p>© {{ date('Y') }} SMP Islam Nurul Ikhlas - Sistem Absensi</p>
    </div>
</body>
</html>