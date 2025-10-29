@extends('layouts.layout')

@section('title', 'Tambah Data Anggota Keluarga')

@section('content')
<div class="container">
    <h4 class="mb-4">Tambah Anggota Keluarga</h4>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan!</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Kader'))
    <form action="{{ route('data_keluarga_anggota.store') }}" method="POST">
        @csrf

        <!-- Hidden field untuk keluarga_id -->
        <input type="hidden" name="keluarga_id" value="{{ request()->route('keluarga_id') }}">

        <div class="mb-3">
            <label for="warga_id" class="form-label">Warga</label>
            <select name="warga_id" id="warga_id" class="form-select" required>
                <option value="">-- Pilih Warga --</option>
                @foreach($warga as $item)
                    <option value="{{ $item->id }}" {{ old('warga_id') == $item->id ? 'selected' : '' }}>
                        {{ $item->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Informasi tambahan warga -->
        <div id="warga-info" class="border rounded p-3 mb-3 bg-light" style="display: none;">
            <h6>Informasi Warga</h6>
            <p><strong>No Registrasi:</strong> <span id="no_registrasi"></span></p>
            <p><strong>Jenis Kelamin:</strong> <span id="jenis_kelamin"></span></p>
            <p><strong>Tanggal Lahir:</strong> <span id="tanggal_lahir"></span></p>
            <p><strong>Pendidikan:</strong> <span id="ref_pendidikan"></span></p>
            <p><strong>Pekerjaan:</strong> <span id="ref_pekerjaan"></span></p>
        </div>

        <div class="mb-3">
            <label for="status_dalam_keluarga_id" class="form-label">Status Dalam Keluarga</label>
            <select name="status_dalam_keluarga_id" id="status_dalam_keluarga_id" class="form-select" required>
                <option value="">-- Pilih Status --</option>
                @foreach($status as $item)
                    <option value="{{ $item->id }}" {{ old('status_dalam_keluarga_id') == $item->id ? 'selected' : '' }}>
                        {{ $item->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('data_keluarga_anggota.index', request()->route('keluarga_id')) }}" class="btn btn-secondary">Batal</a>
    </form>
    @else
        <div class="alert alert-warning">Anda tidak memiliki izin untuk menambahkan data.</div>
    @endif
</div>

<script>
    // Data warga dalam format JS untuk menampilkan info tambahan
    const wargaData = @json($warga);

    document.getElementById('warga_id').addEventListener('change', function() {
        const wargaId = this.value;
        const warga = wargaData.find(w => w.id == wargaId);

        if (warga) {
            document.getElementById('no_registrasi').textContent = warga.no_registrasi || '-';
            document.getElementById('jenis_kelamin').textContent = warga.jenis_kelamin === 'L' ? 'Laki-laki' :
                warga.jenis_kelamin === 'P' ? 'Perempuan' : '-';
            document.getElementById('tanggal_lahir').textContent = warga.tanggal_lahir || '-';
            document.getElementById('ref_pendidikan').textContent = warga.pendidikan?.nama || '-';
            document.getElementById('ref_pekerjaan').textContent = warga.pekerjaan?.nama || '-';
            document.getElementById('warga-info').style.display = 'block';
        } else {
            document.getElementById('warga-info').style.display = 'none';
        }
    });
</script>
@endsection