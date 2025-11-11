@extends('layouts.layout')

@section('title', 'Kegiatan Warga: ' . $warga->nama)

@section('content')
<div class="main-content p-4">
    <div class="content-card" style="border-radius: 15px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <div class="card-header-custom" style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); color: white; padding: 15px;">
            <h4 style="font-weight: 700; margin: 0;">
                Kegiatan Warga: {{ $warga->nama }}
            </h4>
            <div>
                <a href="{{ route('kegiatan_warga.dashboard') }}" class="btn btn-secondary btn-sm">
                    Dashboard
                </a>
                <a href="{{ route('data_warga.show', $warga->id) }}" class="btn btn-light btn-sm">
                    Profil Warga
                </a>
            </div>
        </div>

        <div class="p-4">
            <form id="kegiatanForm">
                @csrf
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="50">No</th>
                                <th>Aktivitas</th>
                                <th width="120">Ikut?</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($refKegiatan as $ref)
                            @php
                                $keg = $kegiatanWarga->get($ref->id);
                                $isIkut = $keg?->ikut ?? false;
                                $keterangan = $keg?->keterangan ?? '';
                            @endphp
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td><strong>{{ $ref->nama }}</strong></td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <input type="radio" class="btn-check" name="ikut_{{ $ref->id }}" 
                                               id="ya_{{ $ref->id }}" value="1" {{ $isIkut ? 'checked' : '' }}
                                               onchange="saveKegiatan({{ $warga->id }}, {{ $ref->id }}, this.value, document.getElementById('ket_{{ $ref->id }}').value)">
                                        <label class="btn btn-sm btn-outline-success" for="ya_{{ $ref->id }}">Ya</label>

                                        <input type="radio" class="btn-check" name="ikut_{{ $ref->id }}" 
                                               id="tidak_{{ $ref->id }}" value="0" {{ !$isIkut ? 'checked' : '' }}
                                               onchange="saveKegiatan({{ $warga->id }}, {{ $ref->id }}, this.value, document.getElementById('ket_{{ $ref->id }}').value)">
                                        <label class="btn btn-sm btn-outline-secondary" for="tidak_{{ $ref->id }}">Tidak</label>
                                    </div>
                                </td>
                                <td>
                                    <input type="text" id="ket_{{ $ref->id }}" class="form-control form-control-sm" 
                                           value="{{ $keterangan }}" placeholder="Jenis kegiatan..."
                                           onblur="saveKegiatan({{ $warga->id }}, {{ $ref->id }}, 
                                               document.querySelector('input[name=\'ikut_{{ $ref->id }}\']:checked')?.value ?? 0, this.value)">
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">
                                    Belum ada referensi kegiatan. 
                                    <a href="{{ route('ref_kegiatan_warga.create') }}">Tambah dulu</a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function saveKegiatan(warga_id, ref_id, ikut, keterangan) {
    fetch(`/warga/${warga_id}/kegiatan`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            ref_kegiatan_id: ref_id,
            ikut: ikut,
            keterangan: keterangan
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log('Saved:', data);
        // Optional: toast success
    })
    .catch(err => console.error(err));
}
</script>
@endsection