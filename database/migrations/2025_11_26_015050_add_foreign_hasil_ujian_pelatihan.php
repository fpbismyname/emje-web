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
        Schema::table('hasil_ujian_pelatihan', function (Blueprint $table) {
            $table->foreignId('ujian_pelatihan_id')
                ->constrained('ujian_pelatihan')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hasil_ujian_pelatihan', function (Blueprint $table) {
            $table->dropForeign(['ujian_pelatihan_id']);
            $table->dropColumn(['ujian_pelatihan_id']);
        });
    }
};
