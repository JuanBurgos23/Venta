<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CheckEmpresaSuscripcion
{
    public function handle(Request $request, Closure $next)
    {
        // Rutas permitidas aunque esté vencido (ajusta a tus rutas reales)
        $allow = [
            'suscripcion.*',     // pantallas de suscripción / renovar
            'logout',
            'api/empresa/suscripcion/status',
        ];

        foreach ($allow as $pattern) {
            if ($request->routeIs($pattern) || $request->is($pattern)) {
                return $next($request);
            }
        }

        $user = $request->user();
        if (!$user) return $next($request); // por si no está autenticado aún

        // Ajusta el campo según tu User
        $empresaId = $user->empresa_id ?? $user->id_empresa ?? null;

        $hoy = Carbon::today()->toDateString();

        $vigente = DB::table('empresa_suscripcion')
            ->where('empresa_id', $empresaId)
            ->whereDate('fecha_inicio', '<=', $hoy)
            ->where(function ($q) use ($hoy) {
                $q->whereNull('fecha_fin')
                  ->orWhereDate('fecha_fin', '>=', $hoy);
            })
            ->exists();

        if (!$vigente) {
            // Si la petición espera JSON, responde JSON
            if ($request->expectsJson()) {
                return response()->json([
                    'errorCode' => 402,
                    'errorMessage' => 'Suscripción vencida',
                ], 402);
            }

        }

        return $next($request);
    }
}
