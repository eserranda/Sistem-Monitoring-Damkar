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
        Schema::table('sensor_monitorings', function (Blueprint $table) {
            $table->boolean('emergency')->default(false)->after('sensor_asap');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sensor_monitorings', function (Blueprint $table) {
            $table->dropColumn('emergency');
        });
    }
};
