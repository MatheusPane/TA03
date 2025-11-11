{{-- resources/views/surat_biasa/edit.blade.php --}}
@extends('layouts.layout')

@section('title', 'Edit Surat Biasa')

@section('content')
<div class="main-content p-4">
    <div class="content-card p-4 rounded-3 shadow-sm">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0 fw-bold text-primary">Edit Surat Biasa</h4>
            <a href="{{ route('surat-biasa.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
        </div>

        <form action="{{ route('surat-biasa.update', $suratBiasa) }}" method="POST">
            @csrf @method('PUT')
            <div class="row g-3">

                <!-- NOMOR & LAMPIRAN -->
                <div class="col-md-6">
                    <label>Nomor Surat <span class="text-danger">*</span></label>
                    <input type="text" name="nomor" class="form-control @error('nomor') is-invalid @enderror"
                           value="{{ old('nomor', $suratBiasa->nomor) }}" required>
                    @error('nomor') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label>Lampiran</label>
                    <input type="text" name="lampiran" class="form-control @error('lampiran') is-invalid @enderror"
                           value="{{ old('lampiran', $suratBiasa->lampiran) }}">
                    @error('lampiran') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- PERIHAL & KEPADA -->
                <div class="col-md-6">
                    <label>Perihal <span class="text-danger">*</span></label>
                    <input type="text" name="perihal" class="form-control @error('perihal') is-invalid @enderror"
                           value="{{ old('perihal', $suratBiasa->perihal) }}" required>
                    @error('perihal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label>Kepada Yth. <span class="text-danger">*</span></label>
                    <input type="text" name="kepada" class="form-control @error('kepada') is-invalid @enderror"
                           value="{{ old('kepada', $suratBiasa->kepada) }}" required>
                    @error('kepada') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- DI & TANGGAL -->
                <div class="col-md-6">
                    <label>Di <span class="text-danger">*</span></label>
                    <input type="text" name="di" class="form-control @error('di') is-invalid @enderror"
                           value="{{ old('di', $suratBiasa->di) }}" required>
                    @error('di') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label>Tanggal Surat <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror"
                           value="{{ old('tanggal', $suratBiasa->tanggal?->format('Y-m-d')) }}" required>
                    @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- KATA PEMBUKA -->
                <div class="col-12">
                    <label>Kata Pembuka <span class="text-danger">*</span></label>
                    <textarea name="kata_pembuka" rows="3" class="form-control @error('kata_pembuka') is-invalid @enderror" required>{{ old('kata_pembuka', $suratBiasa->kata_pembuka) }}</textarea>
                    @error('kata_pembuka') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- ISI SURAT -->
                <div class="col-12">
                    <label>Isi/Maksud Surat <span class="text-danger">*</span></label>
                    <textarea name="isi_surat" rows="6" class="form-control @error('isi_surat') is-invalid @enderror" required>{{ old('isi_surat', $suratBiasa->isi_surat) }}</textarea>
                    @error('isi_surat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- PENUTUP -->
                <div class="col-12">
                    <label>Penutup <span class="text-danger">*</span></label>
                    <textarea name="penutup" rows="3" class="form-control @error('penutup') is-invalid @enderror" required>{{ old('penutup', $suratBiasa->penutup) }}</textarea>
                    @error('penutup') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- NAMA & JABATAN -->
                <div class="col-md-6">
                    <label>Nama Penanda Tangan <span class="text-danger">*</span></label>
                    <input type="text" name="nama_penanda_tangan" class="form-control @error('nama_penanda_tangan') is-invalid @enderror"
                           value="{{ old('nama_penanda_tangan', $suratBiasa->nama_penanda_tangan) }}" required>
                    @error('nama_penanda_tangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label>Jabatan <span class="text-danger">*</span></label>
                    <select name="jabatan_id" class="form-select @error('jabatan_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Jabatan --</option>
                        @foreach($jabatan as $j)
                            <option value="{{ $j->id }}" {{ old('jabatan_id', $suratBiasa->jabatan_id) == $j->id ? 'selected' : '' }}>
                                {{ $j->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('jabatan_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- TEMBUSAN -->
                <div class="col-12">
                    <label>Tembusan</label>
                    <div id="tembusan-container">
                        @foreach($suratBiasa->tembusan ?? ['','',''] as $i => $t)
                            <input type="text" name="tembusan[]" class="form-control mb-2"
                                   placeholder="Yth. {{ $i+1 }}" value="{{ old("tembusan.{$i}", $t) }}">
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="addTembusan()">+ Tambah</button>
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
function addTembusan() {
    const container = document.getElementById('tembusan-container');
    const index = container.children.length + 1;
    const input = document.createElement('input');
    input.type = 'text';
    input.name = 'tembusan[]';
    input.className = 'form-control mb-2';
    input.placeholder = `Yth. ${index}`;
    container.appendChild(input);
}
</script>
@endsection