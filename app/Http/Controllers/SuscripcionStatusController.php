<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SuscripcionStatusController extends Controller
{
    public function status(Request $request)
    {
        // Ajusta este campo según tu tabla users
        $empresaId = $request->user()->id_empresa ?? null;

        if (!$empresaId) {
            return response()->json([
                'errorCode' => 1,
                'errorMessage' => 'El usuario no tiene empresa asignada.',
                'msg' => null
            ], 400);
        }

        $hoy = Carbon::today()->toDateString();

        // Empresa
        $empresa = DB::table('empresa')
            ->select('id', 'nombre', 'logo', 'telefono', 'correo', 'direccion', 'nit', 'qr')
            ->where('id', $empresaId)
            ->first();

        // Suscripción vigente (la más reciente que cubra hoy)
        $sus = DB::table('empresa_suscripcion as es')
            ->join('suscripcion as s', 's.id', '=', 'es.suscripcion_id')
            ->where('es.empresa_id', $empresaId)
            ->whereDate('es.fecha_inicio', '<=', $hoy)
            ->where(function ($q) use ($hoy) {
                $q->whereNull('es.fecha_fin')
                  ->orWhereDate('es.fecha_fin', '>=', $hoy);
            })
            ->orderByRaw('CASE WHEN es.fecha_fin IS NULL THEN 1 ELSE 0 END DESC') // primero ilimitadas
            ->orderByDesc('es.fecha_fin')
            ->select([
                'es.id as empresa_suscripcion_id',
                'es.suscripcion_id',
                's.nombre as plan_nombre',
                's.descripcion as plan_descripcion',
                'es.fecha_inicio',
                'es.fecha_fin',
            ])
            ->first();

        // Si no hay suscripción vigente
        if (!$sus) {
            return response()->json([
                'errorCode' => 0,
                'errorMessage' => 'OK',
                'msg' => [
                    'empresa' => $empresa,
                    'suscripcion' => null,
                    'activo' => false,
                    'dias_restantes' => 0,
                    'estado' => 'SIN_SUSCRIPCION'
                ]
            ]);
        }

        // Cálculo días restantes
        $diasRestantes = null; // null = ilimitado
        if (!empty($sus->fecha_fin)) {
            $diasRestantes = Carbon::parse($sus->fecha_fin)
                ->startOfDay()
                ->diffInDays(Carbon::today(), false) * -1;

            // si ya venció por desfase (por si hay horas, etc.)
            if ($diasRestantes < 0) $diasRestantes = 0;
        }

        return response()->json([
            'errorCode' => 0,
            'errorMessage' => 'OK',
            'msg' => [
                'empresa' => $empresa,
                'suscripcion' => [
                    'empresa_suscripcion_id' => $sus->empresa_suscripcion_id,
                    'suscripcion_id' => $sus->suscripcion_id,
                    'plan_nombre' => $sus->plan_nombre,
                    'plan_descripcion' => $sus->plan_descripcion,
                    'fecha_inicio' => $sus->fecha_inicio,
                    'fecha_fin' => $sus->fecha_fin,
                ],
                'activo' => true,
                'dias_restantes' => $diasRestantes,
                'estado' => empty($sus->fecha_fin) ? 'ILIMITADO' : 'ACTIVO'
            ]
        ]);
    }
}
