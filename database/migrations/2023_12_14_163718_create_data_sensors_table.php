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
        Schema::create('data_sensors', function (Blueprint $table) {
            $table->id();
            $table->string('kode_sensor');
            $table->decimal('latitude', 10, 7); // Kolom untuk latitude dengan presisi 10 digit dan 7 digit di belakang koma
            $table->decimal('longitude', 10, 7); // Kolom untuk longitude dengan presisi 10 digit dan 7 digit di belakang koma
            $table->string('tempat_sensor');
            $table->string('alamat');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_sensors');
    }
};
