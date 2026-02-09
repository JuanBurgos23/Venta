<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class FormaPago extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('forma_pago')->insert([
            'id' => 1,
            'nombre' => 'Efectivo',
        ]);
        DB::table('forma_pago')->insert([
            'id' => 2,
            'nombre' => 'Trasnferencia',
        ]);
        DB::table('forma_pago')->insert([
            'id' => 3,
            'nombre' => 'QR',
        ]);
        
    }
}
