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
        Schema::create('pelaporans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')->constrained('barangs')->restrictOnUpdate()->cascadeOnDelete();
			$table->foreignId('ruangan_id')->constrained('ruangans')->restrictOnUpdate()->cascadeOnDelete();
			$table->foreignId('transak_id')->constrained('transaks')->restrictOnUpdate()->cascadeOnDelete();
			$table->string('no_inventaris', 50);
			$table->integer('jml_baik')->nullable();
			$table->integer('jml_kurang_baik')->nullable();
			$table->integer('jml_rusak_berat')->nullable();
			$table->integer('jml_hilang')->nullable()->default('1');
			$table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelaporans');
    }
};
