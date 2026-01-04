<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckSuscripcionVigente
{
    public function handle(Request $request, Closure $next)
    {
        // Si no hay usuario autenticado, no bloqueamos (permitimos login/registro).
        if (!Auth::check()) {
            return $next($request);
        }

        $empresa = $request->user()->empresa;
        $suscripcion = $empresa?->empresaSuscripciones()->latest('fecha_fin')->first();

        $vigente = false;

        if ($suscripcion) {
            // Si ya venciÃ³, marcar estado=0
            if ($suscripcion->fecha_fin && $suscripcion->fecha_fin->isPast()) {
                if ($suscripcion->estado !== false) {
                    $suscripcion->estado = 0;
                    $suscripcion->save();
                }
            }

            // Definir si estÃ¡ vigente
            if ($suscripcion->estado) {
                $vigente = true;
            } elseif ($suscripcion->fecha_fin) {
                $vigente = $suscripcion->fecha_fin->isFuture();
            }
        }

        // Permitir siempre el inicio (dashboard principal)
        $esInicio = $request->routeIs('Inicio') || $request->is('inicio');

        if (!$vigente && !$esInicio) {
            return redirect()->route('Inicio')->with('error', 'Su suscripcion ha vencido.');
        }

        return $next($request);
    }
}
