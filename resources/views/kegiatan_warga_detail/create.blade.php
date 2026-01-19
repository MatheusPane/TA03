@extends('layouts.layout')

@section('title', 'Tambah Sub Kegiatan')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Tambah Sub Kegiatan</h5>
    </div>

    <div class="card-body">
        <form method="POST"
              action="{{ route('kegiatan-warga-detail.store') }}">
            @csrf

            <div class="mb-3">
                <label>Kegiatan Warga</label>
                <select name="kegiatan_warga_id"
                        class="form-control" required>
                    <option value="">-- Pilih --</option>
                    @foreach($kegiatanWarga as $kw)
                    <option value="{{ $kw->id }}"
                        data-kegiatan="{{ $kw->ref_kegiatan_id }}">
                    {{ $kw->warga->nama }} -
                    {{ $kw->refKegiatan->nama }}
                </option>
                                   
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Sub Kegiatan</label>
                <div id="sub-kegiatan-wrapper">
                    @foreach($jenisKader as $j)
                        <div class="form-check sub-item"
                             data-kegiatan="{{ $j->kegiatan->id }}">
                            <input type="checkbox"
                                   name="ref_jenis_kader_id[]"
                                   value="{{ $j->id }}"
                                   class="form-check-input">
                            <label class="form-check-label">
                                {{ $j->nama }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>            

            <button class="btn btn-primary">Simpan</button>
            <a href="{{ route('kegiatan-warga-detail.index') }}"
               class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectKegiatan = document.querySelector(
            'select[name="kegiatan_warga_id"]'
        );
    
        const subItems = document.querySelectorAll('.sub-item');
    
        selectKegiatan.addEventListener('change', function () {
    
            // ambil kegiatan besar dari option text
            const selectedText = this.options[this.selectedIndex].text;
    
            // ambil ID kegiatan besar dari data attribute
            const kegiatanId = this.options[this.selectedIndex]
                .getAttribute('data-kegiatan');
    
            subItems.forEach(item => {
                const itemKegiatan = item.getAttribute('data-kegiatan');
    
                // reset checkbox
                item.querySelector('input').checked = false;
    
                if(itemKegiatan === kegiatanId){
                    item.style.display = 'block';
                }else{
                    item.style.display = 'none';
                }
            });
        });
    });
    </script>    
@endsection
