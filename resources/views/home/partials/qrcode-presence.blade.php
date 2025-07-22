<div class="qrcode-section">
    @if ($holiday)
    <div class="alert alert-success border-0 shadow-sm">
        <div class="d-flex align-items-center">
            <i class="fas fa-calendar-times fa-2x text-success me-3"></i>
            <div>
                <h6 class="alert-heading mb-1">Hari Libur</h6>
                <p class="mb-0">Hari ini adalah hari libur. Tidak ada absensi yang perlu dilakukan.</p>
            </div>
        </div>
    </div>
    @else

    {{-- Status Cards --}}
    <div class="status-cards mb-4">
        @if($data['is_there_permission'])
            @if($data['is_permission_accepted'])
            <div class="status-card bg-success">
                <div class="status-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="status-content">
                    <h6>Izin Diterima</h6>
                    <p>Permintaan izin Anda telah disetujui</p>
                </div>
            </div>
            @else
            <div class="status-card bg-warning">
                <div class="status-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="status-content">
                    <h6>Izin Diproses</h6>
                    <p>Permintaan izin sedang menunggu persetujuan</p>
                </div>
            </div>
            @endif
        @endif

        @if ($data['is_has_enter_today'] && !$data['is_not_out_yet'])
        <div class="status-card bg-success">
            <div class="status-icon">
                <i class="fas fa-check-double"></i>
            </div>
            <div class="status-content">
                <h6>Absensi Lengkap</h6>
                <p>Anda sudah melakukan absen masuk dan pulang</p>
            </div>
        </div>
        @endif
    </div>

    {{-- QR Code Actions --}}
    @if ($attendance->data->is_using_qrcode && !$data['is_there_permission'])

        {{-- Absen Masuk --}}
        @if ($attendance->data->is_start && !$data['is_has_enter_today'])
        <div class="qr-action-card mb-3">
            <div class="qr-action-header bg-primary">
                <i class="fas fa-qrcode me-2"></i>
                Absensi Masuk
            </div>
            <div class="qr-action-body">
                <p class="text-muted mb-3">Scan QR Code untuk melakukan absensi masuk</p>
                <button class="btn btn-primary btn-lg w-100 mb-2" data-bs-toggle="modal"
                    data-bs-target="#qrcode-scanner-modal" data-is-enter="1">
                    <i class="fas fa-camera me-2"></i>
                    Scan QR Code Masuk
                </button>
                <a href="{{ route('home.permission', $attendance->id) }}"
                    class="btn btn-outline-warning w-100">
                    <i class="fas fa-file-medical me-2"></i>
                    Ajukan Izin
                </a>
            </div>
        </div>
        @endif

        {{-- Status Sudah Absen Masuk --}}
        @if ($data['is_has_enter_today'])
        <div class="qr-action-card mb-3">
            <div class="qr-action-header bg-success">
                <i class="fas fa-check-circle me-2"></i>
                Absensi Masuk Berhasil
            </div>
            <div class="qr-action-body">
                <p class="text-success mb-0">
                    <i class="fas fa-check me-2"></i>
                    Anda sudah berhasil melakukan absensi masuk
                </p>
            </div>
        </div>
        @endif

        {{-- Absen Pulang --}}
        @if ($attendance->data->is_end && $data['is_has_enter_today'] && $data['is_not_out_yet'])
        <div class="qr-action-card mb-3">
            <div class="qr-action-header bg-info">
                <i class="fas fa-qrcode me-2"></i>
                Absensi Pulang
            </div>
            <div class="qr-action-body">
                <p class="text-muted mb-3">Scan QR Code untuk melakukan absensi pulang</p>
                <button class="btn btn-info btn-lg w-100" data-bs-toggle="modal"
                    data-bs-target="#qrcode-scanner-modal" data-is-enter="0">
                    <i class="fas fa-camera me-2"></i>
                    Scan QR Code Pulang
                </button>
            </div>
        </div>
        @endif

        {{-- Belum Saatnya Pulang --}}
        @if ($data['is_has_enter_today'] && !$attendance->data->is_end)
        <div class="qr-action-card mb-3">
            <div class="qr-action-header bg-warning">
                <i class="fas fa-clock me-2"></i>
                Menunggu Waktu Pulang
            </div>
            <div class="qr-action-body">
                <p class="text-warning mb-0">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Belum saatnya melakukan absensi pulang
                </p>
            </div>
        </div>
        @endif

    @endif

    @endif

    <!-- QR Code Scanner Modal -->
    <div class="modal fade" id="qrcode-scanner-modal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-qrcode me-2"></i>
                        Scanner QR Code Absensi
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Instructions -->
                    <div class="scanner-instructions mb-4">
                        <div class="row text-center">
                            <div class="col-md-4">
                                <div class="instruction-item">
                                    <div class="instruction-icon bg-primary">
                                        <i class="fas fa-camera"></i>
                                    </div>
                                    <h6>1. Izinkan Kamera</h6>
                                    <small class="text-muted">Klik "Allow" saat diminta akses kamera</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="instruction-item">
                                    <div class="instruction-icon bg-success">
                                        <i class="fas fa-qrcode"></i>
                                    </div>
                                    <h6>2. Arahkan ke QR Code</h6>
                                    <small class="text-muted">Posisikan QR Code dalam kotak biru</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="instruction-item">
                                    <div class="instruction-icon bg-info">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <h6>3. Tunggu Deteksi</h6>
                                    <small class="text-muted">Scanner akan otomatis mendeteksi</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Scanner Area -->
                    <div class="scanner-container">
                        <div id="reader" class="qr-reader"></div>
                        <div class="scanner-overlay">
                            <div class="scanner-status" id="scanner-status">
                                <i class="fas fa-camera me-2"></i>
                                Memulai kamera...
                            </div>
                        </div>
                    </div>

                    <!-- Tips -->
                    <div class="mt-4">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="alert alert-success border-0">
                                    <h6 class="alert-heading">
                                        <i class="fas fa-lightbulb me-2"></i>
                                        Tips Sukses:
                                    </h6>
                                    <ul class="mb-0 small">
                                        <li>Pastikan pencahayaan cukup terang</li>
                                        <li>Jaga jarak 15-30 cm dari QR Code</li>
                                        <li>Tahan kamera dengan stabil</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="alert alert-warning border-0">
                                    <h6 class="alert-heading">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        Jika Bermasalah:
                                    </h6>
                                    <ul class="mb-0 small">
                                        <li>Refresh halaman dan coba lagi</li>
                                        <li>Bersihkan lensa kamera</li>
                                        <li>Gunakan browser Chrome/Safari</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>
                        Tutup Scanner
                    </button>
                    <button type="button" class="btn btn-primary" onclick="location.reload()">
                        <i class="fas fa-sync-alt me-2"></i>
                        Refresh & Coba Lagi
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('style')
<style>
.qrcode-section {
    padding: 1rem 0;
}

.status-cards {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.status-card {
    border-radius: 12px;
    padding: 1.5rem;
    color: white;
    display: flex;
    align-items: center;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.status-icon {
    width: 50px;
    height: 50px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    margin-right: 1rem;
}

.status-content h6 {
    margin: 0;
    font-size: 1rem;
    font-weight: 600;
}

.status-content p {
    margin: 0;
    font-size: 0.9rem;
    opacity: 0.9;
}

.qr-action-card {
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border: 1px solid #e3e6f0;
}

.qr-action-header {
    padding: 1rem;
    color: white;
    font-weight: 600;
    font-size: 1rem;
}

.qr-action-body {
    padding: 1.5rem;
    background: white;
}

.qr-reader {
    border-radius: 12px;
    overflow: hidden;
    background: #f8f9fc;
    min-height: 300px;
    position: relative;
}

.btn-lg {
    padding: 0.75rem 1.5rem;
    font-size: 1rem;
    font-weight: 600;
}

/* Scanner Instructions */
.scanner-instructions {
    background: #f8f9fc;
    border-radius: 12px;
    padding: 1.5rem;
}

.instruction-item {
    padding: 1rem;
}

.instruction-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    color: white;
    font-size: 1.5rem;
}

.instruction-item h6 {
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #2d3748;
}

/* Scanner Container */
.scanner-container {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    background: #000;
    min-height: 350px;
}

.scanner-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    pointer-events: none;
    z-index: 10;
}

.scanner-status {
    position: absolute;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    background: rgba(0, 0, 0, 0.8);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 500;
}

/* QR Code Scanner Enhancements */
#reader {
    border: none !important;
    background: transparent !important;
}

#reader > div {
    border: none !important;
}

#reader video {
    border-radius: 8px !important;
    object-fit: cover !important;
}

#reader canvas {
    border-radius: 8px !important;
}

/* QR Box Styling */
#qr-shaded-region {
    border: 3px solid #007bff !important;
    border-radius: 15px !important;
    box-shadow: 0 0 20px rgba(0, 123, 255, 0.3) !important;
}

/* Scanner Controls */
#reader__dashboard_section {
    background: rgba(255, 255, 255, 0.95) !important;
    border-radius: 8px !important;
    margin: 10px !important;
    padding: 10px !important;
}

#reader__dashboard_section button {
    background: #007bff !important;
    border: none !important;
    border-radius: 6px !important;
    color: white !important;
    padding: 8px 16px !important;
    font-weight: 500 !important;
}

#reader__dashboard_section select {
    border: 1px solid #ddd !important;
    border-radius: 6px !important;
    padding: 6px 12px !important;
}

/* Toast Container */
.toast-container {
    z-index: 9999 !important;
}

.toast {
    border: none !important;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1) !important;
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .status-card {
        padding: 1rem;
    }
    
    .status-icon {
        width: 40px;
        height: 40px;
        font-size: 1rem;
    }
    
    .qr-action-body {
        padding: 1rem;
    }
    
    .scanner-instructions {
        padding: 1rem;
    }
    
    .instruction-icon {
        width: 50px;
        height: 50px;
        font-size: 1.2rem;
    }
    
    .scanner-container {
        min-height: 280px;
    }
    
    .modal-lg {
        max-width: 95% !important;
    }
}

/* Loading Animation */
@keyframes pulse {
    0% { opacity: 1; }
    50% { opacity: 0.5; }
    100% { opacity: 1; }
}

.scanner-status {
    animation: pulse 2s infinite;
}

/* Success Animation */
@keyframes checkmark {
    0% { transform: scale(0); }
    50% { transform: scale(1.2); }
    100% { transform: scale(1); }
}

.success-checkmark {
    animation: checkmark 0.6s ease-in-out;
}
</style>
@endpush

@push('script')
<script src="{{ asset('html5-qrcode/html5-qrcode.min.js') }}"></script>
<script>
    const enterPresenceUrl = "{{ route('home.sendEnterPresenceUsingQRCode') }}";
    const outPresenceUrl = "{{ route('home.sendOutPresenceUsingQRCode') }}";
</script>
<script type="module" src="{{ asset('js/home/qrcode.js') }}"></script>
@endpush