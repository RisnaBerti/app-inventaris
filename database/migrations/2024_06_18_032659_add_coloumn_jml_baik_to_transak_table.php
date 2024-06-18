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
        Schema::table('transaks', function (Blueprint $table) {
            $table->integer('jml_baik')->nullable()->after('jml_mutasi');
            $table->integer('jml_kurang_baik')->nullable()->after('jml_baik');
            $table->integer('jml_rusak_berat')->nullable()->after('jml_kurang_baik');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transak', function (Blueprint $table) {
            $table->dropColumn('jml_baik');
            $table->dropColumn('jml_kurang_baik');
            $table->dropColumn('jml_rusak_berat');
        });
    }
};
