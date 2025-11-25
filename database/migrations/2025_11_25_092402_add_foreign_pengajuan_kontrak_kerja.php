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
        Schema::table('pengajuan_kontrak_kerja', function (Blueprint $table) {
            $table->foreignId('kontrak_kerja_id')
                ->constrained('kontrak_kerja')
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
        Schema::table('pengajuan_kontrak_kerja', function (Blueprint $table) {
            $table->dropForeign(['kontrak_kerja_id']);
            $table->dropForeign(['users_id']);
            $table->dropColumn(['kontrak_kerja_id', 'users_id']);
        });
    }
};
