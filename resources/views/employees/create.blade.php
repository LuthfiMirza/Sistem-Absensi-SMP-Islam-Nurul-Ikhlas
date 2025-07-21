@extends('layouts.app')

@section('buttons')
<div class="btn-toolbar mb-2 mb-md-0">
    <div>
        <a href="{{ route('employees.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i>
            Kembali
        </a>
    </div>
</div>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <!-- Info Card -->
        <div class="alert alert-info border-0 mb-4">
            <div class="d-flex align-items-center">
                <i class="fas fa-info-circle fa-2x me-3"></i>
                <div>
                    <h6 class="alert-heading mb-1">Informasi Penting</h6>
                    <p class="mb-0">
                        Halaman ini digunakan untuk menambahkan data guru dan karyawan baru ke sistem absensi SMP Islam Nurul Ikhlas. 
                        Pastikan data yang dimasukkan sudah benar sebelum menyimpan.
                    </p>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <livewire:employee-create-form />

        <!-- Help Card -->
        <div class="card mt-4">
            <div class="card-header bg-light">
                <h6 class="mb-0">
                    <i class="fas fa-question-circle me-2"></i>
                    Bantuan Pengisian Form
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-primary">Status Pengguna:</h6>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-chalkboard-teacher text-success me-2"></i><strong>🎓 Guru:</strong> Tenaga pengajar/pendidik</li>
                            <li><i class="fas fa-user-tie text-info me-2"></i><strong>👔 Karyawan:</strong> Tata Usaha, Penjaga, Security, dll</li>
                        </ul>
                        
                        <h6 class="text-primary mt-3">Divisi/Mata Pelajaran:</h6>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-book text-warning me-2"></i><strong>Guru:</strong> Bahasa Indonesia, Matematika, IPA, dll</li>
                            <li><i class="fas fa-building text-info me-2"></i><strong>Karyawan:</strong> Tata Usaha, Perpustakaan, Security, dll</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-primary">Tips Pengisian:</h6>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success me-2"></i>Email harus unik dan valid</li>
                            <li><i class="fas fa-check text-success me-2"></i>Nomor telepon format: 08xxxxxxxxxx</li>
                            <li><i class="fas fa-check text-success me-2"></i>Password default: "123" jika kosong</li>
                            <li><i class="fas fa-magic text-warning me-2"></i>Pilih status dulu, divisi akan menyesuaikan</li>
                        </ul>
                        
                        <div class="alert alert-info mt-3 p-2">
                            <small><i class="fas fa-lightbulb me-1"></i><strong>Fitur Baru:</strong> Divisi/Mata Pelajaran akan berubah otomatis sesuai status yang dipilih!</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('style')
<style>
.alert-info {
    background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%);
    border-left: 4px solid #17a2b8;
}

.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}
</style>
@endpush