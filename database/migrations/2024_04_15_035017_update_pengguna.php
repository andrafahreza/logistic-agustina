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
        Schema::table('pengguna', function (Blueprint $table) {
            $table->unsignedBigInteger('level_id')->after('id');
            $table->unsignedBigInteger('pelanggan_id')->nullable()->after('id');
            $table->unsignedBigInteger('vendor_id')->nullable()->after('id');

            $table->foreign("level_id")->references("id")->on("level");
            $table->foreign("pelanggan_id")->references("id")->on("pelanggan");
            $table->foreign("vendor_id")->references("id")->on("vendor");
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
