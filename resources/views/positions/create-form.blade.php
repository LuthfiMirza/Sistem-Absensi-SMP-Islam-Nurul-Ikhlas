<div>
    <form action="{{ route('positions.store') }}" method="post">
        @csrf
        
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="m-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div id="position-inputs">
            <div class="mb-3 position-input">
                <x-form-label id="name0" label="Nama Divisi / Jurusan 1" />
                <div class="d-flex align-items-center">
                    <x-form-input id="name0" name="positions[0][name]" value="{{ old('positions.0.name') }}" />
                    <select name="positions[0][type]" class="form-select ms-2" style="width: 150px;">
                        <option value="">Pilih Kategori</option>
                        <option value="guru" {{ old('positions.0.type') == 'guru' ? 'selected' : '' }}>Guru</option>
                        <option value="karyawan" {{ old('positions.0.type') == 'karyawan' ? 'selected' : '' }}>Karyawan</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center">
            <button type="submit" class="btn btn-primary">
                Simpan
            </button>
            <button type="button" class="btn btn-light" onclick="addPositionInput()">
                Tambah Input
            </button>
        </div>
    </form>
</div>

<script>
let inputCount = 1;

function addPositionInput() {
    const container = document.getElementById('position-inputs');
    const newInput = document.createElement('div');
    newInput.className = 'mb-3 position-input';
    newInput.innerHTML = `
        <label for="name${inputCount}" class="form-label fw-bold">Nama Divisi / Jurusan ${inputCount + 1} <sup class="text-danger">*</sup></label>
        <div class="d-flex align-items-center">
            <input type="text" name="positions[${inputCount}][name]" id="name${inputCount}" class="form-control" required />
            <select name="positions[${inputCount}][type]" class="form-select ms-2" style="width: 150px;">
                <option value="">Pilih Kategori</option>
                <option value="guru">Guru</option>
                <option value="karyawan">Karyawan</option>
            </select>
            <button type="button" class="btn btn-danger ms-2" onclick="removePositionInput(this)">Hapus</button>
        </div>
    `;
    container.appendChild(newInput);
    inputCount++;
}

function removePositionInput(button) {
    button.closest('.position-input').remove();
}
</script>