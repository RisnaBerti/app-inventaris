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
            $table->string('no_inventaris')->nullable()->after('jml_mutasi');
            $table->string('qrcode')->nullable()->after('no_inventaris');
            $table->enum('jenis_pengadaan', ['PENGADAAN', 'BANTUAN', 'HIBAH'])->nullable()->after('qrcode');            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transak', function (Blueprint $table) {
            $table->dropColumn('no_inventaris');
            $table->dropColumn('qrcode');
            $table->dropColumn('jenis_pengadaan');
        });
    }
};
