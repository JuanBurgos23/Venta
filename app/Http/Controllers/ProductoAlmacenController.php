<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\almacen;
use Illuminate\Http\Request;
use App\Models\Producto_almacen;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ProductoAlmacenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function reporteInventario(Request $request)
    {
        // 1) Empresa: del usuario o del request (obligatorio)
        $user = auth()->user();
        if (!$user || !$user->id_empresa) {
            abort(400, 'Falta empresa_id en el usuario autenticado.');
        }
        $empresaId = (int) $user->id_empresa;

        // 2) Query base (agregado por producto)
        $query = DB::table('producto_almacen')
            ->join('producto', 'producto_almacen.producto_id', '=', 'producto.id')
            ->leftJoin('categoria', 'producto.categoria_id', '=', 'categoria.id')
            ->leftJoin('unidad_medida', 'producto.unidad_medida_id', '=', 'unidad_medida.id')
            ->leftJoin('almacen', 'producto_almacen.almacen_id', '=', 'almacen.id')
            // costo y lote provienen del detalle de compra
            ->leftJoin('producto_compra', 'producto_almacen.producto_compra_id', '=', 'producto_compra.id')
            ->where('producto_almacen.empresa_id', $empresaId)
            ->where('producto_almacen.estado', 1)
            // Solo inventariables (ajusta si tu flag es distinto)
            ->where(function ($w) {
                $w->whereNull('producto.inventariable')->orWhere('producto.inventariable', 1);
            })
            ->select([
                'producto_almacen.producto_id',
                'producto.codigo  as producto_codigo',
                'producto.nombre  as producto_nombre',
                'producto.marca   as producto_marca',
                'producto.modelo  as producto_modelo',
                'categoria.nombre as categoria_nombre',
                'unidad_medida.nombre as unidad_nombre',

                // Agregados clave:
                DB::raw('SUM(producto_almacen.stock) AS total_stock'),
                DB::raw('COUNT(DISTINCT CONCAT(COALESCE(producto_almacen.lote,""), "#", COALESCE(producto_almacen.id_lote,""))) AS total_lotes'),

                // Valor a costo (si no hay producto_compra_id, toma 0)
                DB::raw('SUM(producto_almacen.stock * COALESCE(producto_compra.costo_unitario, 0)) AS valor_total'),

                // Costo promedio ponderado (seguro ante división por cero)
                DB::raw('IFNULL(ROUND(SUM(producto_almacen.stock * COALESCE(producto_compra.costo_unitario,0)) / NULLIF(SUM(producto_almacen.stock),0), 6), 0) AS costo_promedio_ponderado'),
            ])
            ->groupBy([
                'producto_almacen.producto_id',
                'producto.codigo',
                'producto.nombre',
                'producto.marca',
                'producto.modelo',
                'categoria.nombre',
                'unidad_medida.nombre',
            ]);

        // 3) Filtros
        if ($request->filled('categoria_id')) {
            $query->where('producto.categoria_id', $request->categoria_id);
        }
        if ($request->filled('almacen_id')) {
            $query->where('producto_almacen.almacen_id', $request->almacen_id);
        }
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('producto.codigo', 'like', "%{$s}%")
                ->orWhere('producto.nombre', 'like', "%{$s}%")
                ->orWhere('producto.marca', 'like', "%{$s}%")
                ->orWhere('producto.modelo', 'like', "%{$s}%");
            });
        }

        // 4) Paginación
        $inventario = $query->orderBy('producto.nombre')->paginate(25)->withQueryString();

        // 5) Totales generales sobre TODO el conjunto (no solo la página)
        $forTotals = clone $query;
        $totColec = $forTotals->get();

        $totales = [
            'total_productos'          => $totColec->count(),
            'stock_total_unidades'     => (float) $totColec->sum('total_stock'),
            'total_lotes'              => (int)   $totColec->sum('total_lotes'),
            'valor_total_inventario'   => (float) $totColec->sum('valor_total'),
            'costo_promedio_global'    => (float) round(
                ($totColec->sum('valor_total')) / max(1, $totColec->sum('total_stock')),
                6
            ),
            'productos_bajo_o_cero'    => $totColec->where('total_stock', '<=', 0)->count(),
        ];

        // 6) Filtros (catalogos)
        $almacenes = Almacen::query()
            ->where('estado', 1)
            // si tu relación empresa es via sucursal, ajusta este where:
            ->whereHas('sucursal', function ($q) use ($empresaId) {
                $q->where('empresa_id', $empresaId);
            })
            ->orderBy('nombre')
            ->get(['id','nombre']);

        $categorias = DB::table('categoria')
            ->where('id_empresa', $empresaId)
            ->where('estado', 1)
            ->orderBy('nombre')
            ->get(['id','nombre']);

        return view('inventario.reporte', compact('inventario', 'totales', 'almacenes', 'categorias'));
    }
    public function lotesPorProducto(Request $request, int $productoId)
    {
        $empresaId = auth()->User()->empresa_id ?? $request->integer('empresa_id');
        if (!$empresaId) abort(400, 'Falta empresa_id.');

        $lotes = DB::table('producto_almacen')
            ->join('producto', 'producto_almacen.producto_id', '=', 'producto.id')
            ->leftJoin('almacen', 'producto_almacen.almacen_id', '=', 'almacen.id')
            ->leftJoin('producto_compra', 'producto_almacen.producto_compra_id', '=', 'producto_compra.id')
            ->where('producto_almacen.empresa_id', $empresaId)
            ->where('producto_almacen.producto_id', $productoId)
            ->where('producto_almacen.estado', 1)
            ->select([
                'producto_almacen.id',
                'producto_almacen.lote',
                'producto_almacen.id_lote',
                'producto_almacen.stock',
                'almacen.nombre as almacen_nombre',
                'producto_compra.costo_unitario',
                DB::raw('ROUND(producto_almacen.stock * COALESCE(producto_compra.costo_unitario,0), 6) AS valor_parcial'),
                'producto.nombre as producto_nombre',
                'producto.codigo as producto_codigo',
            ])
            ->orderBy('almacen.nombre')
            ->orderBy('producto_almacen.lote')
            ->get();

        $totales = [
            'stock_total' => (float) $lotes->sum('stock'),
            'valor_total' => (float) $lotes->sum('valor_parcial'),
            'lotes'       => (int) $lotes->count(),
        ];

        return view('inventario.partials.lotes_producto', compact('lotes', 'totales'));
    }

}