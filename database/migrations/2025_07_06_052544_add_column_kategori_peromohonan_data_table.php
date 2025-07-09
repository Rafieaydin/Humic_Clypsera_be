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
        Schema::table('permohonan_data', function (Blueprint $table) {
            $table->unsignedBigInteger('operasi_id')->nullable()->change();
            $table->enum('scope', ['sendiri','semua'])->default('sendiri')->after('status_permohonan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
