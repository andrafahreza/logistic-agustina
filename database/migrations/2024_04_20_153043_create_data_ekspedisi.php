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
            $table->unsignedBigInteger('kendaraan_id')->nullable();
            $table->unsignedBigInteger('supir_id')->nullable();
            $table->integer('district_id');
            $table->string('no_awb');
            $table->string('nama_penerima');
            $table->text('alamat_asal');
            $table->text('alamat_penerima');
            $table->string('nama_barang');
            $table->integer('jumlah_barang');
            $table->string('volume');
            $table->text('note');
            $table->integer('biaya');
            $table->string('file_surat_pengiriman');
            $table->timestamps();

            $table->foreign("kendaraan_id")->references("id")->on("kendaraan");
            $table->foreign("supir_id")->references("id")->on("supir");
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
