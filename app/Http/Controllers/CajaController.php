<?php

namespace App\Http\Controllers;

use App\Models\Caja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CajaController extends Controller
{
    // Verificar si hay una caja activa para el usuario logueado
    public function verificarCajaActiva()
    {
        $usuario = Auth::user();

        $cajaActiva = Caja::where('usuario_id', $usuario->id)
            ->where('empresa_id', $usuario->id_empresa)
            ->where('estado', 1)
            ->first();

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

        $caja = Caja::where('usuario_id', $usuario->id)
            ->where('empresa_id', $usuario->id_empresa)
            ->where('estado', 1)
            ->first();

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

        return response()->json(['success' => true, 'message' => 'Caja cerrada correctamente']);
    }
}
