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
        Schema::table('sertifikasi', function (Blueprint $table) {
            $table->foreignId('pelatihan_diikuti_id')
                ->nullable()
                ->constrained('pelatihan_diikuti')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sertifikasi', function (Blueprint $table) {
            $table->dropForeign(['pelatihan_diikuti_id']);
            $table->dropColumn(['pelatihan_diikuti_id']);
        });
    }
};
