<?php

namespace Database\Factories;

use App\Models\Barang;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MutasiBarang>
 */
class MutasiBarangFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $jenis = ['masuk', 'keluar'][array_rand(['masuk', 'keluar'])];

        return [
            'id_user' => User::factory(),
            'id_barang' => Barang::factory(),
            'jenis_barang' => $jenis,
            'jumlah' => $this->faker->numberBetween(1, 20),
            'keterangan' => $this->faker->optional(0.7)->sentence(),
            'tanggal' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }

    /**
     * Configure the model factory.
     */
    public function masuk(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'jenis_barang' => 'masuk',
            ];
        });
    }

    /**
     * Configure the model factory.
     */
    public function keluar(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'jenis_barang' => 'keluar',
            ];
        });
    }
}
