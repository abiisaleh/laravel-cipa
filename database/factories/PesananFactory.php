<?php

namespace Database\Factories;

use App\Models\Pesanan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pesanan>
 */
class PesananFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'qty' => rand(1, 5),
            'created_at' => now()->subHour(),
        ];
    }

    /**
     * Configure the model factory.
     */
    public function configure(): static
    {
        return $this->afterMaking(function (Pesanan $record) {
            $record->nama = 'tabung ' . $record->tabung->jenis . ' ' . $record->tabung->ukuran . ' refill';
            $record->harga = $record->tabung->harga_refill;
        });
    }
}
