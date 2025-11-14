@extends('layouts.layout')

@section('title', 'Edit Detail Keluarga: ' . $keluarga->no_kk)

@section('content')
<div class="main-content p-4">
    <div class="content-card" style="border-radius: 15px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <div class="card-header-custom" style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); color: white; padding: 15px;">
            <h4 style="font-weight: 700; margin: 0;">
                Edit Detail Fasilitas Keluarga
            </h4>
            <a href="{{ route('data_keluarga.show', $keluarga->id) }}" class="btn btn-light" style="border-radius: 10px;">
                Kembali
            </a>
        </div>

        <div class="p-4">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 10px;">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 10px;">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <form action="{{ route('data_keluarga.detail.update', $keluarga->id) }}" method="POST">
                @csrf @method('PUT')

                <!-- MAKANAN POKOK -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Makanan Pokok Sehari-hari <span class="text-danger">*</span></label>
                        <select name="makanan_pokok" class="form-select @error('makanan_pokok') is-invalid @enderror" required>
                            <option value="">-- Pilih --</option>
                            <option value="Beras" {{ old('makanan_pokok', $detail->makanan_pokok) == 'Beras' ? 'selected' : '' }}>Beras</option>
                            <option value="Non Beras" {{ old('makanan_pokok', $detail->makanan_pokok) == 'Non Beras' ? 'selected' : '' }}>Non Beras</option>
                        </select>
                        @error('makanan_pokok') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6" id="nonBerasField" style="display: {{ old('makanan_pokok', $detail->makanan_pokok) == 'Non Beras' ? 'block' : 'none' }};">
                        <label class="form-label">Jenis Makanan Pokok Lain</label>
                        <select name="makanan_pokok_lain_id" class="form-select @error('makanan_pokok_lain_id') is-invalid @enderror">
                            <option value="">-- Pilih --</option>
                            @foreach(\App\Models\RefMakananPokok::orderBy('nama')->get() as $ref)
                                <option value="{{ $ref->id }}" {{ old('makanan_pokok_lain_id', $detail->makanan_pokok_lain_id) == $ref->id ? 'selected' : '' }}>{{ $ref->nama }}</option>
                            @endforeach
                        </select>
                        @error('makanan_pokok_lain_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <!-- JAMBAN -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Punya Jamban Keluarga? <span class="text-danger">*</span></label>
                        <select name="punya_jamban" class="form-select @error('punya_jamban') is-invalid @enderror" required>
                            <option value="">-- Pilih --</option>
                            <option value="1" {{ old('punya_jamban', $detail->punya_jamban) ? 'selected' : '' }}>Ya</option>
                            <option value="0" {{ old('punya_jamban', $detail->punya_jamban) == '0' ? 'selected' : '' }}>Tidak</option>
                        </select>
                        @error('punya_jamban') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6" id="jumlahJambanField" style="display: {{ old('punya_jamban', $detail->punya_jamban) ? 'block' : 'none' }};">
                        <label class="form-label">Jumlah Jamban</label>
                        <input type="number" name="jumlah_jamban" class="form-control @error('jumlah_jamban') is-invalid @enderror" 
                               value="{{ old('jumlah_jamban', $detail->jumlah_jamban) }}" min="1" placeholder="Contoh: 1">
                        @error('jumlah_jamban') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <!-- SUMBER AIR -->
                <div class="mb-4">
                    <label class="form-label">Sumber Air Keluarga</label>
                    <select name="sumber_air_id" class="form-select @error('sumber_air_id') is-invalid @enderror">
                        <option value="">-- Pilih --</option>
                        @foreach(\App\Models\RefSumberAir::orderBy('nama')->get() as $ref)
                            <option value="{{ $ref->id }}" {{ old('sumber_air_id', $detail->sumber_air_id) == $ref->id ? 'selected' : '' }}>{{ $ref->nama }}</option>
                        @endforeach
                    </select>
                    @error('sumber_air_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- FASILITAS LAIN (YA/TIDAK) -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label class="form-label">Tempat Sampah? <span class="text-danger">*</span></label>
                        <select name="punya_tempat_sampah" class="form-select" required>
                            <option value="1" {{ old('punya_tempat_sampah', $detail->punya_tempat_sampah) ? 'selected' : '' }}>Ya</option>
                            <option value="0" {{ old('punya_tempat_sampah', $detail->punya_tempat_sampah) == '0' ? 'selected' : '' }}>Tidak</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Saluran Limbah? <span class="text-danger">*</span></label>
                        <select name="punya_saluran_limbah" class="form-select" required>
                            <option value="1" {{ old('punya_saluran_limbah', $detail->punya_saluran_limbah) ? 'selected' : '' }}>Ya</option>
                            <option value="0" {{ old('punya_saluran_limbah', $detail->punya_saluran_limbah) == '0' ? 'selected' : '' }}>Tidak</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Stiker P4K? <span class="text-danger">*</span></label>
                        <select name="stiker_p4k" class="form-select" required>
                            <option value="1" {{ old('stiker_p4k', $detail->stiker_p4k) ? 'selected' : '' }}>Ya</option>
                            <option value="0" {{ old('stiker_p4k', $detail->stiker_p4k) == '0' ? 'selected' : '' }}>Tidak</option>
                        </select>
                    </div>
                </div>

                <!-- KRITERIA RUMAH -->
                <div class="mb-4">
                    <label class="form-label">Kriteria Rumah <span class="text-danger">*</span></label>
                    <select name="kriteria_rumah" class="form-select @error('kriteria_rumah') is-invalid @enderror" required>
                        <option value="">-- Pilih --</option>
                        <option value="Sehat" {{ old('kriteria_rumah', $detail->kriteria_rumah) == 'Sehat' ? 'selected' : '' }}>Sehat</option>
                        <option value="Kurang Sehat" {{ old('kriteria_rumah', $detail->kriteria_rumah) == 'Kurang Sehat' ? 'selected' : '' }}>Kurang Sehat</option>
                    </select>
                    @error('kriteria_rumah') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- UP2K -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Aktivitas UP2K? <span class="text-danger">*</span></label>
                        <select name="up2k" class="form-select @error('up2k') is-invalid @enderror" required>
                            <option value="">-- Pilih --</option>
                            <option value="1" {{ old('up2k', $detail->up2k) ? 'selected' : '' }}>Ya</option>
                            <option value="0" {{ old('up2k', $detail->up2k) == '0' ? 'selected' : '' }}>Tidak</option>
                        </select>
                        @error('up2k') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6" id="jenisUsahaField" style="display: {{ old('up2k', $detail->up2k) ? 'block' : 'none' }};">
                        <label class="form-label">Jenis Usaha</label>
                        <select name="jenis_usaha_id" class="form-select @error('jenis_usaha_id') is-invalid @enderror">
                            <option value="">-- Pilih --</option>
                            @foreach(\App\Models\RefJenisUsaha::orderBy('nama')->get() as $ref)
                                <option value="{{ $ref->id }}" {{ old('jenis_usaha_id', $detail->jenis_usaha_id) == $ref->id ? 'selected' : '' }}>{{ $ref->nama }}</option>
                            @endforeach
                        </select>
                        @error('jenis_usaha_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <!-- KESEHATAN LINGKUNGAN -->
                <div class="mb-4">
                    <label class="form-label">Aktivitas Kesehatan Lingkungan? <span class="text-danger">*</span></label>
                    <select name="kesehatan_lingkungan" class="form-select" required>
                        <option value="1" {{ old('kesehatan_lingkungan', $detail->kesehatan_lingkungan) ? 'selected' : '' }}>Ya</option>
                        <option value="0" {{ old('kesehatan_lingkungan', $detail->kesehatan_lingkungan) == '0' ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>
                <!-- TAMBAHAN: STATISTIK KATEGORI KHUSUS -->
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
                    <div class="card-body">
                        <h5 class="card-title text-success mb-3">Statistik Kategori Khusus</h5>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">Jumlah KK <span class="text-danger">*</span></label>
                                <input type="number" name="jumlah_kk" class="form-control @error('jumlah_kk') is-invalid @enderror" 
                                    value="{{ old('jumlah_kk', $detail->jumlah_kk ?? 1) }}" min="0" required>
                                @error('jumlah_kk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Balita <span class="text-danger">*</span></label>
                                <input type="number" name="balita" class="form-control @error('balita') is-invalid @enderror" 
                                    value="{{ old('balita', $detail->balita ?? 0) }}" min="0" required>
                                @error('balita') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">PUS <span class="text-danger">*</span></label>
                                <input type="number" name="pus" class="form-control @error('pus') is-invalid @enderror" 
                                    value="{{ old('pus', $detail->pus ?? 0) }}" min="0" required>
                                @error('pus') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">WUS <span class="text-danger">*</span></label>
                                <input type="number" name="wus" class="form-control @error('wus') is-invalid @enderror" 
                                    value="{{ old('wus', $detail->wus ?? 0) }}" min="0" required>
                                @error('wus') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Buta <span class="text-danger">*</span></label>
                                <input type="number" name="buta" class="form-control @error('buta') is-invalid @enderror" 
                                    value="{{ old('buta', $detail->buta ?? 0) }}" min="0" required>
                                @error('buta') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Ibu Hamil <span class="text-danger">*</span></label>
                                <input type="number" name="ibu_hamil" class="form-control @error('ibu_hamil') is-invalid @enderror" 
                                    value="{{ old('ibu_hamil', $detail->ibu_hamil ?? 0) }}" min="0" required>
                                @error('ibu_hamil') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Ibu Menyusui <span class="text-danger">*</span></label>
                                <input type="number" name="ibu_menyusui" class="form-control @error('ibu_menyusui') is-invalid @enderror" 
                                    value="{{ old('ibu_menyusui', $detail->ibu_menyusui ?? 0) }}" min="0" required>
                                @error('ibu_menyusui') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Lansia <span class="text-danger">*</span></label>
                                <input type="number" name="lansia" class="form-control @error('lansia') is-invalid @enderror" 
                                    value="{{ old('lansia', $detail->lansia ?? 0) }}" min="0" required>
                                @error('lansia') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <!-- TOMBOL -->
                <div class="text-end">
                    <button type="submit" class="btn btn-primary" style="border-radius: 10px;">
                        Simpan Detail
                    </button>
                    <a href="{{ route('data_keluarga.show', $keluarga->id) }}" class="btn btn-secondary" style="border-radius: 10px;">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const makananSelect = document.querySelector('[name="makanan_pokok"]');
    const nonBerasField = document.getElementById('nonBerasField');
    const punyaJamban = document.querySelector('[name="punya_jamban"]');
    const jumlahJambanField = document.getElementById('jumlahJambanField');
    const up2kSelect = document.querySelector('[name="up2k"]');
    const jenisUsahaField = document.getElementById('jenisUsahaField');

    function toggleFields() {
        nonBerasField.style.display = makananSelect.value === 'Non Beras' ? 'block' : 'none';
        jumlahJambanField.style.display = punyaJamban.value === '1' ? 'block' : 'none';
        jenisUsahaField.style.display = up2kSelect.value === '1' ? 'block' : 'none';
    }

    makananSelect?.addEventListener('change', toggleFields);
    punyaJamban?.addEventListener('change', toggleFields);
    up2kSelect?.addEventListener('change', toggleFields);

    toggleFields(); // Initial
});
</script>
@endsection