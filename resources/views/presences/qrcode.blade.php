@extends('layouts.app')

@push('style')
<style>
    .qrcode-header {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        border-radius: 15px;
        color: white;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        text-align: center;
    }
    
    .qrcode-container {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        text-align: center;
        margin-bottom: 2rem;
        transition: transform 0.3s ease;
    }
    
    .qrcode-container:hover {
        transform: translateY(-5px);
    }
    
    .qrcode-image {
        max-width: 100%;
        height: auto;
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
        cursor: pointer;
    }
    
    .qrcode-image:hover {
        transform: scale(1.05);
    }
    
    .download-section {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        margin-bottom: 2rem;
    }
    
    .download-btn {
        background: linear-gradient(45deg, #667eea, #764ba2);
        color: white;
        border: none;
        padding: 1rem 2rem;
        border-radius: 25px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        transition: all 0.3s ease;
        margin: 0.5rem;
        font-size: 1rem;
    }
    
    .download-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        color: white;
    }
    
    .download-btn.btn-secondary {
        background: linear-gradient(45deg, #6c757d, #495057);
    }
    
    .download-btn.btn-success {
        background: linear-gradient(45deg, #28a745, #20c997);
    }
    
    .info-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
    }
    
    .info-item {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
        padding: 1rem;
        background: rgba(255,255,255,0.1);
        border-radius: 10px;
        backdrop-filter: blur(10px);
    }
    
    .info-item:last-child {
        margin-bottom: 0;
    }
    
    .info-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        background: rgba(255,255,255,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        font-size: 1.5rem;
    }
    
    .instructions-card {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        margin-bottom: 2rem;
    }
    
    .instruction-step {
        display: flex;
        align-items: flex-start;
        margin-bottom: 1.5rem;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 10px;
        border-left: 4px solid #667eea;
    }
    
    .step-number {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: linear-gradient(45deg, #667eea, #764ba2);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        margin-right: 1rem;
        flex-shrink: 0;
    }
    
    .qr-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }
    
    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        border: none;
        transition: transform 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
    }
    
    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 15px;
        margin: 0 auto 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
    }
    
    .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 0.5rem;
    }
    
    .stat-label {
        color: #6c757d;
        font-size: 0.9rem;
    }
    
    @media (max-width: 768px) {
        .qrcode-header {
            padding: 1.5rem;
        }
        
        .qrcode-container {
            padding: 1.5rem;
        }
        
        .download-section {
            padding: 1.5rem;
        }
        
        .download-btn {
            width: 100%;
            justify-content: center;
            margin: 0.5rem 0;
        }
        
        .info-item {
            flex-direction: column;
            text-align: center;
        }
        
        .info-icon {
            margin-right: 0;
            margin-bottom: 1rem;
        }
    }
    
    .fade-in {
        animation: fadeIn 0.6s ease-in;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .pulse {
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="qrcode-header fade-in">
        <h1 class="mb-3 fw-bold">
            <i class="fas fa-qrcode me-3"></i>
            QR Code Absensi
        </h1>
        <p class="mb-0 fs-5 opacity-90">
            Scan QR Code ini untuk melakukan absensi dengan mudah dan cepat
        </p>
    </div>

    <div class="row">
        <!-- QR Code Section -->
        <div class="col-lg-6 mb-4">
            <div class="qrcode-container fade-in">
                <h4 class="mb-4 text-dark fw-bold">
                    <i class="fas fa-mobile-alt me-2 text-primary"></i>
                    Scan QR Code
                </h4>
                <div class="qr-code-wrapper">
                    <img src="{{ $qrcode }}" alt="QR Code Absensi" id="qrcode" class="qrcode-image pulse">
                </div>
                <div class="mt-4">
                    <small class="text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        Klik pada QR Code untuk memperbesar
                    </small>
                </div>
            </div>

            <!-- Download Section -->
            <div class="download-section fade-in">
                <h5 class="mb-4 text-dark fw-bold">
                    <i class="fas fa-download me-2 text-success"></i>
                    Download QR Code
                </h5>
                
                <div class="d-flex flex-wrap justify-content-center">
                    <a href="{{ route('presences.qrcode.download-pdf', ['code' => $code]) }}" class="download-btn">
                        <i class="fas fa-file-pdf"></i>
                        Download PDF
                    </a>
                    <button onclick="downloadQRCode()" class="download-btn btn-secondary">
                        <i class="fas fa-image"></i>
                        Download PNG
                    </button>
                    <button onclick="printQRCode()" class="download-btn btn-success">
                        <i class="fas fa-print"></i>
                        Print QR Code
                    </button>
                </div>
                
                <div class="mt-3">
                    <small class="text-muted">
                        <i class="fas fa-lightbulb me-1"></i>
                        <strong>Tips:</strong> Untuk mendownload QR Code dalam format SVG (dapat diedit), 
                        klik kanan pada gambar QR Code dan pilih "Save image as"
                    </small>
                </div>
            </div>
        </div>

        <!-- Info & Instructions Section -->
        <div class="col-lg-6 mb-4">
            <!-- QR Stats -->
            <div class="qr-stats fade-in">
                <div class="stat-card">
                    <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                        <i class="fas fa-qrcode"></i>
                    </div>
                    <div class="stat-value">{{ $code }}</div>
                    <div class="stat-label">Kode QR</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon bg-success bg-opacity-10 text-success">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-value">24/7</div>
                    <div class="stat-label">Tersedia</div>
                </div>
            </div>

            <!-- Info Card -->
            <div class="info-card fade-in">
                <h5 class="mb-4 fw-bold">
                    <i class="fas fa-info-circle me-2"></i>
                    Informasi QR Code
                </h5>
                
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div>
                        <h6 class="mb-1 fw-bold">Keamanan Terjamin</h6>
                        <p class="mb-0 opacity-90">QR Code ini unik dan aman untuk digunakan</p>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <div>
                        <h6 class="mb-1 fw-bold">Mudah Digunakan</h6>
                        <p class="mb-0 opacity-90">Scan dengan kamera smartphone atau tablet</p>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <h6 class="mb-1 fw-bold">Real-time</h6>
                        <p class="mb-0 opacity-90">Data absensi langsung tersimpan di sistem</p>
                    </div>
                </div>
            </div>

            <!-- Instructions -->
            <div class="instructions-card fade-in">
                <h5 class="mb-4 text-dark fw-bold">
                    <i class="fas fa-list-ol me-2 text-warning"></i>
                    Cara Menggunakan
                </h5>
                
                <div class="instruction-step">
                    <div class="step-number">1</div>
                    <div>
                        <h6 class="fw-bold mb-1">Buka Aplikasi Kamera</h6>
                        <p class="mb-0 text-muted">Buka aplikasi kamera di smartphone atau gunakan aplikasi QR scanner</p>
                    </div>
                </div>
                
                <div class="instruction-step">
                    <div class="step-number">2</div>
                    <div>
                        <h6 class="fw-bold mb-1">Arahkan ke QR Code</h6>
                        <p class="mb-0 text-muted">Arahkan kamera ke QR Code hingga terdeteksi</p>
                    </div>
                </div>
                
                <div class="instruction-step">
                    <div class="step-number">3</div>
                    <div>
                        <h6 class="fw-bold mb-1">Tap Notifikasi</h6>
                        <p class="mb-0 text-muted">Tap notifikasi yang muncul untuk membuka link absensi</p>
                    </div>
                </div>
                
                <div class="instruction-step">
                    <div class="step-number">4</div>
                    <div>
                        <h6 class="fw-bold mb-1">Selesai!</h6>
                        <p class="mb-0 text-muted">Absensi Anda akan tercatat secara otomatis</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- QR Code Modal -->
<div class="modal fade" id="qrcodeModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-qrcode me-2"></i>
                    QR Code Absensi
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img src="{{ $qrcode }}" alt="QR Code Absensi" class="img-fluid">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <a href="{{ route('presences.qrcode.download-pdf', ['code' => $code]) }}" class="btn btn-primary">
                    <i class="fas fa-download me-2"></i>
                    Download PDF
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    // QR Code click handler
    document.getElementById('qrcode').addEventListener('click', function() {
        const modal = new bootstrap.Modal(document.getElementById('qrcodeModal'));
        modal.show();
    });
    
    // Download QR Code as PNG
    function downloadQRCode() {
        const qrImage = document.getElementById('qrcode');
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        
        canvas.width = qrImage.naturalWidth;
        canvas.height = qrImage.naturalHeight;
        
        ctx.drawImage(qrImage, 0, 0);
        
        const link = document.createElement('a');
        link.download = 'qrcode-absensi-{{ $code }}.png';
        link.href = canvas.toDataURL();
        link.click();
    }
    
    // Print QR Code
    function printQRCode() {
        const printWindow = window.open('', '_blank');
        const qrImage = document.getElementById('qrcode');
        
        printWindow.document.write(`
            <html>
                <head>
                    <title>QR Code Absensi</title>
                    <style>
                        body {
                            margin: 0;
                            padding: 20px;
                            text-align: center;
                            font-family: Arial, sans-serif;
                        }
                        .header {
                            margin-bottom: 30px;
                        }
                        .qr-container {
                            margin: 20px 0;
                        }
                        .qr-code {
                            max-width: 300px;
                            height: auto;
                        }
                        .footer {
                            margin-top: 30px;
                            font-size: 14px;
                            color: #666;
                        }
                        @media print {
                            body { margin: 0; }
                        }
                    </style>
                </head>
                <body>
                    <div class="header">
                        <h1>QR Code Absensi</h1>
                        <p>Kode: {{ $code }}</p>
                    </div>
                    <div class="qr-container">
                        <img src="${qrImage.src}" alt="QR Code" class="qr-code">
                    </div>
                    <div class="footer">
                        <p>Scan QR Code ini untuk melakukan absensi</p>
                        <p>Tanggal cetak: ${new Date().toLocaleDateString('id-ID')}</p>
                    </div>
                </body>
            </html>
        `);
        
        printWindow.document.close();
        printWindow.focus();
        
        setTimeout(() => {
            printWindow.print();
            printWindow.close();
        }, 250);
    }
    
    // Add fade-in animation on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    document.querySelectorAll('.fade-in').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(el);
    });
    
    // Copy QR code URL to clipboard
    function copyQRCodeURL() {
        const url = window.location.href;
        navigator.clipboard.writeText(url).then(() => {
            // Show success message
            const toast = document.createElement('div');
            toast.className = 'toast-notification';
            toast.textContent = 'URL QR Code berhasil disalin!';
            toast.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: #28a745;
                color: white;
                padding: 1rem 1.5rem;
                border-radius: 8px;
                z-index: 9999;
                animation: slideIn 0.3s ease;
            `;
            
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.remove();
            }, 3000);
        });
    }
    
    // Add copy URL button functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Add copy URL button if needed
        const downloadSection = document.querySelector('.download-section .d-flex');
        if (downloadSection) {
            const copyBtn = document.createElement('button');
            copyBtn.onclick = copyQRCodeURL;
            copyBtn.className = 'download-btn btn-secondary';
            copyBtn.innerHTML = '<i class="fas fa-copy"></i> Copy URL';
            downloadSection.appendChild(copyBtn);
        }
    });
</script>
@endpush