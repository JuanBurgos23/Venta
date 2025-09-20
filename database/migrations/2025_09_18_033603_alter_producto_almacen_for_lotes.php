<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // 1) Asegura columnas (solo si faltan)
        if (!Schema::hasColumn('producto_almacen', 'id_lote')) {
            Schema::table('producto_almacen', function (Blueprint $t) {
                $t->string('id_lote', 120)->nullable()->after('empresa_id');
            });
        }
        if (!Schema::hasColumn('producto_almacen', 'lote')) {
            Schema::table('producto_almacen', function (Blueprint $t) {
                $t->string('lote', 100)->nullable()->after('id_lote');
            });
        }
        if (!Schema::hasColumn('producto_almacen', 'producto_compra_id')) {
            Schema::table('producto_almacen', function (Blueprint $t) {
                $t->unsignedBigInteger('producto_compra_id')->nullable()->after('almacen_id');
                // Si quieres FK:
                // $t->foreign('producto_compra_id')->references('id')->on('producto_compra');
            });
        }

        // 2) Lee índices existentes
        $idx = collect(DB::select('SHOW INDEX FROM producto_almacen'))
                ->groupBy('Key_name');

        // 3) Elimina el único viejo SOLO si existe
        if ($idx->has('producto_almacen_producto_id_almacen_id_unique')) {
            DB::statement('ALTER TABLE `producto_almacen` DROP INDEX `producto_almacen_producto_id_almacen_id_unique`');
        }

        // 4) Crea el único nuevo SOLO si NO existe
        if (!$idx->has('u_empresa_almacen_producto_idlote')) {
            DB::statement('ALTER TABLE `producto_almacen`
                           ADD UNIQUE KEY `u_empresa_almacen_producto_idlote`
                           (`empresa_id`,`almacen_id`,`producto_id`,`id_lote`)');
        }

        // 5) Índices de apoyo (créalo solo si no está)
        if (!$idx->has('producto_id')) {
            DB::statement('ALTER TABLE `producto_almacen` ADD INDEX (`producto_id`)');
        }
        if (!$idx->has('almacen_id')) {
            DB::statement('ALTER TABLE `producto_almacen` ADD INDEX (`almacen_id`)');
        }
        if (!$idx->has('producto_compra_id')) {
            DB::statement('ALTER TABLE `producto_almacen` ADD INDEX (`producto_compra_id`)');
        }
    }

    public function down(): void
    {
        $idx = collect(DB::select('SHOW INDEX FROM producto_almacen'))
                ->groupBy('Key_name');

        if ($idx->has('u_empresa_almacen_producto_idlote')) {
            DB::statement('ALTER TABLE `producto_almacen` DROP INDEX `u_empresa_almacen_producto_idlote`');
        }
        // Solo vuelve a crear el índice viejo si de verdad lo necesitas
        if (!$idx->has('producto_almacen_producto_id_almacen_id_unique')) {
            DB::statement('ALTER TABLE `producto_almacen`
                           ADD UNIQUE KEY `producto_almacen_producto_id_almacen_id_unique`
                           (`producto_id`,`almacen_id`)');
        }
    }
};
