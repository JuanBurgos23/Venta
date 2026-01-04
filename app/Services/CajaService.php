<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class CajaService
{
    public static function syncVentasCajaAbierta(
        int $empresaId,
        int $sucursalId,
        int $usuarioId
    ): void {
        // ID del tipo INGRESO (puedes cachearlo)
        $idTipoIngreso = DB::table('tipo_movimiento')
            ->where('nombre', 'INGRESO')
            ->value('id');

        if (!$idTipoIngreso) {
            return;
        }

        DB::statement(
            'CALL sp_sync_detalle_caja_ventas_abierta(?, ?, ?, ?)',
            [$empresaId, $sucursalId, $usuarioId, $idTipoIngreso]
        );
    }

    /**
     * Inserta el movimiento de una venta directamente en detalle_caja para la caja abierta del usuario.
     * Sirve como fallback si el SP no sincroniza.
     */
    public static function registrarVentaDirecta(
        int $empresaId,
        int $sucursalId,
        int $usuarioId,
        int $ventaId,
        string $fechaVenta,
        float $monto
    ): void {
        $idTipoIngreso = DB::table('tipo_movimiento')
            ->where('nombre', 'INGRESO')
            ->value('id');
        if (!$idTipoIngreso) return;

        $caja = DB::table('caja')
            ->where('empresa_id', $empresaId)
            ->where('sucursal_id', $sucursalId)
            ->where('usuario_id', $usuarioId)
            ->where('estado', 1)
            ->orderByDesc('fecha_apertura')
            ->first();

        if (!$caja) return;

        $existe = DB::table('detalle_caja')
            ->where('caja_id', $caja->id)
            ->where('movimiento', 'VENTA')
            ->where('id_movimiento', $ventaId)
            ->exists();

        if ($existe) return;

        DB::table('detalle_caja')->insert([
            'caja_id'          => $caja->id,
            'id_tipo_movimiento' => $idTipoIngreso,
            'movimiento'       => 'VENTA',
            'id_movimiento'    => $ventaId,
            'fecha_movimiento' => $fechaVenta,
            'monto'            => $monto,
            'estado'           => 1,
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);
    }
    public static function syncComprasCajaAbierta(int $empresaId, int $sucursalId, int $usuarioId): void
    {
        $idTipoEgreso = DB::table('tipo_movimiento')
            ->where('nombre', 'EGRESO')
            ->value('id');

        if (!$idTipoEgreso) return;

        DB::statement('CALL sp_sync_detalle_caja_compras_abierta(?, ?, ?, ?)', [
            $empresaId, $sucursalId, $usuarioId, $idTipoEgreso
        ]);
    }


}
