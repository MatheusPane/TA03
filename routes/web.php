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
use App\Http\Controllers\RefStatusDalamKeluargaController;
use App\Http\Controllers\DataKeluargaAnggotaController;
use App\Http\Controllers\DasawismaController;
use App\Http\Controllers\DasawismaAnggotaController;
use App\Http\Controllers\RefJabatanController;
use App\Http\Controllers\RefJenisAkseptorKbController;
use App\Http\Controllers\RefJenisKelompokBelajarController;
use App\Http\Controllers\RefJenisKoperasiController;
use App\Http\Controllers\DashboardController;

// PUBLIC
Route::get('/', function () {
    return view('welcome');
});

// DASHBOARD (auth & verified)
// DASHBOARD (auth & verified)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
});

// ROUTE UNTUK USER LOGIN
Route::middleware(['auth'])->group(function () {

    // ✅ Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ✅ Referensi & Master Data (khusus Admin)
    Route::middleware(['auth', 'is_admin'])->group(function () {
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

    });

    // ✅ Data Warga: bisa dilihat semua user login
    // ✅ Data Warga: bisa dilihat semua user login
Route::resource('data_warga', DataWargaController::class);
Route::resource('data_keluarga', DataKeluargaController::class);
Route::resource('ref_status_dalam_keluarga', RefStatusDalamKeluargaController::class);

// === DATA KELUARGA ANGGOTA ===
// Index per keluarga
Route::get('/data-keluarga-anggota/{keluarga_id}', [DataKeluargaAnggotaController::class, 'index'])
    ->name('data_keluarga_anggota.index');

// Create form per keluarga
Route::get('/data-keluarga-anggota/create/{keluarga_id}', [DataKeluargaAnggotaController::class, 'create'])
    ->name('data_keluarga_anggota.create');

// Resource lainnya (store, show, edit, update, destroy) tanpa parameter khusus
Route::resource('data_keluarga_anggota', DataKeluargaAnggotaController::class)
    ->except(['index', 'create'])
    ->parameters(['data_keluarga_anggota' => 'anggota']);
// DASAWISMA ANGGOTA
Route::get('/dasawisma/{dasawisma_id}/anggota', [DasawismaAnggotaController::class, 'index'])
->name('dasawisma_anggota.index');

Route::get('/dasawisma/{dasawisma_id}/anggota/create', [DasawismaAnggotaController::class, 'create'])
->name('dasawisma_anggota.create');

Route::post('/dasawisma/{dasawisma_id}/anggota', [DasawismaAnggotaController::class, 'store'])
->name('dasawisma_anggota.store');

Route::delete('/dasawisma-anggota/{id}', [DasawismaAnggotaController::class, 'destroy'])
->name('dasawisma_anggota.destroy');
Route::get('/dasawisma-anggota/{id}/edit', [DasawismaAnggotaController::class, 'edit'])
    ->name('dasawisma_anggota.edit');

Route::patch('/dasawisma-anggota/{id}', [DasawismaAnggotaController::class, 'update'])
    ->name('dasawisma_anggota.update');
Route::resource('dasawisma', DasawismaController::class);
});

// GUEST ROUTES (belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
});

// AUTH ROUTES (sudah login)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});
