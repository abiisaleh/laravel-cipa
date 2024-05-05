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
        Schema::create('tabungs', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->enum('jenis', ['oksigen', 'nitrogen']);
            $table->string('ukuran');
            $table->integer('berat')->default(10);
            $table->integer('stok')->default(1);
            $table->integer('harga_full');
            $table->integer('harga_refill');
            $table->integer('harga_kosong');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tabungs');
    }
};
