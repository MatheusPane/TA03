@extends('layouts.layout')

@section('title', 'Tambah Data Warga')

@section('content')
<div class="main-content p-4">
    <div class="content-card" style="border-radius: 15px; overflow: hidden; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);">
        <div class="card-header-custom" style="border-bottom: 2px solid rgba(0, 0, 0, 0.05); padding: 15px;">
            <h4 style="font-weight: 700; color: var(--text-dark); margin: 0;">Tambah Data Warga</h4>
            <a href="{{ route('data_warga.index') }}" class="btn btn-secondary" style="background: linear-gradient(135deg, #95a5a6, #bdc3c7); color: white; border-radius: 10px; padding: 6px 12px;">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <form action="{{ route('data_warga.store') }}" method="POST" style="padding: 15px;">
            @csrf

            <div class="row g-3">
                <!-- No Registrasi -->
                <div class="col-md-4">
                    <label class="form-label" style="font-weight: 600; color: var(--text-dark);">No Registrasi</label>
                    <input type="text" name="no_registrasi" value="{{ old('no_registrasi') }}" class="form-control" style="border-radius: 10px; border: 2px solid rgba(0, 0, 0, 0.05);">
                    @error('no_registrasi') <small class="text-danger" style="font-size: 12px;">{{ $message }}</small> @enderror
                </div>

                <!-- No KTP -->
                <div class="col-md-4">
                    <label class="form-label" style="font-weight: 600; color: var(--text-dark);">No KTP</label>
                    <input type="text" name="no_ktp" value="{{ old('no_ktp') }}" class="form-control" style="border-radius: 10px; border: 2px solid rgba(0, 0, 0, 0.05);">
                    @error('no_ktp') <small class="text-danger" style="font-size: 12px;">{{ $message }}</small> @enderror
                </div>

                <!-- Nama -->
                <div class="col-md-4">
                    <label class="form-label" style="font-weight: 600; color: var(--text-dark);">Nama <span class="text-danger">*</span></label>
                    <input type="text" name="nama" value="{{ old('nama') }}" class="form-control" required style="border-radius: 10px; border: 2px solid rgba(0, 0, 0, 0.05);">
                    @error('nama') <small class="text-danger" style="font-size: 12px;">{{ $message }}</small> @enderror
                </div>

                <!-- Jabatan -->
                <div class="col-md-4">
                    <label class="form-label" style="font-weight: 600; color: var(--text-dark);">Jabatan</label>
                    <select name="jabatan_id" class="form-select" style="border-radius: 10px; border: 2px solid rgba(0, 0, 0, 0.05);">
                        <option value="">-- Pilih Jabatan --</option>
                        @foreach($jabatan as $j)
                            <option value="{{ $j->id }}" {{ old('jabatan_id') == $j->id ? 'selected' : '' }}>{{ $j->nama }}</option>
                        @endforeach
                    </select>
                    @error('jabatan_id') <small class="text-danger" style="font-size: 12px;">{{ $message }}</small> @enderror
                </div>

                <!-- Jenis Kelamin -->
                <div class="col-md-4">
                    <label class="form-label" style="font-weight: 600; color: var(--text-dark);">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-select" style="border-radius: 10px; border: 2px solid rgba(0, 0, 0, 0.05);">
                        <option value="">-- Pilih --</option>
                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin') <small class="text-danger" style="font-size: 12px;">{{ $message }}</small> @enderror
                </div>

                <!-- Tempat & Tanggal Lahir -->
                <div class="col-md-4">
                    <label class="form-label" style="font-weight: 600; color: var(--text-dark);">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" class="form-control" style="border-radius: 10px; border: 2px solid rgba(0, 0, 0, 0.05);">
                    @error('tempat_lahir') <small class="text-danger" style="font-size: 12px;">{{ $message }}</small> @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label" style="font-weight: 600; color: var(--text-dark);">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="form-control" style="border-radius: 10px; border: 2px solid rgba(0, 0, 0, 0.05);">
                    @error('tanggal_lahir') <small class="text-danger" style="font-size: 12px;">{{ $message }}</small> @enderror
                </div>

                <!-- Status Perkawinan -->
                <div class="col-md-4">
                    <label class="form-label" style="font-weight: 600; color: var(--text-dark);">Status Perkawinan</label>
                    <select name="status_perkawinan_id" class="form-select" style="border-radius: 10px; border: 2px solid rgba(0, 0, 0, 0.05);">
                        <option value="">-- Pilih --</option>
                        @foreach($statusPerkawinan as $s)
                            <option value="{{ $s->id }}" {{ old('status_perkawinan_id') == $s->id ? 'selected' : '' }}>{{ $s->nama }}</option>
                        @endforeach
                    </select>
                    @error('status_perkawinan_id') <small class="text-danger" style="font-size: 12px;">{{ $message }}</small> @enderror
                </div>

                <!-- Agama -->
                <div class="col-md-4">
                    <label class="form-label" style="font-weight: 600; color: var(--text-dark);">Agama</label>
                    <select name="agama_id" class="form-select" style="border-radius: 10px; border: 2px solid rgba(0, 0, 0, 0.05);">
                        <option value="">-- Pilih --</option>
                        @foreach($agama as $a)
                            <option value="{{ $a->id }}" {{ old('agama_id') == $a->id ? 'selected' : '' }}>{{ $a->nama }}</option>
                        @endforeach
                    </select>
                    @error('agama_id') <small class="text-danger" style="font-size: 12px;">{{ $message }}</small> @enderror
                </div>

                <!-- Pendidikan -->
                <div class="col-md-4">
                    <label class="form-label" style="font-weight: 600; color: var(--text-dark);">Pendidikan</label>
                    <select name="pendidikan_id" class="form-select" style="border-radius: 10px; border: 2px solid rgba(0, 0, 0, 0.05);">
                        <option value="">-- Pilih --</option>
                        @foreach($pendidikan as $p)
                            <option value="{{ $p->id }}" {{ old('pendidikan_id') == $p->id ? 'selected' : '' }}>{{ $p->nama }}</option>
                        @endforeach
                    </select>
                    @error('pendidikan_id') <small class="text-danger" style="font-size: 12px;">{{ $message }}</small> @enderror
                </div>

                <!-- Pekerjaan -->
                <div class="col-md-4">
                    <label class="form-label" style="font-weight: 600; color: var(--text-dark);">Pekerjaan</label>
                    <select name="pekerjaan_id" class="form-select" style="border-radius: 10px; border: 2px solid rgba(0, 0, 0, 0.05);">
                        <option value="">-- Pilih --</option>
                        @foreach($pekerjaan as $pk)
                            <option value="{{ $pk->id }}" {{ old('pekerjaan_id') == $pk->id ? 'selected' : '' }}>{{ $pk->nama }}</option>
                        @endforeach
                    </select>
                    @error('pekerjaan_id') <small class="text-danger" style="font-size: 12px;">{{ $message }}</small> @enderror
                </div>

                <!-- Ikut PAUD -->
                <div class="col-md-4">
                    <label class="form-label" style="font-weight: 600; color: var(--text-dark);">Ikut PAUD</label>
                    <select name="ikut_paud" id="ikut_paud" class="form-select" style="border-radius: 10px; border: 2px solid rgba(0, 0, 0, 0.05);">
                        <option value="">-- Pilih --</option>
                        <option value="ya" {{ old('ikut_paud') == 'ya' ? 'selected' : '' }}>Ya</option>
                        <option value="tidak" {{ old('ikut_paud') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                    </select>
                    @error('ikut_paud') <small class="text-danger" style="font-size: 12px;">{{ $message }}</small> @enderror
                </div>

                <!-- Mengikuti Kelompok Belajar -->
                <div class="col-md-4">
                    <label class="form-label" style="font-weight: 600; color: var(--text-dark);">Mengikuti Kelompok Belajar</label>
                    <select name="ikut_kelompok_belajar" id="ikut_kelompok_belajar" class="form-select" style="border-radius: 10px; border: 2px solid rgba(0, 0, 0, 0.05);">
                        <option value="">-- Pilih --</option>
                        <option value="ya" {{ old('ikut_kelompok_belajar') == 'ya' ? 'selected' : '' }}>Ya</option>
                        <option value="tidak" {{ old('ikut_kelompok_belajar') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                    </select>
                    @error('ikut_kelompok_belajar') <small class="text-danger" style="font-size: 12px;">{{ $message }}</small> @enderror
                </div>

                <!-- Jenis Kelompok Belajar (SELALU ADA, TAPI DIKENDALIKAN JS) -->
                <div class="col-md-4">
                    <label class="form-label" style="font-weight: 600; color: var(--text-dark);">Jenis Kelompok Belajar</label>
                    <select name="jenis_kelompok_belajar_id" id="jenis_kelompok_belajar_id" class="form-select" style="border-radius: 10px; border: 2px solid rgba(0, 0, 0, 0.05);">
                        <option value="">-- Pilih Jenis Kelompok Belajar --</option>
                        @foreach($jenisKelompokBelajar as $item)
                            <option value="{{ $item->id }}" {{ old('jenis_kelompok_belajar_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('jenis_kelompok_belajar_id') <small class="text-danger" style="font-size: 12px;">{{ $message }}</small> @enderror
                </div>

                <!-- Akseptor KB -->
                <div class="col-md-4">
                    <label class="form-label" style="font-weight: 600; color: var(--text-dark);">Akseptor KB</label>
                    <select name="ikut_akseptor_kb" id="ikut_akseptor_kb" class="form-select" style="border-radius: 10px; border: 2px solid rgba(0, 0, 0, 0.05);">
                        <option value="">-- Pilih --</option>
                        <option value="ya" {{ old('ikut_akseptor_kb') == 'ya' ? 'selected' : '' }}>Ya</option>
                        <option value="tidak" {{ old('ikut_akseptor_kb') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                    </select>
                    @error('ikut_akseptor_kb') <small class="text-danger" style="font-size: 12px;">{{ $message }}</small> @enderror
                </div>

                <!-- Jenis Akseptor KB -->
                <div class="col-md-4">
                    <label class="form-label" style="font-weight: 600; color: var(--text-dark);">Jenis Akseptor KB</label>
                    <select name="jenis_akseptor_kb_id" id="jenis_akseptor_kb_id" class="form-select" style="border-radius: 10px; border: 2px solid rgba(0, 0, 0, 0.05);">
                        <option value="">-- Pilih Jenis Akseptor KB --</option>
                        @foreach($jenisAkseptorKb as $ja)
                            <option value="{{ $ja->id }}" {{ old('jenis_akseptor_kb_id') == $ja->id ? 'selected' : '' }}>
                                {{ $ja->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('jenis_akseptor_kb_id') <small class="text-danger" style="font-size: 12px;">{{ $message }}</small> @enderror
                </div>

                <!-- Ikut Koperasi -->
                <div class="col-md-4">
                    <label class="form-label" style="font-weight: 600; color: var(--text-dark);">Ikut Koperasi</label>
                    <select name="ikut_koperasi" id="ikut_koperasi" class="form-select" style="border-radius: 10px; border: 2px solid rgba(0, 0, 0, 0.05);">
                        <option value="">-- Pilih --</option>
                        <option value="ya" {{ old('ikut_koperasi') == 'ya' ? 'selected' : '' }}>Ya</option>
                        <option value="tidak" {{ old('ikut_koperasi') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                    </select>
                    @error('ikut_koperasi') <small class="text-danger" style="font-size: 12px;">{{ $message }}</small> @enderror
                </div>

                <!-- Jenis Koperasi -->
                <div class="col-md-4">
                    <label class="form-label" style="font-weight: 600; color: var(--text-dark);">Jenis Koperasi</label>
                    <select name="jenis_koperasi_id" id="jenis_koperasi_id" class="form-select" style="border-radius: 10px; border: 2px solid rgba(0, 0, 0, 0.05);">
                        <option value="">-- Pilih Jenis Koperasi --</option>
                        @foreach($jenisKoperasi as $jk)
                            <option value="{{ $jk->id }}" {{ old('jenis_koperasi_id') == $jk->id ? 'selected' : '' }}>
                                {{ $jk->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('jenis_koperasi_id') <small class="text-danger" style="font-size: 12px;">{{ $message }}</small> @enderror
                </div>

                <!-- Memiliki Tabungan -->
                <div class="col-md-4">
                    <label class="form-label" style="font-weight: 600; color: var(--text-dark);">Memiliki Tabungan</label>
                    <select name="memiliki_tabungan" class="form-select" style="border-radius: 10px; border: 2px solid rgba(0, 0, 0, 0.05);">
                        <option value="ya" {{ old('memiliki_tabungan') == 'ya' ? 'selected' : '' }}>Ya</option>
                        <option value="tidak" {{ old('memiliki_tabungan') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                    </select>
                    @error('memiliki_tabungan') <small class="text-danger" style="font-size: 12px;">{{ $message }}</small> @enderror
                </div>

                <!-- Status Aktif -->
                <div class="col-md-3">
                    <label class="form-label" style="font-weight: 600; color: var(--text-dark);">Status Aktif</label>
                    <select name="active" class="form-select" style="border-radius: 10px; border: 2px solid rgba(0, 0, 0, 0.05);">
                        <option value="1" {{ old('active', 1) == 1 ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ old('active') == 0 ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    @error('active') <small class="text-danger" style="font-size: 12px;">{{ $message }}</small> @enderror
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg, #95a5a6, #bdc3c7); color: white; padding: 10px 20px; border-radius: 10px; font-weight: 600;">
                    <i class="bi bi-save"></i> Simpan
                </button>
                <a href="{{ route('data_warga.index') }}" class="btn btn-secondary" style="background: linear-gradient(135deg, #95a5a6, #bdc3c7); color: white; padding: 10px 20px; border-radius: 10px; font-weight: 600;">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(document).ready(function () {
    const toggleJenis = (triggerId, targetId) => {
        const $trigger = $(`#${triggerId}`);
        const $target = $(`#${targetId}`);
        const $options = $target.find('option').not(':first');

        const update = () => {
            const isYa = $trigger.val() === 'ya';
            $target.prop('disabled', !isYa);
            $options.prop('disabled', !isYa);
            
            if (!isYa) {
                $target.val('').trigger('change'); // PAKSA KOSONG
            }
        };

        $trigger.on('change', update);
        update(); // Jalankan saat load
    };

    toggleJenis('ikut_kelompok_belajar', 'jenis_kelompok_belajar_id');
    toggleJenis('ikut_akseptor_kb', 'jenis_akseptor_kb_id');
    toggleJenis('ikut_koperasi', 'jenis_koperasi_id');
});
</script>
@endpush