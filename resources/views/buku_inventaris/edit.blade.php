@extends('layouts.layout')

@section('title', 'Edit Barang Inventaris')

@section('content')
<div class="main-content p-4">
    <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
        <div class="card-header bg-primary bg-gradient text-white">
            <h4 class="mb-0 fw-bold">Edit Barang: {{ $barang->nama_barang }}</h4>
        </div>

        <div class="card-body p-4">
            <form method="POST" action="{{ route('buku-inventaris.update', $barang->id) }}">
                @csrf @method('PATCH')

                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label fw-medium">Nama Barang</label>
                        <input type="text" name="nama_barang" class="form-control" value="{{ old('nama_barang', $barang->nama_barang) }}" required>
                        @error('nama_barang') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-medium">Asal Barang</label>
                        <input type="text" name="asal_barang" class="form-control" value="{{ old('asal_barang', $barang->asal_barang) }}" required>
                        @error('asal_barang') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-medium">Tanggal Pembelian</label>
                        <input type="date" name="tanggal_pembelian" class="form-control" value="{{ old('tanggal_pembelian', $barang->tanggal_pembelian ? $barang->tanggal_pembelian->format('Y-m-d') : '') }}">
                        @error('tanggal_pembelian') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-medium">Jumlah</label>
                        <input type="number" name="jumlah" class="form-control" min="1" value="{{ old('jumlah', $barang->jumlah) }}" required>
                        @error('jumlah') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-medium">Tempat Penyimpanan</label>
                        <select name="tempat_penyimpanan" class="form-select" required>
                            <option value="Kantor Desa" {{ old('tempat_penyimpanan', $barang->tempat_penyimpanan) == 'Kantor Desa' ? 'selected' : '' }}>Kantor Desa</option>
                            <option value="Gudang Desa" {{ old('tempat_penyimpanan', $barang->tempat_penyimpanan) == 'Gudang Desa' ? 'selected' : '' }}>Gudang Desa</option>
                            <option value="Lainnya" {{ old('tempat_penyimpanan', $barang->tempat_penyimpanan) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('tempat_penyimpanan') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-medium">Kondisi Barang</label>
                        <select name="kondisi_barang" class="form-select" required>
                            <option value="Baik" {{ old('kondisi_barang', $barang->kondisi_barang) == 'Baik' ? 'selected' : '' }}>Baik</option>
                            <option value="Cukup Baik" {{ old('kondisi_barang', $barang->kondisi_barang) == 'Cukup Baik' ? 'selected' : '' }}>Cukup Baik</option>
                            <option value="Rusak Ringan" {{ old('kondisi_barang', $barang->kondisi_barang) == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                            <option value="Rusak Berat" {{ old('kondisi_barang', $barang->kondisi_barang) == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                            <option value="Hilang" {{ old('kondisi_barang', $barang->kondisi_barang) == 'Hilang' ? 'selected' : '' }}>Hilang</option>
                        </select>
                        @error('kondisi_barang') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-medium">Keterangan (opsional)</label>
                        <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan', $barang->keterangan) }}</textarea>
                        @error('keterangan') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="mt-5 text-end">
                    <a href="{{ route('buku-inventaris.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary px-5">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection