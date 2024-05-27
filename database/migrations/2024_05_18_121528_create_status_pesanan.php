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
        Schema::create('status_pesanan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('data_ekspedisi_id');
            $table->datetime('waktu');
            $table->text('note');
            $table->string('status');
            $table->timestamps();

            $table->foreign("data_ekspedisi_id")->references("id")->on("data_ekspedisi");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_pesanan');
    }
};
