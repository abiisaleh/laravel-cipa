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
            $table->foreignIdFor(App\Models\User::class)->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(App\Models\Tabung::class)->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(App\Models\Pembayaran::class)->nullable()->constrained()->cascadeOnDelete();
            $table->string('tabung');
            $table->integer('harga');
            $table->integer('qty')->default(1);
            $table->integer('subtotal')->virtualAs('harga * qty');
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
