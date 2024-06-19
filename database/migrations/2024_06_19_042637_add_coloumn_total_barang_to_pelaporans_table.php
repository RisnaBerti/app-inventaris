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
        Schema::table('pelaporans', function (Blueprint $table) {
            $table->integer('total_barang')->nullable()->after('jml_hilang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pelaporans', function (Blueprint $table) {
            $table->dropColumn('total_barang');
        });
    }
};
