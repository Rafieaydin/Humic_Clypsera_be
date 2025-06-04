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
        Schema::create('operasi', function (Blueprint $table) {
            $table->id();
            $table->foreignID('pasien_id')->constrained('pasien')->onDelete('cascade');
            $table->date('tanggal_operasi');
            $table->string('tehnik_operasi', 100);
            $table->string('lokasi_operasi', 100);
            $table->string('foto_sebelum_operasi')->nullable();
            $table->string('foto_setelah_operasi')->nullable();
            $table->foreignID('jenis_kelainan_cleft_id')->constrained('jenis_kelainan_cleft')->onDelete('cascade');
            $table->foreignID('jenis_terapi_id')->constrained('jenis_terapi')->onDelete('cascade');
            $table->foreignID('diagnosis_id')->constrained('diagnosis')->onDelete('cascade');
            $table->string('follow_up', 100)->nullable();
            $table->foreignID('operator_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        // Schema::table('pasien', function (Blueprint $table) {
        //     // $table->integer('operasi_id')->nullable()->after('operator_id');
        //     $table->foreignId('operasi_id')->constrained('operasi')->onDelete('cascade');

        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operasi');
    }
};
