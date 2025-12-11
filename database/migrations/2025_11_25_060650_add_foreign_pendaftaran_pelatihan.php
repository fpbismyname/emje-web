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
        Schema::table('pendaftaran_pelatihan', function (Blueprint $table) {
            $table->foreignId('pelatihan_id')
                ->nullable()
                ->constrained('pelatihan')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('users_id')
                ->nullable()
                ->constrained('users')
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
        Schema::table('pendaftaran_pelatihan', function (Blueprint $table) {
            $table->dropForeign(['pelatihan_id']);
            $table->dropForeign(['users_id']);
            $table->dropForeign(['gelombang_pelatihan_id_id']);
            $table->dropColumn(['pelatihan_id', 'users_id', 'gelombang_pelatihan_id']);
        });
    }
};
