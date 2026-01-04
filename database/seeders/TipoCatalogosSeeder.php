<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Date;

class TipoCatalogosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Date::now();

        // tipo_movimiento
        DB::table('tipo_movimiento')->updateOrInsert(
            ['id' => 1],
            ['nombre' => 'INGRESO', 'created_at' => $now, 'updated_at' => $now]
        );
        DB::table('tipo_movimiento')->updateOrInsert(
            ['id' => 2],
            ['nombre' => 'EGRESO', 'created_at' => $now, 'updated_at' => $now]
        );

        // tipo_producto
        DB::table('tipo_producto')->updateOrInsert(
            ['id' => 1],
            ['nombre' => 'Producto terminado', 'created_at' => $now, 'updated_at' => $now]
        );
        DB::table('tipo_producto')->updateOrInsert(
            ['id' => 2],
            ['nombre' => 'Materia prima', 'created_at' => $now, 'updated_at' => $now]
        );
    }
}
