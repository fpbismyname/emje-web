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
        Schema::table('kontrak_kerja_diikuti', function (Blueprint $table) {
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('kontrak_kerja_id')
                ->constrained('kontrak_kerja')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kontrak_kerja_diikuti', function (Blueprint $table) {
            $table->dropForeign(['users_id']);
            $table->dropForeign(['kontrak_kerja_id']);
            $table->dropColumn(['users_id', 'kontrak_kerja_id']);
        });
    }
};
