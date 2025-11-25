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
                ->constrained('pelatihan')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('users_id')
                ->constrained('users')
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
            $table->dropColumn(['pelatihan_id', 'users_id']);
        });
    }
};
