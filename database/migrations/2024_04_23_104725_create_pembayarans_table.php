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
            $table->foreignIdFor(App\Models\Pelanggan::class)->nullable()->constrained()->nullOnDelete();
            $table->string('va_id')->nullable();
            $table->string('metode');
            $table->integer('subtotal');
            $table->integer('ongkir');
            $table->integer('denda')->default(0);
            $table->boolean('lunas')->default(false);
            $table->boolean('diterima')->default(false);
            $table->timestamps();
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
