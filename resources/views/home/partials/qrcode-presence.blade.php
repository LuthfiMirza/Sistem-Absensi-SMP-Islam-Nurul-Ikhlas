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
                    <div class="text-center mb-3">
                        <p class="text-muted">Arahkan kamera ke QR Code untuk melakukan absensi</p>
                    </div>
                    <div id="reader" class="qr-reader"></div>
                    <div class="mt-3">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Tips:</strong> Pastikan QR Code terlihat jelas dalam frame kamera
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>
                        Tutup
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
}

.btn-lg {
    padding: 0.75rem 1.5rem;
    font-size: 1rem;
    font-weight: 600;
}

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