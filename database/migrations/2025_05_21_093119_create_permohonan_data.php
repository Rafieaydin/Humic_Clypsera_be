<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('permohonan_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('operasi_id')->constrained('operasi')->onDelete('cascade');
            $table->string('nama_pemohon', 50);
            $table->string('nik_pemohon', 16)->unique();
            $table->string('email_pemohon', 50)->unique();
            $table->string('no_telepon', 15);
            $table->string('status_permohonan', 20)->default('pending');
            $table->string('alasan_permohonan', 100);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permohonan_data');
    }
};
