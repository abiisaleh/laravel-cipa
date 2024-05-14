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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->string('va_id')->nullable();
            $table->string('metode');
            $table->integer('subtotal');
            $table->integer('ongkir');
            $table->boolean('lunas')->default(false);
            $table->dateTime('tgl_lunas')->nullable();
            $table->boolean('diterima')->default(false);
            $table->dateTime('tgl_diterima')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
