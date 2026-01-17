<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('buku_inventaris', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang');                    // Nama Barang
            $table->string('asal_barang');                    // Asal Barang (misal: APBDes, Sumbangan, dll)
            $table->date('tanggal_pembelian')->nullable();    // Tanggal Pembelian
            $table->integer('jumlah');                        // Jumlah unit
            $table->string('tempat_penyimpanan');             // Kantor Desa / Gudang / dll
            $table->enum('kondisi_barang', [
                'Baik', 'Cukup Baik', 'Rusak Ringan', 'Rusak Berat', 'Hilang'
            ])->default('Baik');                              // Kondisi Barang
            $table->text('keterangan')->nullable();           // Catatan tambahan
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buku_inventaris');
    }
};