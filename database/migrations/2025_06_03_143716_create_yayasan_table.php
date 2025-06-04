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
        Schema::create('yayasan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_yayasan', 100)->unique();
            $table->string('domisili_yayasan', 100);
            $table->string('alamat_yayasan', 100);
            $table->string('no_telepon', 100);
            $table->string('email_yayasan', 50)->unique();
            $table->string('website_yayasan', 100)->nullable();
            $table->string('logo_yayasan')->default(app()->make('url')->to('/images/logo/default.png'));
            $table->string('deskripsi_yayasan', 255)->nullable();
            $table->string('visi_yayasan', 255)->nullable();
            $table->string('misi_yayasan', 255)->nullable();
            $table->string('status_yayasan', 20)->default('Aktif');
            $table->string('rating_yayasan', 5)->default('0.0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('yayasan');
    }
};
