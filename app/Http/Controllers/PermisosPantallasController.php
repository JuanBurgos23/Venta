<?php

namespace App\Http\Controllers;

use App\Models\AppModulo;
use App\Models\AppPantalla;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

class PermisosPantallasController extends Controller
{
    private function resolveEmpresaId(Request $request): int
    {
        return (int) ($request->user()->id_empresa ?? 0);
    }

    public function index(Request $request)
    {
        $empresaId = $this->resolveEmpresaId($request);

        $roles = DB::table('roles as r')
            ->leftJoin('user_role as ur', function ($join) use ($empresaId) {
                $join->on('ur.role_id', '=', 'r.id')
                    ->where('ur.empresa_id', '=', $empresaId);
            })
            ->where('r.empresa_id', $empresaId)
            ->groupBy('r.id', 'r.empresa_id', 'r.nombre', 'r.estado', 'r.created_at', 'r.updated_at')
            ->orderBy('r.nombre')
            ->selectRaw('r.*, COUNT(ur.user_id) as users_count')
            ->get();

        // Catálogo global
        $modulos = AppModulo::with(['pantallas' => function ($q) {
                $q->where('estado', 1)->orderBy('orden');
            }])
            ->where('estado', 1)
            ->orderBy('orden')
            ->get();

        $pantallasActivas = AppPantalla::where('estado', 1)->count();

        // Mapa rápido: role_id => [pantalla_id => true]
        $rolePermMap = DB::table('role_pantalla')
            ->where('empresa_id', $empresaId)
            ->get()
            ->groupBy('role_id')
            ->map(fn ($rows) => $rows->pluck('pantalla_id')->flip()->toArray())
            ->toArray();

        // Conteo permisos asignados (aprox. por pivots)
        $permisosAsignados = DB::table('role_pantalla')
            ->where('empresa_id', $empresaId)
            ->count();

        // última actualización (si no tienes timestamps en pivot, usa permissions.updated_at como referencia)
        $ultimaActualizacion = AppPantalla::max('updated_at');

        return view('rol.permisos', compact(
            'roles','modulos','rolePermMap','pantallasActivas','permisosAsignados','ultimaActualizacion'
        ));
    }

    public function guardarCambios(Request $request)
    {
        $empresaId = $this->resolveEmpresaId($request);

        $changes = $request->input('changes', []);
        if (!is_array($changes)) {
            return response()->json(['success' => false, 'message' => 'Formato inválido.'], 422);
        }

        DB::beginTransaction();
        try {
            foreach ($changes as $c) {
                $roleId = (int) ($c['role_id'] ?? 0);
                $screenId = (int) ($c['screen_id'] ?? 0);
                $action = $c['action'] ?? null; // attach | detach

                if (!$roleId || !$screenId || !in_array($action, ['attach','detach'], true)) {
                    continue;
                }

                $role = DB::table('roles')
                    ->where('empresa_id', $empresaId)
                    ->where('id', $roleId)
                    ->first();
                if (! $role) continue;

                $pantalla = AppPantalla::where('id', $screenId)->where('estado', 1)->first();
                if (! $pantalla) continue;

                if ($action === 'attach') {
                    DB::table('role_pantalla')->updateOrInsert(
                        ['empresa_id' => $empresaId, 'role_id' => $roleId, 'pantalla_id' => $screenId],
                        ['empresa_id' => $empresaId, 'role_id' => $roleId, 'pantalla_id' => $screenId]
                    );
                } else {
                    DB::table('role_pantalla')
                        ->where('empresa_id', $empresaId)
                        ->where('role_id', $roleId)
                        ->where('pantalla_id', $screenId)
                        ->delete();
                }
            }

            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // Opcionales para tus modales:
    public function detallePantalla(AppPantalla $pantalla)
    {
        if ($pantalla->estado != 1) {
            return response()->json(['html' => '<p>Pantalla inactiva.</p>']);
        }

        return response()->json([
            'html' => '
                <div>
                    <p><strong>Nombre:</strong> '.$pantalla->nombre.'</p>
                    <p><strong>Ruta:</strong> '.$pantalla->route_name.'</p>
                    <p><strong>URI:</strong> '.$pantalla->uri.'</p>
                </div>
            '
        ]);
    }

    public function resumenRol(Request $request, $role)
    {
        $empresaId = $this->resolveEmpresaId($request);
        $roleRow = DB::table('roles')->where('id', $role)->first();
        abort_unless($roleRow && $roleRow->empresa_id == $empresaId, 403);

        $pantallas = DB::table('role_pantalla as rp')
            ->join('app_pantallas as p', 'p.id', '=', 'rp.pantalla_id')
            ->where('rp.empresa_id', $empresaId)
            ->where('rp.role_id', $role)
            ->orderBy('p.nombre')
            ->select('p.nombre', 'p.route_name')
            ->get();

        return response()->json([
            'html' => view('rol.permisos_resumen', compact('roleRow','pantallas'))->render()
        ]);
    }

    public function syncPantallas(Request $request)
    {
        $routes = collect(Route::getRoutes())
            ->filter(function ($route) {
                $name = $route->getName();
                return $route->methods()[0] === 'GET'
                    && empty($route->parameterNames())
                    && $name !== null
                    && ($name === 'Inicio' || in_array($name, ['Cliente', 'Empresa', 'Perfil']) || str_ends_with($name, '.index'));
            })
            ->values();

        DB::beginTransaction();
        try {
            foreach ($routes as $route) {
                $name = $route->getName();
                $category = 'Otras';
                if ($name === 'Inicio') {
                    $category = 'Inicio';
                } elseif (in_array($name, ['Cliente', 'Empresa', 'Perfil'])) {
                    $category = $name;
                } elseif (str_contains($name, '.')) {
                    $category = ucfirst(strtok($name, '.'));
                }

                $moduloId = DB::table('app_modulos')->updateOrInsert(
                    ['nombre' => $category],
                    ['nombre' => $category, 'estado' => 1, 'updated_at' => now(), 'created_at' => now()]
                );

                $moduloId = DB::table('app_modulos')
                    ->where('nombre', $category)
                    ->value('id');

                DB::table('app_pantallas')->updateOrInsert(
                    ['route_name' => $name],
                    [
                        'modulo_id' => $moduloId,
                        'nombre' => $name,
                        'route_name' => $name,
                        'uri' => $route->uri(),
                        'estado' => 1,
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]
                );
            }

            DB::commit();
            return redirect()->route('permisos.pantallas')->with('success', 'Pantallas sincronizadas correctamente');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->route('permisos.pantallas')->with('error', $e->getMessage());
        }
    }
}
