<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TramiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tramites = [
            [
                'codigo'         => 'TRM-001',
                'nombre'         => 'Declaración de Renta',
                'descripcion'    => 'Presentación anual de declaración de renta para personas naturales',
                'institucion_id' => 1,
                'dias_habiles'   => 15,
                'activo'         => true,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'codigo'         => 'TRM-002',
                'nombre'         => 'Solvencia Fiscal',
                'descripcion'    => 'Solicitud de solvencia fiscal para personas jurídicas',
                'institucion_id' => 1,
                'dias_habiles'   => 5,
                'activo'         => true,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'codigo'         => 'TRM-003',
                'nombre'         => 'Registro Sanitario',
                'descripcion'    => 'Registro de productos alimenticios para comercialización',
                'institucion_id' => 2,
                'dias_habiles'   => 30,
                'activo'         => true,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'codigo'         => 'TRM-004',
                'nombre'         => 'Permiso de Funcionamiento',
                'descripcion'    => 'Permiso sanitario para establecimientos de salud',
                'institucion_id' => 2,
                'dias_habiles'   => 20,
                'activo'         => true,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'codigo'         => 'TRM-005',
                'nombre'         => 'Solvencia Municipal',
                'descripcion'    => 'Certificado de solvencia de pagos municipales',
                'institucion_id' => 3,
                'dias_habiles'   => 3,
                'activo'         => true,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'codigo'         => 'TRM-006',
                'nombre'         => 'Permiso de Construcción',
                'descripcion'    => 'Autorización para construcción de obras civiles',
                'institucion_id' => 3,
                'dias_habiles'   => 45,
                'activo'         => true,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'codigo'         => 'TRM-007',
                'nombre'         => 'Licencia Comercial',
                'descripcion'    => 'Licencia para operación de negocios en el municipio',
                'institucion_id' => 4,
                'dias_habiles'   => 10,
                'activo'         => true,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'codigo'         => 'TRM-008',
                'nombre'         => 'Certificación Catastral',
                'descripcion'    => 'Certificado de registro catastral de inmuebles',
                'institucion_id' => 4,
                'dias_habiles'   => 7,
                'activo'         => true,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'codigo'         => 'TRM-009',
                'nombre'         => 'Registro de Embarcación',
                'descripcion'    => 'Registro oficial de embarcaciones comerciales',
                'institucion_id' => 5,
                'dias_habiles'   => 25,
                'activo'         => true,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'codigo'         => 'TRM-010',
                'nombre'         => 'Permiso de Importación Portuaria',
                'descripcion'    => 'Autorización para importación de mercancías vía marítima',
                'institucion_id' => 5,
                'dias_habiles'   => 12,
                'activo'         => true,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
        ];

        DB::table('tramites')->insert($tramites);
    }
}
