<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\ImportProductosRequest;

class ImportProductosController extends Controller
{
    /**
 * Cache esperado:
 * $cache = [
 *   'unidad_medida' => [empresaId => [ nombre_lower => id ]],
 *   'categoria'     => [empresaId => [ nombre_lower => id ]],
 *   'subcategoria'  => [categoriaId => [ nombre_lower => id ]],
 * ];
 */

    private function resolveUnidadMedidaId(?string $name, int $empresaId, array &$cache, bool $autoCreate = true): ?int
    {
        $n = trim((string)($name ?? ''));
        if ($n === '') return null;

        $key = mb_strtolower($n);
        if (!isset($cache['unidad_medida'][$empresaId])) $cache['unidad_medida'][$empresaId] = [];
        if (isset($cache['unidad_medida'][$empresaId][$key])) return $cache['unidad_medida'][$empresaId][$key];

        // Buscar por empresa+nombre
        $id = DB::table('unidad_medida')
            ->where('id_empresa', $empresaId)
            ->whereRaw('LOWER(nombre) = ?', [$key])
            ->value('id');

        if ($id) {
            return $cache['unidad_medida'][$empresaId][$key] = (int)$id;
        }

        if (!$autoCreate) {
            throw new \Exception("Unidad de medida '{$n}' no existe");
        }

        // Crear con empresa
        $id = DB::table('unidad_medida')->insertGetId([
            'id_empresa' => $empresaId,
            'nombre'     => $n,
            'estado'     => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return $cache['unidad_medida'][$empresaId][$key] = (int)$id;
    }

    private function resolveCategoriaId(?string $name, int $empresaId, array &$cache, bool $autoCreate = true): ?int
    {
        $n = trim((string)($name ?? ''));
        if ($n === '') return null;

        $key = mb_strtolower($n);
        if (!isset($cache['categoria'][$empresaId])) $cache['categoria'][$empresaId] = [];
        if (isset($cache['categoria'][$empresaId][$key])) return $cache['categoria'][$empresaId][$key];

        $id = DB::table('categoria')
            ->where('id_empresa', $empresaId)
            ->whereRaw('LOWER(nombre) = ?', [$key])
            ->value('id');

        if ($id) {
            return $cache['categoria'][$empresaId][$key] = (int)$id;
        }

        if (!$autoCreate) {
            throw new \Exception("Categoría '{$n}' no existe");
        }

        $id = DB::table('categoria')->insertGetId([
            'id_empresa'  => $empresaId,
            'nombre'      => $n,
            'descripcion' => null,
            'estado'      => 1,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        return $cache['categoria'][$empresaId][$key] = (int)$id;
    }

    private function resolveSubcategoriaId(?string $name, ?int $categoriaId, array &$cache, bool $autoCreate = true): ?int
    {
        $n = trim((string)($name ?? ''));
        if ($n === '' || !$categoriaId) return null;

        $key = mb_strtolower($n);
        if (!isset($cache['subcategoria'][$categoriaId])) $cache['subcategoria'][$categoriaId] = [];
        if (isset($cache['subcategoria'][$categoriaId][$key])) return $cache['subcategoria'][$categoriaId][$key];

        $id = DB::table('subcategoria')
            ->where('categoria_id', $categoriaId)
            ->whereRaw('LOWER(nombre) = ?', [$key])
            ->value('id');

        if ($id) {
            return $cache['subcategoria'][$categoriaId][$key] = (int)$id;
        }

        if (!$autoCreate) {
            throw new \Exception("Subcategoría '{$n}' no existe para la categoría #{$categoriaId}");
        }

        $id = DB::table('subcategoria')->insertGetId([
            'categoria_id'=> $categoriaId,
            'nombre'      => $n,
            'descripcion' => null,
            'estado'      => 1,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        return $cache['subcategoria'][$categoriaId][$key] = (int)$id;
    }



    public function store(ImportProductosRequest $request)
    {
        // 1) Determina la empresa (ajusta a tu auth/tenant)
        $empresaId = auth()->user()->empresa_id ?? $request->get('id_empresa');
        if (!$empresaId) {
            return response()->json(['ok'=>false,'msg'=>'No se pudo determinar la empresa'], 422);
        }

        $items = $request->input('items', []);
        $resumen = [
            'ok' => true,
            'insertados' => 0,
            'actualizados' => 0,
            'errores' => [],
        ];

        // 2) Cachés para resolver IDs por nombre (evita consultas repetidas)
        $cache = [
            'unidad_medida' => [],
            'tipo_producto' => [],
            'categoria' => [],
            'subcategoria' => [],
            'tipo_precio' => [],
            'proveedor' => [],
        ];

        DB::beginTransaction();
        try {
            foreach ($items as $i => $row) {
                try {
                    $codigo = trim((string)($row['codigo'] ?? ''));
                    $nombre = trim((string)($row['nombre'] ?? ''));
                    if ($codigo === '' || $nombre === '') {
                        throw new \Exception('Código y nombre son obligatorios');
                    }

                    // 2) Resolver/crear UNIDAD, CATEGORÍA y SUBCATEGORÍA
                    $unidadMedidaId = $this->resolveUnidadMedidaId($row['unidad'] ?? null, $empresaId, $cache);
                    $categoriaId    = $this->resolveCategoriaId($row['categoria'] ?? null, $empresaId, $cache);
                    $subcategoriaId = $this->resolveSubcategoriaId($row['subcategoria'] ?? null, $categoriaId, $cache);

                    // (Opcional) Si luego necesitas estos, puedes dejarlos en null.
                    $tipoProductoId = null;
                    $tipoPrecioId   = null;
                    $proveedorId    = null;

                    // 3) Precio
                    $precio = isset($row['precio']) && $row['precio'] !== '' ? (float)$row['precio'] : 0;

                    // 4) Upsert por (id_empresa, codigo)
                    $match = ['id_empresa' => $empresaId, 'codigo' => $codigo];
                    $data  = [
                        'nombre'           => $nombre,
                        'descripcion'      => $row['descripcion'] ?? null,
                        'marca'            => $row['marca'] ?? null,
                        'modelo'           => $row['modelo'] ?? null,
                        'origen'           => $row['origen'] ?? null,
                        'estado'           => 1,
                        'inventariable'    => 1,
                        'precio'           => $precio,

                        'unidad_medida_id' => $unidadMedidaId,
                        'tipo_producto_id' => $tipoProductoId,
                        'categoria_id'     => $categoriaId,
                        'subcategoria_id'  => $subcategoriaId,
                        'tipo_precio_id'   => $tipoPrecioId,
                        'proveedor_id'     => $proveedorId,
                        'updated_at'       => now(),
                    ];

                    $producto = Producto::where($match)->first();
                    if ($producto) {
                        $producto->fill($data)->save();
                        $resumen['actualizados']++;
                    } else {
                        $data = array_merge($match, $data);
                        $data['created_at'] = now();
                        Producto::create($data);
                        $resumen['insertados']++;
                    }
                } catch (\Throwable $e) {
                    $resumen['errores'][] = [
                        'index' => $i,
                        'codigo' => $row['codigo'] ?? null,
                        'error' => $e->getMessage(),
                    ];
                    // Continúa con el siguiente
                }
            }

            // Si hubo muchos errores, puedes decidir revertir:
            // if (count($resumen['errores']) > 0) { throw new \Exception('Errores en filas'); }

            DB::commit();
            return response()->json($resumen);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'ok' => false,
                'msg' => 'No se pudo completar la importación',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Resuelve el ID de una tabla catáloga por nombre (o crea si no existe).
     * Ajusta nombres de tablas/columnas según tus modelos reales.
     */
    private function resolveIdByName(
        string $table,
        ?string $name,
        array &$cache,
        int $empresaId,
        string $matchOn = 'nombre',
        bool $autoCreate = true
    ): ?int {
        $n = trim((string)($name ?? ''));
        if ($n === '') return null;
    
        $key = mb_strtolower($n);
    
        // cache por tabla + empresa
        if (!isset($cache[$table])) $cache[$table] = [];
        if (!isset($cache[$table][$empresaId])) $cache[$table][$empresaId] = [];
        if (isset($cache[$table][$empresaId][$key])) return $cache[$table][$empresaId][$key];
    
        // si el catálogo tiene columna empresa
        $empresaCol = $this->companyColumnFor($table); // 'id_empresa' o null
        $q = DB::table($table)->whereRaw('LOWER('.$matchOn.') = ?', [$key]);
        if ($empresaCol) $q->where($empresaCol, $empresaId);
    
        $id = $q->value('id');
        if ($id) {
            return $cache[$table][$empresaId][$key] = (int)$id;
        }
    
        // no encontrado
        if (!$autoCreate) {
            throw new \Exception("El valor '{$n}' no existe en {$table}");
        }
    
        // crear registro scoped por empresa (si aplica)
        $data = [
            $matchOn     => $n,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        if ($empresaCol) $data[$empresaCol] = $empresaId;
    
        $id = DB::table($table)->insertGetId($data);
        return $cache[$table][$empresaId][$key] = (int)$id;
    }
    
    /** Devuelve el nombre de la columna de empresa en el catálogo o null si no tiene */
    private function companyColumnFor(string $table): ?string
    {
        // Ajusta esta lista a tu esquema real:
        $withEmpresa = [
            'unidad_medida' => 'id_empresa',
            'tipo_producto' => 'id_empresa',
            'categoria'     => 'id_empresa',
            'subcategoria'  => 'id_empresa',
            'tipo_precio'   => 'id_empresa',
            'proveedor'     => 'id_empresa',
        ];
        return $withEmpresa[$table] ?? null;
    }
}
