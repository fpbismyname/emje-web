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
        Schema::create('profil_user', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap')->unique();
            $table->string('alamat')->nullable();
            $table->string('nomor_telepon')->nullable()->unique();
            $table->string('pendidikan_terakhir')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->string('tanggal_lahir')->nullable();
            $table->string('foto_profil')->nullable();
            $table->string('ktp')->nullable();
            $table->string('ijazah')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profil_user');
    }
};
