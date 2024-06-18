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
        Schema::create('mutasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')->constrained('barangs')->cascadeOnUpdate()->restrictOnDelete();
			$table->foreignId('ruangan_id')->constrained('ruangans')->cascadeOnUpdate()->restrictOnDelete();
			$table->date('tgl_mutasi');
			$table->enum('jenis_mutasi', ['Barang Keluar', 'Barang Masuk']);
			$table->string('tahun_akademik', 10);
			$table->integer('jml_mutasi');
			$table->string('tempat_asal', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mutasis');
    }
};
