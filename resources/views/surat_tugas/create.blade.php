{{-- resources/views/surat_tugas/create.blade.php --}}
@extends('layouts.layout')
@section('title', 'Buat Surat Tugas')
@section('content')
<div class="main-content p-4">
    <div class="content-card p-4 rounded-3 shadow-sm">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0 fw-bold text-primary">Buat Surat Tugas</h4>
            <a href="{{ route('surat-tugas.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
        </div>

        <form action="{{ route('surat-tugas.store') }}" method="POST">
            @csrf
            <div class="row g-3">

                <!-- NOMOR -->
                <div class="col-md-6">
                    <label>Nomor Surat</label>
                    <input type="text" name="nomor" class="form-control" value="{{ old('nomor', $nomorOtomatis) }}" readonly>
                </div>

                <!-- DASAR (DINAMIS) -->
                <div class="col-12">
                    <label>Dasar <span class="text-danger">*</span></label>
                    <div id="dasar-container">
                        <div class="input-group mb-2">
                            <input type="text" name="dasar[]" class="form-control" placeholder="Dasar ke-1...">
                            <button class="btn btn-outline-danger" type="button" onclick="this.parentElement.remove()">Hapus</button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-secondary" onclick="addDasar()">+ Tambah Dasar</button>
                </div>

                <!-- PENERIMA TUGAS -->
                <div class="col-md-6">
                    <label>Penerima Tugas <span class="text-danger">*</span></label>
                    <select name="penerima_tugas_id" class="form-select" required onchange="fillPenerima(this)">
                        <option value="">-- Pilih Warga --</option>
                        @foreach($warga as $w)
                            <option value="{{ $w->id }}" data-nama="{{ $w->nama }}" data-jabatan="{{ $w->jabatan?->nama ?? '-' }}"
                                {{ old('penerima_tugas_id') == $w->id ? 'selected' : '' }}>
                                {{ $w->nama }} - {{ $w->jabatan?->nama ?? 'Tanpa Jabatan' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <p><strong>Penerima:</strong> <span id="penerima-info">-</span></p>
                </div>

                <!-- UNTUK -->
                <div class="col-12">
                    <label>Untuk <span class="text-danger">*</span></label>
                    <textarea name="untuk" rows="3" class="form-control" required>{{ old('untuk') }}</textarea>
                </div>

                <!-- PELAKSANAAN -->
                <div class="col-md-4">
                    <label>Hari/Tanggal <span class="text-danger">*</span></label>
                    <input type="text" name="hari_tanggal" class="form-control" value="{{ old('hari_tanggal') }}" required>
                </div>
                <div class="col-md-4">
                    <label>Waktu <span class="text-danger">*</span></label>
                    <input type="text" name="waktu" class="form-control" value="{{ old('waktu') }}" required>
                </div>
                <div class="col-md-4">
                    <label>Tempat <span class="text-danger">*</span></label>
                    <input type="text" name="tempat" class="form-control" value="{{ old('tempat') }}" required>
                </div>

                <!-- DIKELUARKAN -->
                <div class="col-md-6">
                    <label>Dikeluarkan di <span class="text-danger">*</span></label>
                    <select name="dikeluarkan_di" class="form-select" required>
                        <option value="">-- Pilih Dusun --</option>
                        @foreach($dusun as $d)
                            <option value="{{ $d->id }}" {{ old('dikeluarkan_di') == $d->id ? 'selected' : '' }}>{{ $d->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Tanggal <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', now()->format('Y-m-d')) }}" required>
                </div>

                <!-- TANDA TANGAN -->
                <div class="col-md-6">
                    <label>Nama Penanda Tangan <span class="text-danger">*</span></label>
                    <input type="text" name="nama_penanda_tangan" class="form-control" value="{{ old('nama_penanda_tangan') }}" required>
                </div>
                <div class="col-md-6">
                    <label>Jabatan <span class="text-danger">*</span></label>
                    <select name="jabatan_id" class="form-select" required>
                        <option value="">-- Pilih Jabatan --</option>
                        @foreach($jabatan as $j)
                            <option value="{{ $j->id }}" {{ old('jabatan_id') == $j->id ? 'selected' : '' }}>{{ $j->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- TEMBUSAN -->
                <div class="col-12">
                    <label>Tembusan (opsional)</label>
                    <div id="tembusan-container">
                        <div class="input-group mb-2">
                            <input type="text" name="tembusan[]" class="form-control" placeholder="Yth. ...">
                            <button class="btn btn-outline-danger" type="button" onclick="this.parentElement.remove()">Hapus</button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-secondary" onclick="addTembusan()">+ Tambah</button>
                </div>

                <div class="col-12 text-end mt-4">
                    <button type="submit" class="btn btn-primary px-5">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function fillPenerima(select) {
    const nama = select.selectedOptions[0]?.dataset.nama || '-';
    const jabatan = select.selectedOptions[0]?.dataset.jabatan || '-';
    document.getElementById('penerima-info').textContent = `${nama} - ${jabatan}`;
}
function addDasar() {
    const container = document.getElementById('dasar-container');
    const div = document.createElement('div');
    div.className = 'input-group mb-2';
    div.innerHTML = `<input type="text" name="dasar[]" class="form-control" placeholder="Dasar baru...">
                     <button class="btn btn-outline-danger" type="button" onclick="this.parentElement.remove()">Hapus</button>`;
    container.appendChild(div);
}
function addTembusan() {
    const container = document.getElementById('tembusan-container');
    const div = document.createElement('div');
    div.className = 'input-group mb-2';
    div.innerHTML = `<input type="text" name="tembusan[]" class="form-control" placeholder="Yth. ...">
                     <button class="btn btn-outline-danger" type="button" onclick="this.parentElement.remove()">Hapus</button>`;
    container.appendChild(div);
}
</script>
@endsection