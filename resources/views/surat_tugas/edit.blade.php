{{-- resources/views/surat_tugas/edit.blade.php --}}
@extends('layouts.layout')

@section('title', 'Edit Surat Tugas')

@section('content')
<div class="main-content p-4">
    <div class="content-card p-4 rounded-3 shadow-sm">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0 fw-bold text-primary">Edit Surat Tugas</h4>
            <a href="{{ route('surat-tugas.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
        </div>

        <form action="{{ route('surat-tugas.update', $suratTuga) }}" method="POST">
            @csrf @method('PUT')
            <div class="row g-3">

                <!-- NOMOR -->
                <div class="col-md-6">
                    <label>Nomor Surat</label>
                    <input type="text" name="nomor" class="form-control @error('nomor') is-invalid @enderror"
                           value="{{ old('nomor', $suratTuga->nomor) }}" readonly>
                    @error('nomor') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- DASAR (DINAMIS) -->
                <div class="col-12">
                    <label>Dasar</label>
                    <div id="dasar-container">
                        @foreach($suratTuga->dasar ?? [] as $d)
                            @if($d)
                            <div class="input-group mb-2">
                                <input type="text" name="dasar[]" class="form-control" value="{{ $d }}">
                                <button class="btn btn-outline-danger" type="button" onclick="this.parentElement.remove()">Hapus</button>
                            </div>
                            @endif
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-sm btn-secondary" onclick="addDasar()">+ Tambah Dasar</button>
                </div>

                <!-- PENERIMA TUGAS -->
                <div class="col-md-6">
                    <label>Penerima Tugas <span class="text-danger">*</span></label>
                    <select name="penerima_tugas_id" class="form-select @error('penerima_tugas_id') is-invalid @enderror" required onchange="fillPenerima(this)">
                        <option value="">-- Pilih Warga --</option>
                        @foreach($warga as $w)
                            <option value="{{ $w->id }}"
                                data-nama="{{ $w->nama }}"
                                data-jabatan="{{ $w->jabatan?->nama ?? '-' }}"
                                {{ old('penerima_tugas_id', $suratTuga->penerima_tugas_id) == $w->id ? 'selected' : '' }}>
                                {{ $w->nama }} - {{ $w->jabatan?->nama ?? 'Tanpa Jabatan' }}
                            </option>
                        @endforeach
                    </select>
                    @error('penerima_tugas_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <p><strong>Penerima:</strong> <span id="penerima-info">
                        {{ $suratTuga->penerimaTugas?->nama ?? '-' }} - {{ $suratTuga->penerimaTugas?->jabatan?->nama ?? '-' }}
                    </span></p>
                </div>

                <!-- UNTUK -->
                <div class="col-12">
                    <label>Untuk <span class="text-danger">*</span></label>
                    <textarea name="untuk" rows="3" class="form-control @error('untuk') is-invalid @enderror" required>{{ old('untuk', $suratTuga->untuk) }}</textarea>
                    @error('untuk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- PELAKSANAAN -->
                <div class="col-md-4">
                    <label>Hari/Tanggal <span class="text-danger">*</span></label>
                    <input type="text" name="hari_tanggal" class="form-control @error('hari_tanggal') is-invalid @enderror"
                           value="{{ old('hari_tanggal', $suratTuga->hari_tanggal) }}" required>
                    @error('hari_tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label>Waktu <span class="text-danger">*</span></label>
                    <input type="text" name="waktu" class="form-control @error('waktu') is-invalid @enderror"
                           value="{{ old('waktu', $suratTuga->waktu) }}" required>
                    @error('waktu') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label>Tempat <span class="text-danger">*</span></label>
                    <input type="text" name="tempat" class="form-control @error('tempat') is-invalid @enderror"
                           value="{{ old('tempat', $suratTuga->tempat) }}" required>
                    @error('tempat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- DIKELUARKAN -->
                <div class="col-md-6">
                    <label>Dikeluarkan di <span class="text-danger">*</span></label>
                    <select name="dikeluarkan_di" class="form-select @error('dikeluarkan_di') is-invalid @enderror" required>
                        <option value="">-- Pilih Dusun --</option>
                        @foreach($dusun as $d)
                            <option value="{{ $d->id }}" {{ old('dikeluarkan_di', $suratTuga->dikeluarkan_di) == $d->id ? 'selected' : '' }}>
                                {{ $d->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('dikeluarkan_di') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label>Tanggal <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror"
                           value="{{ old('tanggal', $suratTuga->tanggal?->format('Y-m-d')) }}" required>
                    @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- TANDA TANGAN -->
                <div class="col-md-6">
                    <label>Nama Penanda Tangan <span class="text-danger">*</span></label>
                    <input type="text" name="nama_penanda_tangan" class="form-control @error('nama_penanda_tangan') is-invalid @enderror"
                           value="{{ old('nama_penanda_tangan', $suratTuga->nama_penanda_tangan) }}" required>
                    @error('nama_penanda_tangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label>Jabatan <span class="text-danger">*</span></label>
                    <select name="jabatan_id" class="form-select @error('jabatan_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Jabatan --</option>
                        @foreach($jabatan as $j)
                            <option value="{{ $j->id }}" {{ old('jabatan_id', $suratTuga->jabatan_id) == $j->id ? 'selected' : '' }}>
                                {{ $j->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('jabatan_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- TEMBUSAN -->
                <div class="col-12">
                    <label>Tembusan (opsional)</label>
                    <div id="tembusan-container">
                        @foreach($suratTuga->tembusan ?? [] as $t)
                            @if($t)
                            <div class="input-group mb-2">
                                <input type="text" name="tembusan[]" class="form-control" value="{{ $t }}">
                                <button class="btn btn-outline-danger" type="button" onclick="this.parentElement.remove()">Hapus</button>
                            </div>
                            @endif
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-sm btn-secondary" onclick="addTembusan()">+ Tambah Tembusan</button>
                </div>

                <!-- TOMBOL -->
                <div class="col-12 text-end mt-4">
                    <button type="submit" class="btn btn-warning px-4">Update</button>
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
    div.innerHTML = `
        <input type="text" name="dasar[]" class="form-control" placeholder="Dasar baru...">
        <button class="btn btn-outline-danger" type="button" onclick="this.parentElement.remove()">Hapus</button>
    `;
    container.appendChild(div);
}
function addTembusan() {
    const container = document.getElementById('tembusan-container');
    const div = document.createElement('div');
    div.className = 'input-group mb-2';
    div.innerHTML = `
        <input type="text" name="tembusan[]" class="form-control" placeholder="Yth. ...">
        <button class="btn btn-outline-danger" type="button" onclick="this.parentElement.remove()">Hapus</button>
    `;
    container.appendChild(div);
}
// Inisialisasi
document.addEventListener('DOMContentLoaded', function() {
    const penerima = document.querySelector('[name="penerima_tugas_id"]');
    if (penerima && penerima.selectedOptions[0]) fillPenerima(penerima);
});
</script>
@endsection