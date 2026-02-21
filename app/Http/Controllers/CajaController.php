<?php

namespace App\Http\Controllers;

use App\Models\Caja;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CajaController extends Controller
{
    // Verificar si hay una caja activa para el usuario logueado
    public function verificarCajaActiva(Request $request)
    {
        $usuario = Auth::user();
        $sucursalId = $request->input('sucursal_id');

        $query = Caja::where('usuario_id', $usuario->id)
            ->where('empresa_id', $usuario->id_empresa)
            ->where('estado', 1);

        if ($sucursalId) {
            $query->where('sucursal_id', $sucursalId);
        }

        $cajaActiva = $query->first();

        if ($cajaActiva) {
            return response()->json(['activa' => true, 'caja' => $cajaActiva]);
        } else {
            return response()->json(['activa' => false]);
        }
    }

    // Registrar apertura de caja
    public function abrirCaja(Request $request)
    {
        $usuario = Auth::user();

        $caja = Caja::create([
            'fecha_apertura' => now(),
            'monto_inicial' => $request->monto_inicial,
            'estado' => 1,
            'usuario_id' => $usuario->id,
            'sucursal_id' => $request->sucursal_id,
            'empresa_id' => $usuario->id_empresa,
        ]);

        return response()->json(['success' => true, 'caja' => $caja]);
    }
    public function cerrarCaja(Request $request)
    {
        $usuario = auth()->user();
        $sucursalId = $request->input('sucursal_id');

        $query = Caja::where('usuario_id', $usuario->id)
            ->where('empresa_id', $usuario->id_empresa)
            ->where('estado', 1);

        if ($sucursalId) {
            $query->where('sucursal_id', $sucursalId);
        }

        $caja = $query->first();

        if (!$caja) {
            return response()->json(['success' => false, 'message' => 'No hay caja activa.']);
        }

        $caja->update([
            'fecha_cierre' => $request->fecha_cierre,
            'monto_final' => $request->monto_final,
            'observacion' => $request->observacion,
            'estado' => 0,
            'updated_at' => now(),
        ]);

        // 🔹 Retornar URL para abrir en otra pestaña
        $urlComprobante = route('caja.comprobante', ['id' => $caja->id]);

        return response()->json([
            'success' => true,
            'message' => 'Caja cerrada correctamente',
            'url_comprobante' => $urlComprobante
        ]);
    }

    public function verComprobante($id)
    {
        $caja = Caja::with([
            'usuario',
            'sucursal',
            'empresa',
            'detalleCaja'
        ])->findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | VENTAS (separando efectivo / no efectivo desde tabla venta)
        |--------------------------------------------------------------------------
        */
        $fechaFin = $caja->fecha_cierre ?? now();

        $ventasQuery = Venta::query()
            ->where('empresa_id', $caja->empresa_id)
            ->where('sucursal_id', $caja->sucursal_id)
            ->where('usuario_id', $caja->usuario_id)
            ->whereBetween('fecha', [$caja->fecha_apertura, $fechaFin])
            ->where('estado', 'Pagado');

        $ventasEfectivo = (clone $ventasQuery)
            ->where('forma_pago', 'Efectivo')
            ->sum('total');

        $ventasNoEfectivo = (clone $ventasQuery)
            ->whereIn('forma_pago', ['Qr', 'Tarjeta'])
            ->sum('total');

        $totalVentas = $ventasEfectivo + $ventasNoEfectivo;

        /*
        |--------------------------------------------------------------------------
        | INGRESOS VARIOS (NO ventas)
        |--------------------------------------------------------------------------
        */
        $ingresosVarios = $caja->detalleCaja
            ->where('movimiento', 'INGRESO')
            ->sum('monto');

        /*
        |--------------------------------------------------------------------------
        | EGRESOS
        |--------------------------------------------------------------------------
        */
        $egresos = $caja->detalleCaja
            ->where('movimiento', 'EGRESO')
            ->sum('monto');

        /*
        |--------------------------------------------------------------------------
        | EFECTIVO ESPERADO
        |--------------------------------------------------------------------------
        */
        $efectivoEsperado =
            $caja->monto_inicial
            + $ventasEfectivo
            + $ingresosVarios
            - $egresos;

        /*
        |--------------------------------------------------------------------------
        | DIFERENCIA
        |--------------------------------------------------------------------------
        */
        $diferencia = $caja->monto_final - $efectivoEsperado;

        return view('caja.comprobante', compact(
            'caja',
            'ventasEfectivo',
            'ventasNoEfectivo',
            'totalVentas',
            'ingresosVarios',
            'egresos',
            'efectivoEsperado',
            'diferencia'
        ));
    }


}
