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
        Schema::table('pembayaran_dana_talang', function (Blueprint $table) {
            $table->foreignId('pengajuan_kontrak_kerja_id')
                ->constrained('pengajuan_kontrak_kerja')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pembayaran_dana_talang', function (Blueprint $table) {
            $table->dropForeign(['pengajuan_kontrak_kerja_id']);
            $table->dropColumn(['pengajuan_kontrak_kerja_id']);
        });
    }
};
