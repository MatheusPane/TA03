@extends('layouts.layout')

@section('title', 'Tambah Makanan Pokok')

@section('content')
<div class="main-content p-4">
    <div class="content-card" style="border-radius: 15px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <div class="card-header-custom" style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); color: white; padding: 15px;">
            <h4 style="font-weight: 700; margin: 0;">
                Tambah Makanan Pokok
            </h4>
            <a href="{{ route('ref_makanan_pokok.index') }}" class="btn btn-light" style="border-radius: 10px;">
                Kembali
            </a>
        </div>

        <div class="p-4">
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 10px;">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('ref_makanan_pokok.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="form-label">Nama Makanan Pokok <span class="text-danger">*</span></label>
                    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" 
                           value="{{ old('nama') }}" placeholder="Contoh: Jagung, Singkong, Ubi" required>
                    @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary" style="border-radius: 10px;">
                        Simpan
                    </button>
                    <a href="{{ route('ref_makanan_pokok.index') }}" class="btn btn-secondary" style="border-radius: 10px;">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection