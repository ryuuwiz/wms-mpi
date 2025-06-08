<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\MutasiBarang;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MutasiBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Make sure we have users and barang to reference
        $users = User::all()->count() > 0 ? User::all() : User::factory(3)->create();
        $barangs = Barang::all()->count() > 0 ? Barang::all() : Barang::factory(5)->create();

        // Create some random mutasi records
        foreach ($barangs as $barang) {
            // Create some incoming items
            MutasiBarang::factory(3)
                ->masuk()
                ->create([
                    'id_user' => $users->random()->id,
                    'id_barang' => $barang->id,
                ]);

            // Create some outgoing items
            MutasiBarang::factory(2)
                ->keluar()
                ->create([
                    'id_user' => $users->random()->id,
                    'id_barang' => $barang->id,
                ]);
        }
    }
}
