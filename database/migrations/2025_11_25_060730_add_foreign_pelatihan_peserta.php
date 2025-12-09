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
        Schema::table('pelatihan_peserta', function (Blueprint $table) {
            $table->foreignId('pendaftaran_pelatihan_id')
                ->nullable()
                ->constrained('pendaftaran_pelatihan')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
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
        Schema::table('pelatihan_peserta', function (Blueprint $table) {
            $table->dropForeign(['pendaftaran_pelatihan_id']);
            $table->dropForeign(['gelombang_pelatihan_id']);
            $table->dropColumn(['pendaftaran_pelatihan_id', 'gelombang_pelatihan_id']);
        });
    }
};
