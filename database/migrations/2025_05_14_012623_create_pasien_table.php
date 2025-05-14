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
        Schema::create('pasien', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pasien', 100);
            $table->date('tanggal_lahir');
            $table->integer('umur_pasien');
            $table->string('alamat_pasien', 100);
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('no_telepon', 15);
            $table->integer('pasien_anak_ke_berapa');
            $table->string('kelainan_kotigental', 100);
            $table->string('riwayat_kehamilan', 100);
            $table->string('riwayat_keluarga_pasien', 100);
            $table->string('riwayat_kawin_berabat', 100);
            $table->string('riwayat_terdahulu', 100);
            //  $table->foreignId('operator_id')->constrained('users','costomid')->onDelete('cascade');
            $table->foreignId('operator_id')->constrained('users')->onDelete('cascade');
            // $table->string('status', 20)->default('draft');
            // $table->foreignId('status_changed_id')->constrained('users')->onDelete('cascade');
            // $table->string('status_changed_reason', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasien');
    }
};
