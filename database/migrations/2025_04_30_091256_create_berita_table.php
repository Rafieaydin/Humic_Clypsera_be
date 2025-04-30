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
        Schema::create('berita', function (Blueprint $table) {
            $table->id();
            $table->string('judul')->unique();
            $table->string('slug')->unique();
            $table->string('gambar')->nullable();
            $table->text('content');
            $table->string('sumber')->nullable();
            $table->string('status')->default('draft');
            // $table->foreignId('kategori_id')->constrained('kategori')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // $table->foreignId('status_id')->constrained('status')->onDelete('cascade');
            // $table->foreignId('komentar_id')->nullable()->constrained('komentar')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berita');
    }
};
