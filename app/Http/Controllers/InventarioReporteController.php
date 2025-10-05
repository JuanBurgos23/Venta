<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class InventarioReporteController extends Controller
{
    Public function index()
    {
        return view('inventario.reporte'); // ajusta si tu archivo Blade está en otra carpeta
    }
    public function reporte(Request $request)
    {
        $empresaId  = $request->integer('empresa_id') ?: (auth()->user()->id_empresa ?? null);
        if (!$empresaId) {
            return response()->json(['ok'=>false, 'msg'=>'empresa_id requerido'], 422);
        }

        $categoria = trim((string)$request->get('categoria', ''));
        $search    = trim((string)$request->get('search', ''));
        $estado    = trim((string)$request->get('estado', '')); // Disponible | Agotado

        $q = DB::table('producto')
            ->leftJoin('categoria', 'categoria.id', '=', 'producto.categoria_id')
            ->leftJoin('producto_almacen as pa', function($j){
                $j->on('pa.producto_id', '=', 'producto.id')
                  ->where('pa.estado', '=', 1);
            })
            ->where('producto.id_empresa', $empresaId)
            ->groupBy(
                'producto.id',
                'producto.codigo',
                'producto.nombre',
                'producto.precio',
                'producto.estado',
                'producto.categoria_id',
                'categoria.nombre'
            )
            ->selectRaw("
                producto.id,
                producto.codigo,
                producto.nombre,
                producto.precio,
                producto.estado as estado_producto,
                producto.categoria_id,
                categoria.nombre as categoria_nombre,
                COALESCE(SUM(pa.stock), 0) as stock_total,
                COALESCE(SUM(pa.stock), 0) * producto.precio as valor_total
            ");

        // Filtros
        if ($categoria !== '') {
            $q->whereRaw('LOWER(categoria.nombre) = ?', [mb_strtolower($categoria)]);
        }
        if ($search !== '') {
            $s = "%{$search}%";
            $q->where(function($w) use ($s){
                $w->where('producto.codigo', 'like', $s)
                  ->orWhere('producto.nombre', 'like', $s)
                  ->orWhere('categoria.nombre', 'like', $s);
            });
        }

        $rows = $q->get();

        // Estado solo por stock_total
        $rows = $rows->map(function($r){
            $r->estado_stock = ($r->stock_total > 0) ? 'Disponible' : 'Agotado';
            return $r;
        });

        // Filtro por estado (si viene)
        if ($estado !== '') {
            $rows = $rows->where('estado_stock', $estado)->values();
        }

        return response()->json([
            'ok'   => true,
            'data' => $rows,
            'meta' => [
                'empresa_id'   => $empresaId,
                'total_items'  => $rows->count()
            ]
        ]);
    }

    public function lotes($productoId, Request $request)
    {
        $empresaId  = $request->integer('empresa_id') ?: (auth()->user()->id_empresa ?? null);
        if (!$empresaId) {
            return response()->json(['ok'=>false, 'msg'=>'empresa_id requerido'], 422);
        }

        $lotes = DB::table('producto_almacen as pa')
            ->leftJoin('almacen', 'almacen.id', '=', 'pa.almacen_id')
            ->where('pa.empresa_id', $empresaId)
            ->where('pa.producto_id', $productoId)
            ->where('pa.estado', 1)
            ->select([
                'pa.id',
                'pa.lote',
                'pa.stock',
                'almacen.nombre as almacen',
            ])
            ->orderByDesc('pa.id')
            ->get();

        return response()->json([
            'ok'   => true,
            'data' => $lotes
        ]);
    }
}