<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang', 50);
			$table->string('kode_barang', 15);
			$table->string('merk_model', 25);
			$table->string('ukuran', 25);
			$table->string('bahan', 25);
			$table->year('tahun_pembuatan_pembelian');
			$table->string('satuan', 25);
			$table->integer('jml_barang');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
