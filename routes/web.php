<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\TahunPemerintahanKonfigurasiController;
use App\Http\Controllers\DusunController;
use App\Http\Controllers\DesaKonfigurasiController;
use App\Http\Controllers\RefStatusPerkawinanController;
use App\Http\Controllers\RefAgamaController;
use App\Http\Controllers\RefPendidikanController;
use App\Http\Controllers\RefPekerjaanController;
use App\Http\Controllers\DataWargaController;
use App\Http\Controllers\DataKeluargaController;
use App\Http\Controllers\DataKeluargaDetailController;
use App\Http\Controllers\RefStatusDalamKeluargaController;
use App\Http\Controllers\DataKeluargaAnggotaController;
use App\Http\Controllers\DasawismaController;
use App\Http\Controllers\DasawismaAnggotaController;
use App\Http\Controllers\RefJabatanController;
use App\Http\Controllers\RefJenisAkseptorKbController;
use App\Http\Controllers\RefJenisKelompokBelajarController;
use App\Http\Controllers\RefJenisKoperasiController;
use App\Http\Controllers\RefMakananPokokController;
use App\Http\Controllers\RefSumberAirController;
use App\Http\Controllers\RefJenisUsahaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RefKegiatanWargaController;
use App\Http\Controllers\KegiatanWargaController;
use App\Http\Controllers\PanduanKeluargaController;
use App\Http\Controllers\RefKebutuhanKhususController;
use App\Http\Controllers\SuratKeputusanController;
use App\Http\Controllers\SuratBiasaController;
use App\Http\Controllers\SuratEdaranController;
use App\Http\Controllers\SuratKuasaController;
use App\Http\Controllers\SuratTugasController;

// PUBLIC
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// DASHBOARD (auth)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// GUEST ROUTES
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
});

// AUTH ROUTES
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // === REFERENSI & MASTER DATA (Admin Only) ===
    Route::middleware('is_admin')->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('roles', RoleController::class);
        Route::resource('tahun', TahunPemerintahanKonfigurasiController::class);
        Route::resource('dusun', DusunController::class);
        Route::resource('desa-konfigurasi', DesaKonfigurasiController::class);
        Route::resource('ref_status_perkawinan', RefStatusPerkawinanController::class);
        Route::resource('ref_agama', RefAgamaController::class);
        Route::resource('ref_pendidikan', RefPendidikanController::class);
        Route::resource('ref_pekerjaan', RefPekerjaanController::class);
        Route::resource('ref_jabatan', RefJabatanController::class);
        Route::resource('ref_jenis_akseptor_kb', RefJenisAkseptorKbController::class);
        Route::resource('ref_jenis_kelompok_belajar', RefJenisKelompokBelajarController::class);
        Route::resource('ref_jenis_koperasi', RefJenisKoperasiController::class);

        // REFERENSI TAMBAHAN (Detail Keluarga & Kegiatan)
        Route::resource('ref_makanan_pokok', RefMakananPokokController::class);
        Route::resource('ref_sumber_air', RefSumberAirController::class);
        Route::resource('ref_jenis_usaha', RefJenisUsahaController::class);
        Route::resource('ref_kegiatan_warga', RefKegiatanWargaController::class);
        Route::resource('ref_kebutuhan_khusus', RefKebutuhanKhususController::class);
    });

    // === DATA UTAMA (Semua User Login) ===
    Route::resource('data_warga', DataWargaController::class);
    Route::get('panduan_keluarga/{keluarga}/print', [PanduanKeluargaController::class, 'printShow'])->name('panduan_keluarga.print_show'); 
    Route::get('data-warga/{warga}/print', [DataWargaController::class, 'print'])
    ->name('data_warga.print');
    Route::get('data-warga/{warga}/cetak', [DataWargaController::class, 'cetak'])
     ->name('data_warga.cetak');
    Route::resource('data_keluarga', DataKeluargaController::class);
    Route::get('data-keluarga/{keluarga}/print-dasawisma', [DataKeluargaController::class, 'printDasawisma'])
    ->name('data_keluarga.print_dasawisma');
    Route::resource('ref_status_dalam_keluarga', RefStatusDalamKeluargaController::class);
    Route::resource('surat-biasa', SuratBiasaController::class);
    Route::get('surat-biasa/{suratBiasa}/cetak', [SuratBiasaController::class, 'cetak'])
     ->name('surat-biasa.cetak');
     Route::resource('surat-edaran', SuratEdaranController::class);
     Route::get('surat-edaran/{suratEdaran}/cetak', [SuratEdaranController::class, 'cetak'])
          ->name('surat-edaran.cetak');
    Route::resource('surat-kuasa', SuratKuasaController::class);
     Route::get('surat-kuasa/{suratKuasa}/cetak', [SuratKuasaController::class, 'cetak'])
          ->name('surat-kuasa.cetak');
    Route::resource('surat-tugas', SuratTugasController::class);
     Route::get('surat-tugas/{suratTuga}/cetak', [SuratTugasController::class, 'cetak'])
          ->name('surat-tugas.cetak');


    // === DETAIL KELUARGA (Fasilitas) ===
    Route::prefix('data-keluarga/{keluarga_id}/detail')->name('data_keluarga.detail.')->group(function () {
        Route::get('edit', [DataKeluargaDetailController::class, 'edit'])->name('edit');
        Route::put('update', [DataKeluargaDetailController::class, 'update'])->name('update');
    });

    // === SHOW KELUARGA ===
    Route::get('data-keluarga/{id}', [DataKeluargaController::class, 'show'])->name('data_keluarga.show');

    // === ANGGOTA KELUARGA ===
    Route::get('/data-keluarga-anggota/{keluarga_id}', [DataKeluargaAnggotaController::class, 'index'])
        ->name('data_keluarga_anggota.index');

    Route::get('/data-keluarga-anggota/create/{keluarga_id}', [DataKeluargaAnggotaController::class, 'create'])
        ->name('data_keluarga_anggota.create');

    Route::resource('data_keluarga_anggota', DataKeluargaAnggotaController::class)
        ->except(['index', 'create'])
        ->parameters(['data_keluarga_anggota' => 'anggota']);

    // === DASAWISMA ===
    Route::resource('dasawisma', DasawismaController::class);

    // === ANGGOTA DASAWISMA ===
    Route::prefix('dasawisma/{dasawisma_id}/anggota')->name('dasawisma_anggota.')->group(function () {
        Route::get('/', [DasawismaAnggotaController::class, 'index'])->name('index');
        Route::get('/create', [DasawismaAnggotaController::class, 'create'])->name('create');
        Route::post('/', [DasawismaAnggotaController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [DasawismaAnggotaController::class, 'edit'])->name('edit');
        Route::patch('/{id}', [DasawismaAnggotaController::class, 'update'])->name('update');
        Route::delete('/{id}', [DasawismaAnggotaController::class, 'destroy'])->name('destroy');
    });
        // === KEGIATAN WARGA DASHBOARD ===
    Route::get('/kegiatan-warga', [KegiatanWargaController::class, 'dashboard'])
        ->name('kegiatan_warga.dashboard');
        // === Panduan keluarga ===        
    Route::get('/panduan-keluarga', [PanduanKeluargaController::class, 'index'])
        ->name('panduan_keluarga.index');
    Route::get('/panduan-keluarga/{id}', [PanduanKeluargaController::class, 'show'])
        ->name('panduan_keluarga.show');   
    Route::get('panduan_keluarga/{keluarga}/print', [PanduanKeluargaController::class, 'printShow'])->name('panduan_keluarga.print_show'); 
    // === KEGIATAN WARGA (Admin & Kader) ===
     Route::prefix('warga/{warga_id}/kegiatan')->name('kegiatan_warga.')->group(function () {
            Route::get('/', [KegiatanWargaController::class, 'index'])->name('index');
            Route::get('/create', [KegiatanWargaController::class, 'create'])->name('create');
            Route::post('/', [KegiatanWargaController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [KegiatanWargaController::class, 'edit'])->name('edit');
            Route::put('/{id}', [KegiatanWargaController::class, 'update'])->name('update');
            Route::delete('/{id}', [KegiatanWargaController::class, 'destroy'])->name('destroy');
        });

        // routes/web.php

Route::middleware(['auth'])
    ->prefix('surat-keputusan')
    ->name('surat_keputusan.')
    ->group(function () {
        Route::get('/', [SuratKeputusanController::class, 'index'])->name('index');
        Route::get('/create', [SuratKeputusanController::class, 'create'])->name('create');
        Route::post('/', [SuratKeputusanController::class, 'store'])->name('store');
        Route::get('/{suratKeputusan}', [SuratKeputusanController::class, 'show'])->name('show');
        Route::get('/{suratKeputusan}/edit', [SuratKeputusanController::class, 'edit'])->name('edit');
        Route::put('/{suratKeputusan}', [SuratKeputusanController::class, 'update'])->name('update');
        Route::delete('/{suratKeputusan}', [SuratKeputusanController::class, 'destroy'])->name('destroy');
        Route::get('/{suratKeputusan}/cetak', [SuratKeputusanController::class, 'cetak'])->name('cetak');


    });
});