<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Date;

class SuscripcionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Date::now();

        DB::table('suscripcion')->updateOrInsert(
            ['id' => 1],
            [
                'nombre' => 'Plan Gratis',
                'descripcion' => 'Plan gratuito por defecto para nuevas empresas',
                'estado' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );
    }
}
