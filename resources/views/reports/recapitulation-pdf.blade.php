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
        
        .badge-secondary { background-color: #6c757d; }
        .badge-success { background-color: #28a745; }
        .badge-danger { background-color: #dc3545; }
        .badge-warning { background-color: #ffc107; color: #212529; }
        .badge-info { background-color: #17a2b8; }
        
        .progress-bar {
            width: 100%;
            height: 15px;
            background-color: #e9ecef;
            border-radius: 3px;
            overflow: hidden;
        }
        
        .progress-fill {
            height: 100%;
            color: white;
            text-align: center;
            font-size: 10px;
            line-height: 15px;
        }
        
        .progress-success { background-color: #28a745; }
        .progress-warning { background-color: #ffc107; }
        .progress-danger { background-color: #dc3545; }
        
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
        <p>Periode: {{ $monthName }} {{ $year }}</p>
    </div>

    <!-- Info Section -->
    <div class="info-section">
        <div class="info-row">
            <div class="info-item">
                <div class="info-label">Periode</div>
                <div class="info-value">{{ $start_date->format('d F Y') }} - {{ $end_date->format('d F Y') }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Total Karyawan</div>
                <div class="info-value">{{ count($recapData) }} orang</div>
            </div>
            <div class="info-item">
                <div class="info-label">Total Hari Kerja</div>
                <div class="info-value">{{ $recapData[0]['total_days'] ?? 0 }} hari</div>
            </div>
            <div class="info-item">
                <div class="info-label">Rata-rata Kehadiran</div>
                <div class="info-value">{{ count($recapData) > 0 ? number_format(collect($recapData)->avg('present_days'), 1) : 0 }} hari</div>
            </div>
        </div>
    </div>

    <!-- Summary Statistics -->
    <div class="summary-stats">
        <div class="stat-item">
            <div class="stat-number">{{ collect($recapData)->sum('present_days') }}</div>
            <div class="stat-label">Total Kehadiran</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ collect($recapData)->sum('absent_days') }}</div>
            <div class="stat-label">Total Absen</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ collect($recapData)->sum('permission_days') }}</div>
            <div class="stat-label">Total Izin</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ collect($recapData)->sum('late_days') }}</div>
            <div class="stat-label">Total Terlambat</div>
        </div>
    </div>

    <!-- Data Table -->
    @if(count($recapData) > 0)
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>Divisi</th>
                    <th>Total Hari</th>
                    <th>Hadir</th>
                    <th>Absen</th>
                    <th>Izin</th>
                    <th>Terlambat</th>
                    <th>Persentase Kehadiran</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recapData as $index => $data)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>
                            <strong>{{ $data['user']->name }}</strong><br>
                            <small>{{ $data['user']->email }}</small>
                        </td>
                        <td>{{ $data['user']->position->name ?? '-' }}</td>
                        <td>{{ $data['user']->division->name ?? '-' }}</td>
                        <td class="text-center">
                            <span class="badge badge-secondary">{{ $data['total_days'] }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge badge-success">{{ $data['present_days'] }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge badge-danger">{{ $data['absent_days'] }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge badge-warning">{{ $data['permission_days'] }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge badge-info">{{ $data['late_days'] }}</span>
                        </td>
                        <td>
                            @php
                                $percentage = $data['total_days'] > 0 ? ($data['present_days'] / $data['total_days']) * 100 : 0;
                                $progressClass = $percentage >= 90 ? 'progress-success' : ($percentage >= 75 ? 'progress-warning' : 'progress-danger');
                            @endphp
                            <div class="progress-bar">
                                <div class="progress-fill {{ $progressClass }}" style="width: {{ $percentage }}%">
                                    {{ number_format($percentage, 1) }}%
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-data">
            <h3>Tidak ada data karyawan</h3>
            <p>Tidak ditemukan data karyawan untuk periode yang dipilih</p>
        </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>Laporan digenerate pada: {{ now()->format('d F Y, H:i:s') }}</p>
        <p>© {{ date('Y') }} SMP Islam Nurul Ikhlas - Sistem Absensi</p>
    </div>
</body>
</html>