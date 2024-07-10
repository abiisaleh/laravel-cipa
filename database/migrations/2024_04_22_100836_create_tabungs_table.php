<?php

use App\Models\JenisTabung;
use App\Models\UkuranTabung;
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
            $table->foreignIdFor(JenisTabung::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(UkuranTabung::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
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
