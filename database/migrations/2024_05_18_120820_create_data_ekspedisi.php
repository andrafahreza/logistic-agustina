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
        Schema::create('data_ekspedisi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supir_id');
            $table->unsignedBigInteger('penjemputan_id');
            $table->unsignedBigInteger('cabang_id');
            $table->string('no_resi');
            $table->string('nama_asal');
            $table->string('nama_penerima');
            $table->text('alamat_asal');
            $table->text('alamat_penerima');
            $table->string('nama_barang');
            $table->integer('jumlah_barang');
            $table->string('volume');
            $table->text('note');
            $table->integer('biaya');
            $table->unsignedBigInteger('created_by');
            $table->timestamps();

            $table->foreign("supir_id")->references("id")->on("supir");
            $table->foreign("penjemputan_id")->references("id")->on("penjemputan");
            $table->foreign("cabang_id")->references("id")->on("cabang");
            $table->foreign("created_by")->references("id")->on("pengguna");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_ekspedisi');
    }
};
