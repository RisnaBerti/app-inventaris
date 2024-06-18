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
        Schema::create('inventors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transak_id')->constrained('transaks')->restrictOnUpdate()->cascadeOnDelete();
			$table->string('no_inventaris', 50);
			$table->integer('jml_baik');
			$table->integer('jml_kurang_baik');
			$table->integer('jml_rusak_berat');
			$table->integer('jml_hilang')->nullable();
			$table->string('keterangan', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventors');
    }
};
