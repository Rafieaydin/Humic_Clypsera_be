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
        Schema::create('permohonan_data_token', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permnohonan_data_id')
                ->constrained('permohonan_data')
                ->onDelete('cascade');
            $table->uuid('token')->unique()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('token_download_permohonan_data');
    }
};
