@extends('layouts.layout')

@section('title', 'Detail Keluarga: ' . $keluarga->no_kk)

@section('content')
<div class="main-content p-4">
    <div class="content-card" style="border-radius: 15px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
        <div class="card-header-custom" style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); color: white; padding: 15px;">
            <h4 style="font-weight: 700; margin: 0;">
                Detail Keluarga
            </h4>
            <a href="{{ route('data_keluarga.index') }}" class="btn btn-light" style="border-radius: 10px;">
                Kembali
            </a>
        </div>

        <div class="p-4">
            <div class="row g-4">
                <!-- Identitas Keluarga -->
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Identitas Keluarga</h5>
                            <table class="table table-borderless">
                                <tr><td><strong>No KK</strong></td><td>: <strong>{{ $keluarga->no_kk }}</strong></td></tr>
                                <tr><td><strong>Dusun</strong></td><td>: {{ $keluarga->dusun->nama ?? '-' }}</td></tr>
                                <tr><td><strong>Dasawisma</strong></td><td>: {{ $keluarga->dasawisma->nama ?? '-' }}</td></tr>
                                <tr><td><strong>Status</strong></td><td>: 
                                    <span class="badge bg-{{ $keluarga->active ? 'success' : 'danger' }}">
                                        {{ $keluarga->active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td></tr>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Statistik Anggota -->
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                        <div class="card-body">
                            <h5 class="card-title text-info">Statistik Anggota</h5>
                            <div class="row text-center">
                                <div class="col-4">
                                    <div class="p-3 bg-light rounded">
                                        <h3 class="mb-0 text-primary">{{ $keluarga->detail->jumlah_anggota ?? 0 }}</h3>
                                        <small>Total</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="p-3 bg-light rounded">
                                        <h3 class="mb-0 text-info">{{ $keluarga->detail->laki_laki ?? 0 }}</h3>
                                        <small>Laki-laki</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="p-3 bg-light rounded">
                                        <h3 class="mb-0 text-pink">{{ $keluarga->detail->perempuan ?? 0 }}</h3>
                                        <small>Perempuan</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Daftar Anggota -->
                <div class="col-md-12">
                    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                        <div class="card-body">
                            <h5 class="card-title text-success">Daftar Anggota Keluarga</h5>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No</th>
                                            <th>No Reg</th>
                                            <th>Nama</th>
                                            <th>Status</th>
                                            <th>JK</th>
                                            <th>Umur</th>
                                            <th>Perkawinan</th>
                                            <th>Pendidikan</th>
                                            <th>Pekerjaan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($keluarga->anggotaKeluarga as $a)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $a->warga->no_registrasi ?? '-' }}</td>
                                            <td><strong>{{ $a->warga->nama }}</strong></td>
                                            <td>{{ $a->statusDalamKeluarga->nama ?? '-' }}</td>
                                            <td>
                                                <span class="badge bg-{{ $a->warga->jenis_kelamin == 'L' ? 'info' : 'pink' }}">
                                                    {{ $a->warga->jenis_kelamin }}
                                                </span>
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($a->warga->tanggal_lahir)->age }} thn</td>
                                            <td>{{ $a->warga->statusPerkawinan->nama ?? '-' }}</td>
                                            <td>{{ $a->warga->pendidikan->nama ?? '-' }}</td>
                                            <td>{{ $a->warga->pekerjaan->nama ?? '-' }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="9" class="text-center text-muted">Belum ada anggota keluarga</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            @canany(['Admin', 'Kader'])
                            <a href="{{ route('data_keluarga_anggota.create', $keluarga->id) }}" class="btn btn-success btn-sm">
                                Tambah Anggota
                            </a>
                            @endcanany
                        </div>
                    </div>
                </div>

                <!-- Fasilitas & Kriteria Rumah -->
                <div class="col-md-12">
                    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                        <div class="card-body">
                            <h5 class="card-title text-warning">Fasilitas & Kriteria Rumah</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-sm table-borderless">
                                        <tr><td><strong>Makanan Pokok</strong></td><td>: {{ $keluarga->detail->makanan_pokok ?? '-' }}
                                            @if($keluarga->detail->makanan_pokok == 'Non Beras')
                                                <small class="text-muted">({{ optional($keluarga->detail->makananPokokLain)->nama ?? '-' }})</small>
                                            @endif
                                        </td></tr>
                                        <tr><td><strong>Jamban</strong></td><td>: {{ $keluarga->detail->punya_jamban ? 'Ya (' . $keluarga->detail->jumlah_jamban . ')' : 'Tidak' }}</td></tr>
                                        <tr><td><strong>Sumber Air</strong></td><td>: {{ optional($keluarga->detail->sumberAir)->nama ?? '-' }}</td></tr>
                                        <tr><td><strong>Tempat Sampah</strong></td><td>: {{ $keluarga->detail->punya_tempat_sampah ? 'Ya' : 'Tidak' }}</td></tr>
                                        <tr><td><strong>Saluran Limbah</strong></td><td>: {{ $keluarga->detail->punya_saluran_limbah ? 'Ya' : 'Tidak' }}</td></tr>
                                        <tr><td><strong>Stiker P4K</strong></td><td>: {{ $keluarga->detail->stiker_p4k ? 'Ya' : 'Tidak' }}</td></tr>
                                        <tr><td><strong>Kriteria Rumah</strong></td><td>: 
                                            <span class="badge bg-{{ $keluarga->detail->kriteria_rumah == 'Sehat' ? 'success' : 'warning' }}">
                                                {{ $keluarga->detail->kriteria_rumah ?? '-' }}
                                            </span>
                                        </td></tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-sm table-borderless">
                                        <tr><td><strong>UP2K</strong></td><td>: {{ $keluarga->detail->up2k ? 'Ya' : 'Tidak' }}
                                            @if($keluarga->detail->up2k)
                                                <small class="text-muted">({{ optional($keluarga->detail->jenisUsaha)->nama ?? '-' }})</small>
                                            @endif
                                        </td></tr>
                                        <tr><td><strong>Kesehatan Lingkungan</strong></td><td>: {{ $keluarga->detail->kesehatan_lingkungan ? 'Ya' : 'Tidak' }}</td></tr>
                                    </table>
                                </div>
                            </div>
                            @canany(['Admin', 'Kader'])
                            <a href="{{ route('data_keluarga.detail.edit', $keluarga->id) }}" class="btn btn-warning btn-sm">
                                Edit Detail Fasilitas
                            </a>
                            @endcanany
                        </div>
                    </div>
                </div>

                <!-- Audit Trail -->
                <div class="col-md-12">
                    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                        <div class="card-body">
                            <h5 class="card-title text-secondary">Riwayat</h5>
                            <small class="text-muted">
                                Dibuat oleh: <strong>{{ $keluarga->createdBy->name ?? '-' }}</strong>
                                pada {{ $keluarga->created_at ? \Carbon\Carbon::parse($keluarga->created_at)->format('d/m/Y H:i') : '-' }}
                                <br>
                                Diperbarui oleh: <strong>{{ $keluarga->updatedBy->name ?? '-' }}</strong>
                                pada {{ $keluarga->updated_at ? \Carbon\Carbon::parse($keluarga->updated_at)->format('d/m/Y H:i') : '-' }}
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Aksi -->
                <div class="col-md-12 text-end mt-3">
                    @canany(['Admin', 'Kader'])
                    <a href="{{ route('data_keluarga.edit', $keluarga->id) }}" class="btn btn-warning" style="border-radius: 10px;">
                        Edit KK
                    </a>
                    @endcanany
                    <a href="{{ route('data_keluarga.index') }}" class="btn btn-secondary" style="border-radius: 10px;">
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection