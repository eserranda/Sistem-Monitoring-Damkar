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
        Schema::table('data_damkars', function (Blueprint $table) {
            $table->unsignedBigInteger('id_damkar')->after('id');
            $table->foreign('id_damkar')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_damkars', function (Blueprint $table) {
            $table->dropForeign(['id_damkar']);
            $table->dropColumn('id_damkar');
        });
    }
};
