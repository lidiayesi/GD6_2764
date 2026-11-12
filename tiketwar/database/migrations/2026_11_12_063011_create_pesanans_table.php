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
         Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('konser_id')->constrained()->restricOnDelete();
            $table->string('nama_pemesan');
            $table->string('email');
            $table->unsignedInteger('jumlah');
            $table->unsignedInteger('harga_satuan');
            $table->unsignedBigInteger('total');
            $table->string('status', 20)->default('menunggu_bayar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};
