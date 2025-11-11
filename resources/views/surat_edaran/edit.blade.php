{{-- resources/views/surat_edaran/edit.blade.php --}}
@extends('layouts.layout')

@section('title', 'Edit Surat Edaran')

@section('content')
<div class="main-content p-4">
    <div class="content-card p-4 rounded-3 shadow-sm">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0 fw-bold text-primary">Edit Surat Edaran</h4>
            <a href="{{ route('surat-edaran.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
        </div>

        <form action="{{ route('surat-edaran.update', $suratEdaran) }}" method="POST">
            @csrf @method('PUT')
            <div class="row g-3">

                <!-- SAMA SEPERTI CREATE, TAPI GUNAKAN old() + $suratEdaran -->
                <div class="col-md-6">
                    <label>Nomor Surat <span class="text-danger">*</span></label>
                    <input type="text" name="nomor" class="form-control @error('nomor') is-invalid @enderror"
                           value="{{ old('nomor', $suratEdaran->nomor) }}" required>
                    @error('nomor') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label>Tentang <span class="text-danger">*</span></label>
                    <input type="text" name="tentang" class="form-control @error('tentang') is-invalid @enderror"
                           value="{{ old('tentang', $suratEdaran->tentang) }}" required>
                    @error('tentang') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12">
                    <label>Poin 1 <span class="text-danger">*</span></label>
                    <textarea name="poin_1" rows="4" class="form-control @error('poin_1') is-invalid @enderror" required>{{ old('poin_1', $suratEdaran->poin_1) }}</textarea>
                    @error('poin_1') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12">
                    <label>Poin 2 <span class="text-danger">*</span></label>
                    <textarea name="poin_2" rows="4" class="form-control @error('poin_2') is-invalid @enderror" required>{{ old('poin_2', $suratEdaran->poin_2) }}</textarea>
                    @error('poin_2') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12">
                    <label>Poin 3 <span class="text-danger">*</span></label>
                    <textarea name="poin_3" rows="4" class="form-control @error('poin_3') is-invalid @enderror" required>{{ old('poin_3', $suratEdaran->poin_3) }}</textarea>
                    @error('poin_3') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12">
                    <label>Poin 4 (Demikian...) <span class="text-danger">*</span></label>
                    <textarea name="poin_4" rows="4" class="form-control @error('poin_4') is-invalid @enderror" required>{{ old('poin_4', $suratEdaran->poin_4) }}</textarea>
                    @error('poin_4') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label>Dikeluarkan di (Dusun) <span class="text-danger">*</span></label>
                    <select name="dikeluarkan_di" class="form-select @error('dikeluarkan_di') is-invalid @enderror" required>
                        <option value="">-- Pilih Dusun --</option>
                        @foreach($dusun as $d)
                            <option value="{{ $d->id }}" {{ old('dikeluarkan_di', $suratEdaran->dikeluarkan_di) == $d->id ? 'selected' : '' }}>
                                {{ $d->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('dikeluarkan_di') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label>Tanggal <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror"
                           value="{{ old('tanggal', $suratEdaran->tanggal?->format('Y-m-d')) }}" required>
                    @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label>Nama Penanda Tangan <span class="text-danger">*</span></label>
                    <input type="text" name="nama_penanda_tangan" class="form-control @error('nama_penanda_tangan') is-invalid @enderror"
                           value="{{ old('nama_penanda_tangan', $suratEdaran->nama_penanda_tangan) }}" required>
                    @error('nama_penanda_tangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label>Jabatan <span class="text-danger">*</span></label>
                    <select name="jabatan_id" class="form-select @error('jabatan_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Jabatan --</option>
                        @foreach($jabatan as $j)
                            <option value="{{ $j->id }}" {{ old('jabatan_id', $suratEdaran->jabatan_id) == $j->id ? 'selected' : '' }}>
                                {{ $j->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('jabatan_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12 text-end mt-4">
                    <button type="submit" class="btn btn-warning px-4">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection