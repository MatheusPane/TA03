{{-- resources/views/surat_kuasa/create.blade.php --}}
@extends('layouts.layout')

@section('title', 'Buat Surat Kuasa')

@section('content')
<div class="main-content p-4">
    <div class="content-card p-4 rounded-3 shadow-sm">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0 fw-bold text-primary">Buat Surat Kuasa</h4>
            <a href="{{ route('surat-kuasa.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
        </div>

        <!-- FORM DENGAN CSRF & METHOD POST -->
        <form action="{{ route('surat-kuasa.store') }}" method="POST">
            @csrf
            <div class="row g-3">

                <!-- NOMOR OTOMATIS (READONLY) -->
                <div class="col-md-6">
                    <label>Nomor Surat <span class="text-danger">*</span></label>
                    <input type="text" name="nomor" class="form-control @error('nomor') is-invalid @enderror"
                           value="{{ old('nomor', $nomorOtomatis) }}" readonly>
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
                                {{ old('pemberi_kuasa_id') == $w->id ? 'selected' : '' }}>
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
                                {{ old('penerima_kuasa_id') == $w->id ? 'selected' : '' }}>
                                {{ $w->nama }} - {{ $w->jabatan?->nama ?? 'Tanpa Jabatan' }}
                            </option>
                        @endforeach
                    </select>
                    @error('penerima_kuasa_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- TAMPILKAN INFO OTOMATIS -->
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Pemberi:</strong> <span id="pemberi-info" class="text-muted">
                                {{ old('pemberi_kuasa_id') ? ($warga->find(old('pemberi_kuasa_id'))?->nama ?? '-') . ' - ' . ($warga->find(old('pemberi_kuasa_id'))?->jabatan?->nama ?? '-') : '-' }}
                            </span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Penerima:</strong> <span id="penerima-info" class="text-muted">
                                {{ old('penerima_kuasa_id') ? ($warga->find(old('penerima_kuasa_id'))?->nama ?? '-') . ' - ' . ($warga->find(old('penerima_kuasa_id'))?->jabatan?->nama ?? '-') : '-' }}
                            </span></p>
                        </div>
                    </div>
                </div>

                <!-- UNTUK -->
                <div class="col-12">
                    <label>Untuk <span class="text-danger">*</span></label>
                    <textarea name="untuk" rows="4" class="form-control @error('untuk') is-invalid @enderror" required>{{ old('untuk') }}</textarea>
                    @error('untuk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- DIKELUARKAN DI -->
                <div class="col-md-6">
                    <label>Dikeluarkan di (Dusun) <span class="text-danger">*</span></label>
                    <select name="dikeluarkan_di" class="form-select @error('dikeluarkan_di') is-invalid @enderror" required>
                        <option value="">-- Pilih Dusun --</option>
                        @foreach($dusun as $d)
                            <option value="{{ $d->id }}" {{ old('dikeluarkan_di') == $d->id ? 'selected' : '' }}>
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
                           value="{{ old('tanggal', now()->format('Y-m-d')) }}" required>
                    @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- TANDA TANGAN -->
                <div class="col-md-6">
                    <label>Nama Penanda Tangan <span class="text-danger">*</span></label>
                    <input type="text" name="nama_penanda_tangan" class="form-control @error('nama_penanda_tangan') is-invalid @enderror"
                           value="{{ old('nama_penanda_tangan') }}" required>
                    @error('nama_penanda_tangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label>Jabatan Penanda Tangan <span class="text-danger">*</span></label>
                    <select name="jabatan_id" class="form-select @error('jabatan_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Jabatan --</option>
                        @foreach($jabatan as $j)
                            <option value="{{ $j->id }}" {{ old('jabatan_id') == $j->id ? 'selected' : '' }}>
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
                        @if(old('tembusan'))
                            @foreach(old('tembusan') as $t)
                                @if($t)
                                <div class="input-group mb-2">
                                    <input type="text" name="tembusan[]" class="form-control" value="{{ $t }}">
                                    <button class="btn btn-outline-danger" type="button" onclick="this.parentElement.remove()">Hapus</button>
                                </div>
                                @endif
                            @endforeach
                        @else
                            <div class="input-group mb-2">
                                <input type="text" name="tembusan[]" class="form-control" placeholder="Yth. ...">
                                <button class="btn btn-outline-danger" type="button" onclick="this.parentElement.remove()">Hapus</button>
                            </div>
                        @endif
                    </div>
                    <button type="button" class="btn btn-sm btn-secondary" onclick="addTembusan()">+ Tambah Tembusan</button>
                </div>

                <!-- TOMBOL SUBMIT -->
                <div class="col-12 text-end mt-4">
                    <button type="submit" class="btn btn-primary px-5">
                        Simpan Surat Kuasa
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function fillPemberi(select) {
    const nama = select.selectedOptions[0]?.dataset.nama || '-';
    const jabatan = select.selectedOptions[0]?.dataset.jabatan || '-';
    document.getElementById('pemberi-info').textContent = `${nama} - ${jabatan}`;
}
function fillPenerima(select) {
    const nama = select.selectedOptions[0]?.dataset.nama || '-';
    const jabatan = select.selectedOptions[0]?.dataset.jabatan || '-';
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

// Inisialisasi saat halaman dibuka (jika ada old input)
document.addEventListener('DOMContentLoaded', () => {
    const pemberi = document.querySelector('[name="pemberi_kuasa_id"]');
    const penerima = document.querySelector('[name="penerima_kuasa_id"]');
    if (pemberi?.value) fillPemberi(pemberi);
    if (penerima?.value) fillPenerima(penerima);
});
</script>
@endsection