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
        Schema::create('level', function (Blueprint $table) {
            $table->id();
            $table->string('nama_level');
            $table->timestamps();
        });

        Schema::table('pengguna', function (Blueprint $table) {
            $table->unsignedBigInteger('level_id')->after('id');

            $table->foreign("level_id")->references("id")->on("level");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('level');
    }
};
