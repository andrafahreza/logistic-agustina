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
        Schema::create('biaya', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cabang_id');
            $table->integer('biaya');
            $table->string('service');
            $table->string('minimal_berat');
            $table->string('pengiriman');
            $table->string('jangka_waktu');
            $table->timestamps();

            $table->foreign("cabang_id")->references("id")->on("cabang");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biaya');
    }
};
