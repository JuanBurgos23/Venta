<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class FinanzasController extends Controller
{
    public function diario(Request $request)
    {
        $fecha = $request->date('fecha') ?? now()->toDateString();
        $empresaId = $request->integer('empresa_id') ?: (auth()->user()->id_empresa ?? null);
        if (!$empresaId) {
            return response()->json(['ok'=>false,'msg'=>'empresa_id requerido'], 422);
        }

        $almacenId = $request->integer('almacen_id');
        $usuarioId = $request->integer('usuario_id');

        // Ventas del día
        $ventasQ = DB::table('venta')
            ->whereDate('fecha', $fecha)
            ->where('empresa_id', $empresaId);

        if ($almacenId) $ventasQ->where('almacen_id', $almacenId);
        if ($usuarioId) $ventasQ->where('usuario_id', $usuarioId);

        $ventas = $ventasQ->get();

        $ventasBrutas = $ventas->sum('total');       // si tu 'total' ya es neto de descuento, ajusta
        $descuentos  = 0;                            // si guardas descuentos por venta, súmalos aquí
        $ventasNetas = $ventasBrutas - $descuentos;

        // COGS del día = suma de costo_total de los lotes consumidos en detalles de ventas del día
        $cogsQ = DB::table('detalle_venta_lote as dvl')
            ->join('detalle_venta as dv', 'dv.id', '=', 'dvl.detalle_venta_id')
            ->join('venta as v', 'v.id', '=', 'dv.venta_id')
            ->whereDate('v.fecha', $fecha)
            ->where('v.empresa_id', $empresaId);

        if ($almacenId) $cogsQ->where('v.almacen_id', $almacenId);
        if ($usuarioId) $cogsQ->where('v.usuario_id', $usuarioId);

        $cogs = (float) $cogsQ->sum('dvl.costo_total');

        $utilidadBruta = $ventasNetas - $cogs;

        // KPIs útiles
        $tickets = $ventas->count();
        $ticketPromedio = $tickets ? $ventasNetas / $tickets : 0;

        // TOP productos (por utilidad / por venta) – ejemplo por cantidad y ventas
        $topProductos = DB::table('detalle_venta as dv')
            ->join('venta as v', 'v.id', '=', 'dv.venta_id')
            ->join('producto as p', 'p.id', '=', 'dv.producto_id')
            ->whereDate('v.fecha', $fecha)
            ->where('v.empresa_id', $empresaId)
            ->when($almacenId, fn($q)=>$q->where('v.almacen_id', $almacenId))
            ->when($usuarioId, fn($q)=>$q->where('v.usuario_id', $usuarioId))
            ->groupBy('p.id','p.nombre')
            ->selectRaw('p.id, p.nombre, SUM(dv.cantidad) as cantidad, SUM(dv.subtotal) as ventas')
            ->orderByDesc('ventas')
            ->limit(10)
            ->get();

        return response()->json([
            'ok' => true,
            'fecha' => $fecha,
            'resumen' => [
                'ventas_brutas'  => round($ventasBrutas, 2),
                'descuentos'     => round($descuentos, 2),
                'ventas_netas'   => round($ventasNetas, 2),
                'cogs'           => round($cogs, 2),
                'utilidad_bruta' => round($utilidadBruta, 2),
                'tickets'        => $tickets,
                'ticket_promedio'=> round($ticketPromedio, 2),
            ],
            'top_productos' => $topProductos
        ]);
    }

    public function mensual(Request $request)
    {
        $empresaId = $request->integer('empresa_id') ?: (auth()->user()->id_empresa ?? null);
        if (!$empresaId) {
            return response()->json(['ok'=>false,'msg'=>'empresa_id requerido'], 422);
        }

        // HTML <input type="month"> envía "YYYY-MM"
        $ym = $request->input('mes', now()->format('Y-m')); // ej: 2025-10
        if (!preg_match('/^\d{4}\-\d{2}$/', $ym)) {
            return response()->json(['ok'=>false,'msg'=>'Parámetro mes inválido (YYYY-MM)'], 422);
        }

        [$year, $month] = explode('-', $ym);
        $start = sprintf('%04d-%02d-01', (int)$year, (int)$month);
        $end   = date('Y-m-t', strtotime($start)); // fin de mes

        $almacenId = $request->integer('almacen_id');
        $usuarioId = $request->integer('usuario_id');

        // === Ventas del rango ===
        $ventasQ = DB::table('venta')
            ->whereBetween('fecha', [$start, $end])
            ->where('empresa_id', $empresaId);

        if ($almacenId) $ventasQ->where('almacen_id', $almacenId);
        if ($usuarioId) $ventasQ->where('usuario_id', $usuarioId);

        $ventas = $ventasQ->get();

        $ventasBrutas = (float) $ventas->sum('total');
        $descuentos   = 0; // ajusta si registras descuentos por venta
        $ventasNetas  = $ventasBrutas - $descuentos;

        // === COGS del rango (detalle_venta_lote) ===
        $cogsQ = DB::table('detalle_venta_lote as dvl')
            ->join('detalle_venta as dv', 'dv.id', '=', 'dvl.detalle_venta_id')
            ->join('venta as v', 'v.id', '=', 'dv.venta_id')
            ->whereBetween('v.fecha', [$start, $end])
            ->where('v.empresa_id', $empresaId);

        if ($almacenId) $cogsQ->where('v.almacen_id', $almacenId);
        if ($usuarioId) $cogsQ->where('v.usuario_id', $usuarioId);

        $cogs = (float) $cogsQ->sum('dvl.costo_total');

        $utilidadBruta = $ventasNetas - $cogs;

        // KPIs
        $tickets = $ventas->count();
        $ticketPromedio = $tickets ? ($ventasNetas / $tickets) : 0;

        // Serie por día (ventas / cogs / utilidad)
        $serie = DB::table('venta as v')
            ->leftJoin('detalle_venta as dv', 'dv.venta_id', '=', 'v.id')
            ->leftJoin('detalle_venta_lote as dvl', 'dvl.detalle_venta_id', '=', 'dv.id')
            ->whereBetween('v.fecha', [$start, $end])
            ->where('v.empresa_id', $empresaId)
            ->when($almacenId, fn($q)=>$q->where('v.almacen_id', $almacenId))
            ->when($usuarioId, fn($q)=>$q->where('v.usuario_id', $usuarioId))
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->selectRaw('DATE(v.fecha) as fecha, SUM(v.total) as ventas, COALESCE(SUM(dvl.costo_total),0) as cogs')
            ->get()
            ->map(function($r){
                $r->ventas   = (float)$r->ventas;
                $r->cogs     = (float)$r->cogs;
                $r->utilidad = $r->ventas - $r->cogs;
                return $r;
            });

        // Top productos del mes
        $topProductos = DB::table('detalle_venta as dv')
            ->join('venta as v', 'v.id', '=', 'dv.venta_id')
            ->join('producto as p', 'p.id', '=', 'dv.producto_id')
            ->whereBetween('v.fecha', [$start, $end])
            ->where('v.empresa_id', $empresaId)
            ->when($almacenId, fn($q)=>$q->where('v.almacen_id', $almacenId))
            ->when($usuarioId, fn($q)=>$q->where('v.usuario_id', $usuarioId))
            ->groupBy('p.id','p.nombre')
            ->selectRaw('p.id, p.nombre, SUM(dv.cantidad) as cantidad, SUM(dv.subtotal) as ventas')
            ->orderByDesc('ventas')
            ->limit(10)
            ->get();

        return response()->json([
            'ok' => true,
            'periodo' => [
                'mes' => $ym,
                'inicio' => $start,
                'fin' => $end
            ],
            'resumen' => [
                'ventas_brutas'   => round($ventasBrutas, 2),
                'descuentos'      => round($descuentos, 2),
                'ventas_netas'    => round($ventasNetas, 2),
                'cogs'            => round($cogs, 2),
                'utilidad_bruta'  => round($utilidadBruta, 2),
                'tickets'         => $tickets,
                'ticket_promedio' => round($ticketPromedio, 2),
            ],
            'serie_dias'    => $serie,
            'top_productos' => $topProductos,
        ]);
    }
    public function ventasPorProducto(Request $request)
    {
        $empresaId = $request->integer('empresa_id') ?: (auth()->user()->id_empresa ?? null);
        if (!$empresaId) {
            return response()->json(['ok'=>false,'msg'=>'empresa_id requerido'], 422);
        }

        // Filtros
        $from = $request->date('from') ?? now()->toDateString();
        $to   = $request->date('to')   ?? now()->toDateString();
        $productoId = $request->integer('producto_id');
        $qName      = trim((string)$request->get('q', ''));

        // Query principal: detalle de venta + costos por lote (COGS)
        $rows = DB::table('detalle_venta as dv')
            ->join('venta as v', 'v.id', '=', 'dv.venta_id')
            ->join('producto as p', 'p.id', '=', 'dv.producto_id')
            ->leftJoin('detalle_venta_lote as dvl', 'dvl.detalle_venta_id', '=', 'dv.id')
            ->where('v.empresa_id', $empresaId)
            ->whereBetween('v.fecha', [$from, $to])
            ->when($productoId, fn($q) => $q->where('p.id', $productoId))
            ->when($qName !== '', fn($q) => $q->where('p.nombre', 'like', "%{$qName}%"))
            ->groupBy('dv.id', 'p.nombre', 'dv.cantidad', 'dv.precio_unitario', 'dv.subtotal', 'v.fecha')
            ->orderBy('v.fecha', 'asc')
            ->selectRaw("
                dv.id,
                p.nombre as producto,
                v.fecha as fecha_venta,
                dv.cantidad,
                dv.precio_unitario,
                dv.subtotal        as precio_total,
                COALESCE(SUM(dvl.costo_total),0) as costo_total,
                COALESCE(SUM(dvl.cantidad),0)    as cogs_qty
            ")
            ->get()
            ->map(function($r){
                $avgCost = ($r->cogs_qty > 0) ? ($r->costo_total / $r->cogs_qty) : 0;
                $r->costo_unitario   = round($avgCost, 2);
                $r->utilidad_unit    = round(($r->precio_unitario - $r->costo_unitario), 2);
                $r->utilidad_total   = round(($r->precio_total - $r->costo_total), 2);

                // formateo numérico básico (si prefieres, hazlo en el front)
                $r->precio_unitario  = (float) $r->precio_unitario;
                $r->precio_total     = (float) $r->precio_total;
                $r->costo_total      = (float) $r->costo_total;
                $r->cantidad         = (float) $r->cantidad;
                return $r;
            });

        // Totales
        $totales = [
            'cantidad'      => round($rows->sum('cantidad'), 2),
            'precio_total'  => round($rows->sum('precio_total'), 2),
            'costo_total'   => round($rows->sum('costo_total'), 2),
            'utilidad_total'=> round($rows->sum('utilidad_total'), 2),
        ];

        return response()->json([
            'ok'     => true,
            'from'   => $from,
            'to'     => $to,
            'filtros'=> [
                'producto_id' => $productoId,
                'q' => $qName,
            ],
            'data'   => $rows,
            'totales'=> $totales,
        ]);
    }
}
