@extends('layouts.layout')

@section('title', 'Catatan Keluarga PKK: ' . ($keluarga->anggotaKeluarga->where('statusDalamKeluarga.nama', 'like', '%kepala%')->first()?->warga?->nama ?? 'Keluarga'))

@section('content')
<div class="main-content p-4">
    <div class="content-card" style="border-radius: 18px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.12);">
        
        <div class="card-header-custom d-flex justify-content-between align-items-center p-4" 
        style="background: linear-gradient(135deg, #1e3a8a, #3b82f6); color: white;">
       <div>
           <h4 class="mb-1 fw-bold">Catatan Keluarga PKK</h4>
           <small class="opacity-75">Data Resmi Keluarga - Tahun {{ now()->year }}</small>
       </div>
       <div>
           <a href="{{ route('panduan_keluarga.index') }}" class[enter] class="btn btn-light btn-sm me-2">
               <i class="bi bi-arrow-left"></i> Kembali
           </a>
           
           <a href="{{ route('panduan_keluarga.print_show', $keluarga) }}" 
              target="_blank" 
              class="btn btn-warning btn-sm">
               <i class="bi bi-file-earmark-pdf"></i> Cetak Resmi
           </a>
       </div>
   </div>

        <div class="p-4">
            @php 
                $detail = $keluarga->detail;
                $kepalaAnggota = $keluarga->anggotaKeluarga
                    ->firstWhere(fn($a) => $a->statusDalamKeluarga && str_contains(strtolower($a->statusDalamKeluarga->nama), 'kepala'));
                $kepala = $kepalaAnggota?->warga;
            @endphp

            <!-- INFO UTAMA: 2 KOLOM -->
            <div class="row g-4 mb-5">
                <!-- KOLOM KIRI -->
                <div class="col-lg-6">
                    <div class="bg-white p-4 rounded-3 border shadow-sm h-100">
                        <h6 class="fw-bold text-primary mb-3"><i class="bi bi-house-door"></i> Informasi Keluarga</h6>
                        <div class="row g-3">
                            <div class="col-sm-5"><strong>No KK</strong></div>
                            <div class="col-sm-7">: {{ $keluarga->no_kk ?? '-' }}</div>

                            <div class="col-sm-5"><strong>Dasawisma</strong></div>
                            <div class="col-sm-7">: {{ $keluarga->dasawisma?->nama ?? '-' }}</div>

                            <div class="col-sm-5"><strong>Kepala Rumah Tangga</strong></div>
                            <div class="col-sm-7">
                                : <span class="fw-bold text-primary">
                                    {{ $kepala?->nama ?? 'Belum ditentukan' }}
                                </span>
                                @if($kepala)<span class="badge bg-primary ms-1">KRT</span>@endif
                            </div>

                            <div class="col-sm-5"><strong>Tahun</strong></div>
                            <div class="col-sm-7">: {{ now()->year }}</div>
                        </div>
                    </div>
                </div>

                <!-- KOLOM KANAN -->
                <div class="col-lg-6">
                    <div class="bg-white p-4 rounded-3 border shadow-sm h-100">
                        <h6 class="fw-bold text-success mb-3"><i class="bi bi-shield-check"></i> Kesehatan Lingkungan</h6>
                        <div class="row g-3">
                            <div class="col-sm-6"><strong>Kriteria Rumah</strong></div>
                            <div class="col-sm-6">
                                : <span class="badge bg-{{ $detail?->kriteria_rumah == 'Sehat' ? 'success' : 'warning' }} fs-6">
                                    {{ $detail?->kriteria_rumah ?? 'Belum diisi' }}
                                </span>
                            </div>

                            <div class="col-sm-6"><strong>Jamban Keluarga</strong></div>
                            <div class="col-sm-6">
                                : <span class="badge bg-{{ $detail?->punya_jamban ? 'success' : 'secondary' }}">
                                    {{ $detail?->punya_jamban ? 'Ada (' . ($detail?->jumlah_jamban ?? 0) . ')' : 'Tidak' }}
                                </span>
                            </div>

                            <div class="col-sm-6"><strong>Sumber Air</strong></div>
                            <div class="col-sm-6">: {{ $detail?->sumberAir?->nama ?? '-' }}</div>

                            <div class="col-sm-6"><strong>Tempat Sampah</strong></div>
                            <div class="col-sm-6">
                                : <span class="badge bg-{{ $detail?->punya_tempat_sampah ? 'success' : 'secondary' }}">
                                    {{ $detail?->punya_tempat_sampah ? 'Ada' : 'Tidak' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TABEL ANGGOTA -->
            <h5 class="border-bottom pb-2 mb-4 text-dark">
                <i class="bi bi-people"></i> Anggota Keluarga & Kegiatan PKK
            </h5>

            <div class="table-responsive">
                <table class="table table-hover align-middle" style="font-size: 0.95rem;">
                    <thead class="table-primary">
                        <tr>
                            <th width="180">Nama Lengkap</th>
                            <th width="90">Status</th>
                            <th width="50">JK</th>
                            <th width="130">TTL</th>
                            <th width="60">Umur</th>
                            <th width="90">Agama</th>
                            <th width="100">Pendidikan</th>
                            <th width="100">Pekerjaan</th>
                            <th width="100">Kebutuhan Khusus</th>
                            <th width="180">Kegiatan PKK</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($keluarga->anggotaKeluarga as $anggota)
                            @php
                                $w = $anggota->warga;
                                $umur = $w?->tanggal_lahir ? \Carbon\Carbon::parse($w->tanggal_lahir)->age : '-';
                                $kegiatanList = $w?->kegiatanWarga->where('ikut', true)->pluck('refKegiatan.nama')->toArray();
                                $isKepala = $anggota->statusDalamKeluarga && str_contains(strtolower($anggota->statusDalamKeluarga->nama), 'kepala');
                            @endphp
                            <tr {{ $isKepala ? 'class="table-info fw-bold"' : '' }}>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($isKepala)
                                            <i class="bi bi-star-fill text-warning me-1"></i>
                                        @endif
                                        {{ $w?->nama ?? '-' }}
                                        @if($isKepala)
                                            <span class="badge bg-primary ms-2">KRT</span>
                                        @endif
                                    </div>
                                </td>
                                <td>{{ $w?->statusPerkawinan?->nama ?? '-' }}</td>
                                <td class="text-center fw-bold">{{ $w?->jenis_kelamin == 'L' ? 'L' : 'P' }}</td>
                                <td>
                                    <div><small>{{ $w?->tempat_lahir ?? '-' }}</small></div>
                                    <small class="text-muted">{{ $w?->tanggal_lahir ? \Carbon\Carbon::parse($w->tanggal_lahir)->format('d/m/Y') : '-' }}</small>
                                </td>
                                <td class="text-center">{{ $umur }}</td>
                                <td><small>{{ $w?->agama?->nama ?? '-' }}</small></td>
                                <td><small>{{ $w?->pendidikan?->nama ?? '-' }}</small></td>
                                <td><small>{{ $w?->pekerjaan?->nama ?? '-' }}</small></td>
                                <td><small>{{ $w?->kebutuhanKhusus->nama?? '-'}}</small></td>
                                <td>
                                    @if(!empty($kegiatanList))
                                        <div class="d-flex flex-wrap gap-1" style="max-height: 60px; overflow-y: auto;">
                                            @foreach($kegiatanList as $keg)
                                                <span class="badge bg-success text-white fs-6">{{ $keg }}</span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-muted small">Tidak ada</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-5">
                                    <i class="bi bi-people fs-1"></i><br>
                                    <strong>Belum ada anggota keluarga</strong>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- FOOTER -->
            <div class="mt-5 pt-4 border-top text-end text-muted small">
                <em>Dicetak pada: {{ now()->format('d F Y, H:i') }} WIB • Sistem PKK Digital v1.0</em>
            </div>
        </div>
    </div>
</div>
@endsection