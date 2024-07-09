<?php

use App\Models\HargaTabung;
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
            $table->foreignIdFor(HargaTabung::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->boolean('active')->default(true);
            $table->boolean('digunakan')->default(false);
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
