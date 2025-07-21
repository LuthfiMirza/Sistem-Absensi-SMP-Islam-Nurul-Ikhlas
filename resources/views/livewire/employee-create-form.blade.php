<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="fas fa-user-plus me-2"></i>
            Tambah Data Guru & Karyawan
        </h5>
        <small class="text-muted">Silakan isi data guru atau karyawan yang akan ditambahkan ke sistem absensi</small>
    </div>
    <div class="card-body">
        <form wire:submit.prevent="saveEmployees" method="post" novalidate>
            @include('partials.alerts')
            
            @foreach ($employees as $i => $employee)
            <div class="employee-form-section mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="text-primary mb-0">
                        <i class="fas fa-user me-2"></i>
                        Data {{ $i + 1 }}
                    </h6>
                    @if ($i > 0)
                    <button class="btn btn-sm btn-outline-danger" wire:click="removeEmployeeInput({{ $i }})"
                        wire:target="removeEmployeeInput({{ $i }})" type="button" wire:loading.attr="disabled">
                        <i class="fas fa-trash me-1"></i>Hapus
                    </button>
                    @endif
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <x-form-label id="name{{ $i }}" label='Nama Lengkap' />
                            <x-form-input id="name{{ $i }}" name="name{{ $i }}" 
                                wire:model.defer="employees.{{ $i }}.name" 
                                placeholder="Masukkan nama lengkap" />
                            <x-form-error key="employees.{{ $i }}.name" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <x-form-label id="email{{ $i }}" label='Email' />
                            <x-form-input id="email{{ $i }}" name="email{{ $i }}" type="email"
                                wire:model.defer="employees.{{ $i }}.email" 
                                placeholder="contoh@email.com" />
                            <x-form-error key="employees.{{ $i }}.email" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <x-form-label id="phone{{ $i }}" label='Nomor Telepon' />
                            <x-form-input id="phone{{ $i }}" name="phone{{ $i }}" 
                                wire:model.defer="employees.{{ $i }}.phone"
                                placeholder="08xxxxxxxxxx" />
                            <x-form-error key="employees.{{ $i }}.phone" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <x-form-label id="password{{ $i }}"
                                label='Password (Opsional)' required="false" />
                            <x-form-input id="password{{ $i }}" name="password{{ $i }}"
                                wire:model.defer="employees.{{ $i }}.password" required="false" 
                                placeholder="Kosongkan untuk password default: 123" />
                            <x-form-error key="employees.{{ $i }}.password" />
                            <small class="text-muted">Default password: "123" jika tidak diisi</small>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <x-form-label id="role_id{{ $i }}" label='Status' />
                            <select class="form-select" name="role_id"
                                wire:model="employees.{{ $i }}.role_id">
                                <option value="">-- Pilih Status --</option>
                                @foreach ($roles->whereIn('id', [2, 3]) as $role)
                                <option value="{{ $role->id }}">
                                    @if($role->name == 'guru')
                                        🎓 Guru
                                    @elseif($role->name == 'karyawan')
                                        👔 Karyawan (Tata Usaha / Penjaga / Security / Lainnya)
                                    @else
                                        {{ ucfirst($role->name) }}
                                    @endif
                                </option>
                                @endforeach
                            </select>
                            <x-form-error key="employees.{{ $i }}.role_id" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            @php
                                $selectedRole = $employees[$i]['role_id'] ?? null;
                                $isGuru = $selectedRole == 3; // ID 3 = guru
                                $isKaryawan = $selectedRole == 2; // ID 2 = karyawan
                            @endphp
                            
                            <x-form-label id="position_id{{ $i }}" 
                                label='{{ $isGuru ? "Mata Pelajaran" : ($isKaryawan ? "Divisi" : "Divisi/Mata Pelajaran") }}' />
                            
                            <select class="form-select" name="position_id"
                                wire:model.defer="employees.{{ $i }}.position_id">
                                <option value="">
                                    @if($isGuru)
                                        -- Pilih Mata Pelajaran --
                                    @elseif($isKaryawan)
                                        -- Pilih Divisi --
                                    @else
                                        -- Pilih Status Terlebih Dahulu --
                                    @endif
                                </option>
                                
                                @if($isGuru)
                                    @foreach ($guruPositions as $position)
                                    <option value="{{ $position->id }}">📚 {{ $position->name }}</option>
                                    @endforeach
                                @elseif($isKaryawan)
                                    @foreach ($karyawanPositions as $position)
                                    <option value="{{ $position->id }}">🏢 {{ $position->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <x-form-error key="employees.{{ $i }}.position_id" />
                            
                            @if($selectedRole)
                            <small class="text-muted mt-1 d-block">
                                @if($isGuru)
                                    📌 Mata pelajaran yang diampu oleh guru
                                @elseif($isKaryawan)
                                    📌 Divisi kerja untuk karyawan non-pengajar
                                @endif
                            </small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            @if ($i < count($employees) - 1)
            <hr class="my-4">
            @endif
            @endforeach

            <div class="d-flex justify-content-between align-items-center mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>
                    Simpan Data
                </button>
                <button class="btn btn-outline-secondary" type="button" wire:click="addEmployeeInput" wire:loading.attr="disabled">
                    <i class="fas fa-plus me-2"></i>
                    Tambah Form Lain
                </button>
            </div>
        </form>
    </div>
</div>

@push('style')
<style>
.employee-form-section {
    background-color: #f8f9fc;
    border-radius: 0.5rem;
    padding: 1.5rem;
    border: 1px solid #e3e6f0;
}

.employee-form-section:hover {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.card-header {
    background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
    color: white;
    border-bottom: none;
}

.card-header .text-muted {
    color: rgba(255, 255, 255, 0.8) !important;
}

.form-select:focus,
.form-control:focus {
    border-color: #4e73df;
    box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
}

.btn-primary {
    background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
    border: none;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #2e59d9 0%, #1a4ba8 100%);
    transform: translateY(-1px);
}

.text-primary {
    color: #4e73df !important;
}
</style>
@endpush