<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstitucionSeeder extends Seeder
{


    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $intituciones = [
            [
                'nombre' => 'Ministerio de Hacienda',
                'tipo'   => 'MINISTERIO',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Ministerio de Salud',
                'tipo'   => 'MINISTERIO',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Alcaldía de San Salvador',
                'tipo'   => 'ALCALDIA',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Alcaldía de Santa Ana',
                'tipo'   => 'ALCALDIA',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Comisión Ejecutiva Portuaria Autónoma',
                'tipo'   => 'AUTONOMA',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('instituciones')->insert($intituciones);
    }
}
