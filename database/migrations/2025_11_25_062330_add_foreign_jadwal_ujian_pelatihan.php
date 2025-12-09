<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('jadwal_ujian_pelatihan', function (Blueprint $table) {
            $table->foreignId('gelombang_pelatihan_id')
                ->nullable()
                ->constrained('gelombang_pelatihan')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwal_ujian_pelatihan', function (Blueprint $table) {
            $table->dropForeign(['gelombang_pelatihan_id']);
            $table->dropColumn(['gelombang_pelatihan_id']);
        });
    }
};
