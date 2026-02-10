<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckPantallaAccess
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        if (! $user) {
            return $next($request);
        }

        $routeName = $request->route()?->getName();
        if (! $routeName) {
            return $next($request);
        }

        $empresaId = $user->id_empresa ?? null;
        if (! $empresaId) {
            return $next($request);
        }

        $pantallaId = DB::table('app_pantallas')
            ->where('route_name', $routeName)
            ->where('estado', 1)
            ->value('id');

        // Si la pantalla no está registrada, no bloquear.
        if (! $pantallaId) {
            return $next($request);
        }

        $tieneAcceso = DB::table('role_pantalla as rp')
            ->join('user_role as ur', function ($join) use ($empresaId) {
                $join->on('ur.role_id', '=', 'rp.role_id')
                    ->where('ur.empresa_id', '=', $empresaId);
            })
            ->where('rp.empresa_id', $empresaId)
            ->where('ur.user_id', $user->id)
            ->where('rp.pantalla_id', $pantallaId)
            ->exists();

        if (! $tieneAcceso) {
            abort(403, 'No tienes permiso para acceder a esta pantalla.');
        }

        return $next($request);
    }
}
