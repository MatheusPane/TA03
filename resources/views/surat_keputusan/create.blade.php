{{-- resources/views/surat_keputusan/create.blade.php --}}
@extends('layouts.layout')

@section('title', 'Buat Surat Keputusan PKK')

@section('content')
<div class="main-content p-4">
    <div class="content-card p-4 rounded-3 shadow-sm">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0 fw-bold text-primary">
                <i class="bi bi-file-earmark-plus"></i> Buat Surat Keputusan Baru
            </h4>
            <a href="{{ route('surat_keputusan.index') }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <form action="{{ route('surat_keputusan.store') }}" method="POST">
            @csrf
            <div class="row g-4">

                <!-- NOMOR & TENTANG -->
                <div class="col-md-6">
                    <label class="form-label fw-bold">Nomor Surat <span class="text-danger">*</span></label>
                    <input type="text" name="nomor" class="form-control @error('nomor') is-invalid @enderror"
                           value="{{ old('nomor', $nomorOtomatis) }}" required>
                    @error('nomor') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Tentang <span class="text-danger">*</span></label>
                    <input type="text" name="tentang" class="form-control @error('tentang') is-invalid @enderror"
                           value="{{ old('tentang') }}" required>
                    @error('tentang') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- MENIMBANG -->
                <div class="col-12">
                    <label class="form-label fw-bold">Menimbang</label>
                    <textarea name="menimbang" rows="3" class="form-control @error('menimbang') is-invalid @enderror"
                              placeholder="Masukkan isi menimbang...">{{ old('menimbang') }}</textarea>
                    @error('menimbang') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- MENGINGAT -->
                <div class="col-12">
                    <label class="form-label fw-bold">Mengingat</label>
                    <div id="mengingat-container">
                        @foreach(['', '', ''] as $i)
                            <input type="text" name="mengingat[]" class="form-control mb-2"
                                   placeholder="Poin {{ $loop->iteration }}" value="{{ old("mengingat.{$i}") }}">
                        @endforeach
                    </div>
                </div>

                <!-- MEMPERHATIKAN -->
                <div class="col-12">
                    <label class="form-label fw-bold">Memperhatikan</label>
                    <textarea name="memperhatikan" rows="2" class="form-control"
                              placeholder="Masukkan isi memperhatikan...">{{ old('memperhatikan') }}</textarea>
                </div>

                <!-- MENETAPKAN -->
                <div class="col-12">
                    <label class="form-label fw-bold">Menetapkan <span class="text-danger">*</span></label>
                    <textarea name="menetapkan[PERTAMA]" rows="3" class="form-control mb-2 @error('menetapkan.PERTAMA') is-invalid @enderror"
                              placeholder="PERTAMA (wajib diisi)" required>{{ old('menetapkan.PERTAMA') }}</textarea>
                    @error('menetapkan.PERTAMA') <div class="invalid-feedback">{{ $message }}</div> @enderror

                    <textarea name="menetapkan[KEDUA]" rows="2" class="form-control mb-2"
                              placeholder="KEDUA (opsional)">{{ old('menetapkan.KEDUA') }}</textarea>
                    <textarea name="menetapkan[KETIGA]" rows="2" class="form-control mb-2"
                              placeholder="KETIGA (opsional)">{{ old('menetapkan.KETIGA') }}</textarea>
                </div>

                <!-- DITETAPKAN -->
                <div class="col-md-4">
                    <label class="form-label fw-bold">Ditetapkan di <span class="text-danger">*</span></label>
                    <input type="text" name="ditetapkan_di" class="form-control" value="{{ old('ditetapkan_di') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Tanggal <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', now()->format('Y-m-d')) }}" required>
                </div>

                <!-- PENANDA TANGAN -->
                <div class="col-md-6">
                    <label class="form-label fw-bold">Nama Penanda Tangan <span class="text-danger">*</span></label>
                    <input type="text" name="nama_penanda_tangan" class="form-control @error('nama_penanda_tangan') is-invalid @enderror"
                           value="{{ old('nama_penanda_tangan') }}" required>
                    @error('nama_penanda_tangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Jabatan Penanda Tangan <span class="text-danger">*</span></label>
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
                    <label class="form-label fw-bold">Tembusan</label>
                    <div id="tembusan-container">
                        @foreach(['', '', ''] as $i)
                            <input type="text" name="tembusan[]" class="form-control mb-2"
                                   placeholder="Yth. {{ $loop->iteration }}" value="{{ old("tembusan.{$i}") }}">
                        @endforeach
                    </div>
                </div>

                <!-- TOMBOL -->
                <div class="col-12 text-end mt-4">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-save"></i> Simpan & Cetak
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection