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
        Schema::create('kategori_peromohonan', function (Blueprint $table) {
            $table->id();
            $table->string('kategori', 50)->unique();
            $table->timestamps();
        });

        Schema::table('permohonan_data', function (Blueprint $table) {
            $table->foreignId('kategori_id')->constrained('kategori_peromohonan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategori_peromohonan');
    }
};
