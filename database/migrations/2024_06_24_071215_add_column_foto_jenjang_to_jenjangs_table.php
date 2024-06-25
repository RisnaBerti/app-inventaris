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
        Schema::table('jenjangs', function (Blueprint $table) {
            // nama_sekolah
            $table->string('nama_sekolah', 30)->nullable()->after('kode_jenjang');
            $table->string('foto_jenjang')->nullable()->after('nama_jenjang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jenjangs', function (Blueprint $table) {
            $table->dropColumn('nama_sekolah');
            $table->dropColumn('foto_jenjang');
        });
    }
};
