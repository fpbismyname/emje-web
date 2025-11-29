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
        Schema::create('pembayaran_pelatihan', function (Blueprint $table) {
            $table->id();
            $table->decimal('nominal', 15, 2);
            $table->string('status');
            $table->string('jenis_pembayaran');
            $table->string('bukti_pembayaran');
            $table->text('catatan')->nullable();
            $table->dateTime('tanggal_pembayaran');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran_pelatihan');
    }
};
