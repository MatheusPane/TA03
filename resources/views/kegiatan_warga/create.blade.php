@extends('layouts.layout')

@section('title', 'Tambah Kegiatan Warga')

@section('content')
<div class="main-content p-4">
    <div class="content-card" style="border-radius: 15px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <div class="card-header-custom" style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); color: white; padding: 15px;">
            <h4 style="font-weight: 700; margin: 0;">
                Tambah Kegiatan untuk: {{ $warga->nama }}
            </h4>
            <a href="{{ route('kegiatan_warga.index', $warga->id) }}" class="btn btn-light" style="border-radius: 10px;">
                Kembali
            </a>
        </div>

        <div class="p-4">
            <form action="{{ route('kegiatan_warga.store', $warga->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Pilih Kegiatan <span class="text-danger">*</span></label>
                    <select name="ref_kegiatan_id" class="form-select @error('ref_kegiatan_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Kegiatan --</option>
                        @foreach($refKegiatan as $ref)
                            <option value="{{ $ref->id }}">{{ $ref->nama }}</option>
                        @endforeach
                    </select>
                    @error('ref_kegiatan_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Ikut? <span class="text-danger">*</span></label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="ikut" value="1" checked>
                            <label class="form-check-label">Ya</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="ikut" value="0">
                            <label class="form-check-label">Tidak</label>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Keterangan (opsional)</label>
                    <textarea name="keterangan" class="form-control" rows="3" placeholder="Jenis kegiatan yang diikuti..."></textarea>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary" style="border-radius: 10px;">
                        Simpan
                    </button>
                    <a href="{{ route('kegiatan_warga.index', $warga->id) }}" class="btn btn-secondary" style="border-radius: 10px;">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection