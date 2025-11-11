{{-- resources/views/surat_kuasa/edit.blade.php --}}
@extends('layouts.layout')

@section('title', 'Edit Surat Kuasa')

@section('content')
<div class="main-content p-4">
    <div class="content-card p-4 rounded-3 shadow-sm">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0 fw-bold text-primary">Edit Surat Kuasa</h4>
            <a href="{{ route('surat-kuasa.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
        </div>

        <form action="{{ route('surat-kuasa.update', $suratKuasa) }}" method="POST">
            @csrf @method('PUT')
            <div class="row g-3">

                <!-- NOMOR -->
                <div class="col-md-6">
                    <label>Nomor Surat <span class="text-danger">*</span></label>
                    <input type="text" name="nomor" class="form-control @error('nomor') is-invalid @enderror"
                           value="{{ old('nomor', $suratKuasa->nomor) }}" required>
                    @error('nomor') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- PEMBERI KUASA -->
                <div class="col-md-6">
                    <label>Pemberi Kuasa <span class="text-danger">*</span></label>
                    <select name="pemberi_kuasa_id" class="form-select @error('pemberi_kuasa_id') is-invalid @enderror" required onchange="fillPemberi(this)">
                        <option value="">-- Pilih Warga --</option>
                        @foreach($warga as $w)
                            <option value="{{ $w->id }}"
                                data-nama="{{ $w->nama }}"
                                data-jabatan="{{ $w->jabatan?->nama ?? '-' }}"
                                {{ old('pemberi_kuasa_id', $suratKuasa->pemberi_kuasa_id) == $w->id ? 'selected' : '' }}>
                                {{ $w->nama }} - {{ $w->jabatan?->nama ?? 'Tanpa Jabatan' }}
                            </option>
                        @endforeach
                    </select>
                    @error('pemberi_kuasa_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- PENERIMA KUASA -->
                <div class="col-md-6">
                    <label>Penerima Kuasa <span class="text-danger">*</span></label>
                    <select name="penerima_kuasa_id" class="form-select @error('penerima_kuasa_id') is-invalid @enderror" required onchange="fillPenerima(this)">
                        <option value="">-- Pilih Warga --</option>
                        @foreach($warga as $w)
                            <option value="{{ $w->id }}"
                                data-nama="{{ $w->nama }}"
                                data-jabatan="{{ $w->jabatan?->nama ?? '-' }}"
                                {{ old('penerima_kuasa_id', $suratKuasa->penerima_kuasa_id) == $w->id ? 'selected' : '' }}>
                                {{ $w->nama }} - {{ $w->jabatan?->nama ?? 'Tanpa Jabatan' }}
                            </option>
                        @endforeach
                    </select>
                    @error('penerima_kuasa_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- TAMPILKAN INFO -->
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Pemberi:</strong> <span id="pemberi-info">
                                {{ $suratKuasa->pemberiKuasa?->nama ?? '-' }} - {{ $suratKuasa->pemberiKuasa?->jabatan?->nama ?? '-' }}
                            </span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Penerima:</strong> <span id="penerima-info">
                                {{ $suratKuasa->penerimaKuasa?->nama ?? '-' }} - {{ $suratKuasa->penerimaKuasa?->jabatan?->nama ?? '-' }}
                            </span></p>
                        </div>
                    </div>
                </div>

                <!-- UNTUK -->
                <div class="col-12">
                    <label>Untuk <span class="text-danger">*</span></label>
                    <textarea name="untuk" rows="4" class="form-control @error('untuk') is-invalid @enderror" required>{{ old('untuk', $suratKuasa->untuk) }}</textarea>
                    @error('untuk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- DIKELUARKAN DI -->
                <div class="col-md-6">
                    <label>Dikeluarkan di (Dusun) <span class="text-danger">*</span></label>
                    <select name="dikeluarkan_di" class="form-select @error('dikeluarkan_di') is-invalid @enderror" required>
                        <option value="">-- Pilih Dusun --</option>
                        @foreach($dusun as $d)
                            <option value="{{ $d->id }}" {{ old('dikeluarkan_di', $suratKuasa->dikeluarkan_di) == $d->id ? 'selected' : '' }}>
                                {{ $d->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('dikeluarkan_di') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- TANGGAL -->
                <div class="col-md-6">
                    <label>Tanggal <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror"
                           value="{{ old('tanggal', $suratKuasa->tanggal?->format('Y-m-d')) }}" required>
                    @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- TANDA TANGAN -->
                <div class="col-md-6">
                    <label>Nama Penanda Tangan <span class="text-danger">*</span></label>
                    <input type="text" name="nama_penanda_tangan" class="form-control @error('nama_penanda_tangan') is-invalid @enderror"
                           value="{{ old('nama_penanda_tangan', $suratKuasa->nama_penanda_tangan) }}" required>
                    @error('nama_penanda_tangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label>Jabatan Penanda Tangan <span class="text-danger">*</span></label>
                    <select name="jabatan_id" class="form-select @error('jabatan_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Jabatan --</option>
                        @foreach($jabatan as $j)
                            <option value="{{ $j->id }}" {{ old('jabatan_id', $suratKuasa->jabatan_id) == $j->id ? 'selected' : '' }}>
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
                        @foreach($suratKuasa->tembusan ?? [] as $t)
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
function fillPemberi(select) {
    const nama = select.selectedOptions[0].dataset.nama;
    const jabatan = select.selectedOptions[0].dataset.jabatan;
    document.getElementById('pemberi-info').textContent = `${nama} - ${jabatan}`;
}
function fillPenerima(select) {
    const nama = select.selectedOptions[0].dataset.nama;
    const jabatan = select.selectedOptions[0].dataset.jabatan;
    document.getElementById('penerima-info').textContent = `${nama} - ${jabatan}`;
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
// Inisialisasi saat edit
document.addEventListener('DOMContentLoaded', function() {
    const pemberi = document.querySelector('[name="pemberi_kuasa_id"]');
    const penerima = document.querySelector('[name="penerima_kuasa_id"]');
    if (pemberi && pemberi.selectedOptions[0]) fillPemberi(pemberi);
    if (penerima && penerima.selectedOptions[0]) fillPenerima(penerima);
});
</script>
@endsection