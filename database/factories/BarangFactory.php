<?php

namespace Database\Factories;

use App\KondisiBarang;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Barang>
 */
class BarangFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => $this->faker->word(),
            'kondisi' => KondisiBarang::cases()[array_rand(KondisiBarang::cases())]->value,
            'jumlah' => $this->faker->numberBetween(1, 100),
        ];
    }
}
