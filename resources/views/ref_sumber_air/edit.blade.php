@extends('layouts.layout')

@section('title', 'Edit Sumber Air')

@section('content')
<div class="main-content p-4">
    <div class="content-card" style="border-radius: 15px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <div class="card-header-custom" style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); color: white; padding: 15px;">
            <h4 style="font-weight: 700; margin: 0;">
                Edit Sumber Air
            </h4>
            <a href="{{ route('ref_sumber_air.index') }}" class="btn btn-light" style="border-radius: 10px;">
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

            <form action="{{ route('ref_sumber_air.update', $item->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="mb-4">
                    <label class="form-label">Nama Sumber Air <span class="text-danger">*</span></label>
                    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" 
                           value="{{ old('nama', $item->nama) }}" required>
                    @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary" style="border-radius: 10px;">
                        Update
                    </button>
                    <a href="{{ route('ref_sumber_air.index') }}" class="btn btn-secondary" style="border-radius: 10px;">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection