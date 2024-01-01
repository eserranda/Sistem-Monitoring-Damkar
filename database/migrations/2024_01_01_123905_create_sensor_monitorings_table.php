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
        Schema::create('sensor_monitorings', function (Blueprint $table) {
            $table->id();
            $table->string('apiKey')->unique();
            $table->boolean('sensor_api')->default(false);
            $table->boolean('sensor_gas')->default(false);
            $table->boolean('sensor_suhu')->default(false);
            $table->boolean('sensor_asap')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sensor_monitorings');
    }
};
