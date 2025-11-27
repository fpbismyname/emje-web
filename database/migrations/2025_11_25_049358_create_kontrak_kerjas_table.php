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
        Schema::create('kontrak_kerja', function (Blueprint $table) {
            $table->id();
            $table->string('nama_perusahaan');
            $table->decimal('gaji_terendah', 15, 2);
            $table->decimal('gaji_tertinggi', 15, 2);
            $table->string('status');
            $table->text('deskripsi');
            $table->integer('durasi_kontrak_kerja');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kontrak_kerja');
    }
};
