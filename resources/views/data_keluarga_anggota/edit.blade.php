@extends('layouts.layout')

@section('content')
<div class="container">
    <h4 class="mb-4">Edit Anggota Keluarga</h4>

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
    <form action="{{ route('data_keluarga_anggota.update', $anggota->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="keluarga_id" class="form-label">Keluarga</label>
            <select name="keluarga_id" id="keluarga_id" class="form-select" required>
                @foreach($keluarga as $item)
                    <option value="{{ $item->id }}" {{ $anggota->keluarga_id == $item->id ? 'selected' : '' }}>
                        {{ $item->no_kk }} - {{ $item->nama_kepala_keluarga }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="warga_id" class="form-label">Warga</label>
            <select name="warga_id" id="warga_id" class="form-select" required>
                @foreach($warga as $item)
                    <option value="{{ $item->id }}" {{ $anggota->warga_id == $item->id ? 'selected' : '' }}>
                        {{ $item->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Informasi tambahan warga --}}
        <div id="warga-info" class="border rounded p-3 mb-3 bg-light">
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
                @foreach($status as $item)
                    <option value="{{ $item->id }}" {{ $anggota->status_dalam_keluarga_id == $item->id ? 'selected' : '' }}>
                        {{ $item->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('data_keluarga_anggota.index') }}" class="btn btn-secondary">Batal</a>
    </form>
    @else
        <div class="alert alert-warning">Anda tidak memiliki izin untuk mengedit data.</div>
    @endif
</div>

<script>
    // Pastikan warga berisi relasi pendidikan dan pekerjaan (pakai eager loading di controller)
    const wargaData = @json($warga);

    function updateWargaInfo(wargaId) {
        const warga = wargaData.find(w => w.id == wargaId);
        if (warga) {
            document.getElementById('no_registrasi').textContent = warga.no_registrasi || '-';
            document.getElementById('jenis_kelamin').textContent = warga.jenis_kelamin || '-';
            document.getElementById('tanggal_lahir').textContent = warga.tanggal_lahir || '-';
            document.getElementById('ref_pendidikan').textContent = warga.pendidikan?.nama ?? '-';
            document.getElementById('ref_pekerjaan').textContent = warga.pekerjaan?.nama ?? '-';
        } else {
            document.getElementById('no_registrasi').textContent = '-';
            document.getElementById('jenis_kelamin').textContent = '-';
            document.getElementById('tanggal_lahir').textContent = '-';
            document.getElementById('ref_pendidikan').textContent = '-';
            document.getElementById('ref_pekerjaan').textContent = '-';
        }
    }

    // Event listener untuk update data saat user ganti warga
    document.getElementById('warga_id').addEventListener('change', function() {
        updateWargaInfo(this.value);
    });

    // Jalankan saat pertama kali halaman dibuka (data default)
    updateWargaInfo(document.getElementById('warga_id').value);
</script>
@endsection
