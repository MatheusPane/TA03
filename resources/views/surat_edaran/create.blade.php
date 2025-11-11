{{-- resources/views/surat_edaran/create.blade.php --}}
@extends('layouts.layout')

@section('title', 'Buat Surat Edaran')

@section('content')
<div class="main-content p-4">
    <div class="content-card p-4 rounded-3 shadow-sm">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0 fw-bold text-primary">Buat Surat Edaran</h4>
            <a href="{{ route('surat-edaran.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
        </div>

        <form action="{{ route('surat-edaran.store') }}" method="POST">
            @csrf
            <div class="row g-3">

                <!-- NOMOR & TENTANG -->
                <div class="col-md-6">
                    <label>Nomor Surat <span class="text-danger">*</span></label>
                    <input type="text" name="nomor" class="form-control @error('nomor') is-invalid @enderror"
                           value="{{ old('nomor', $nomorOtomatis) }}" required>
                    @error('nomor') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label>Tentang <span class="text-danger">*</span></label>
                    <input type="text" name="tentang" class="form-control @error('tentang') is-invalid @enderror"
                           value="{{ old('tentang') }}" required>
                    @error('tentang') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- POIN 1 -->
                <div class="col-12">
                    <label>Poin 1 <span class="text-danger">*</span></label>
                    <textarea name="poin_1" rows="4" class="form-control @error('poin_1') is-invalid @enderror" required>{{ old('poin_1') }}</textarea>
                    @error('poin_1') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- POIN 2 -->
                <div class="col-12">
                    <label>Poin 2 <span class="text-danger">*</span></label>
                    <textarea name="poin_2" rows="4" class="form-control @error('poin_2') is-invalid @enderror" required>{{ old('poin_2') }}</textarea>
                    @error('poin_2') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- POIN 3 -->
                <div class="col-12">
                    <label>Poin 3 <span class="text-danger">*</span></label>
                    <textarea name="poin_3" rows="4" class="form-control @error('poin_3') is-invalid @enderror" required>{{ old('poin_3') }}</textarea>
                    @error('poin_3') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- POIN 4 -->
                <div class="col-12">
                    <label>Poin 4 (Demikian...) <span class="text-danger">*</span></label>
                    <textarea name="poin_4" rows="4" class="form-control @error('poin_4') is-invalid @enderror" required>{{ old('poin_4') }}</textarea>
                    @error('poin_4') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- DIKELUARKAN DI & TANGGAL -->
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
                <div class="col-md-6">
                    <label>Tanggal <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror"
                           value="{{ old('tanggal', now()->format('Y-m-d')) }}" required>
                    @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- NAMA & JABATAN -->
                <div class="col-md-6">
                    <label>Nama Penanda Tangan <span class="text-danger">*</span></label>
                    <input type="text" name="nama_penanda_tangan" class="form-control @error('nama_penanda_tangan') is-invalid @enderror"
                           value="{{ old('nama_penanda_tangan') }}" required>
                    @error('nama_penanda_tangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label>Jabatan <span class="text-danger">*</span></label>
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

                <!-- TOMBOL -->
                <div class="col-12 text-end mt-4">
                    <button type="submit" class="btn btn-primary px-4">Simpan & Cetak</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection