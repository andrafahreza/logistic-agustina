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
        Schema::table('pembayaran_vendor', function (Blueprint $table) {
            $table->unsignedBigInteger('data_ekspedisi_id');

            $table->foreign("data_ekspedisi_id")->references("id")->on("data_ekspedisi");
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
