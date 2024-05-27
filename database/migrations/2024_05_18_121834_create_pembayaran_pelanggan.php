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
        Schema::create('pembayaran_pelanggan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('data_ekspedisi_id');
            $table->enum('status', ['lunas', 'belum_bayar', 'gagal']);
            $table->timestamps();

            $table->foreign("data_ekspedisi_id")->references("id")->on("data_ekspedisi");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran_pelanggan');
    }
};
