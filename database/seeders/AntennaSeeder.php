<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Antena;

class AntennaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $ufs = ['SP', 'RJ', 'MG', 'BA', 'RS', 'PR', 'SC', 'PE', 'CE', 'GO'];

        for ($i = 1; $i <= 10; $i++) {
            Antena::create([
                'descricao' => 'Antena de teste ' . $i,
                'latitude' => fake()->latitude(-90, 90),
                'longitude' => fake()->longitude(-180, 180),
                'uf' => $ufs[array_rand($ufs)],
                'altura' => fake()->randomFloat(2, 10, 100),
                'data_implantacao' => fake()->date(),
                'foto' => null, // ou uma imagem padrão se quiser
            ]);
        }
    }
}
