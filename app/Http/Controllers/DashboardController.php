<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    // === MAPEA A TU BD REAL (ajusta si tu esquema difiere) ===
    private string $VENTA_TABLE = 'venta';
    private string $VENTA_ID    = 'id';
    private string $VENTA_EMP   = 'empresa_id';
    private string $VENTA_FECHA = 'fecha';
    private string $VENTA_FREG  = 'created_at'; // si tienes campo fecha_registro o similar, úsalo para análisis por hora
    private string $VENTA_TOTAL = 'total';
    private string $VENTA_ALM   = 'almacen_id';
    private string $VENTA_USER  = 'usuario_id';
    private string $VENTA_EST   = 'estado';
    private array $VENTA_ESTADOS_ACTIVOS = ['Registrado', 'Pagado', 'Pendiente'];


    private function applyEstado($q, ?string $alias = null)
    {
        if (Schema::hasColumn($this->VENTA_TABLE, $this->VENTA_EST)) {
            $col = $alias ? ($alias.'.'.$this->VENTA_EST) : $this->VENTA_EST;
            $q->whereIn($col, $this->VENTA_ESTADOS_ACTIVOS);
        }
        return $q;
    }

    private function fechaHoraColumn(): string
    {
        if (Schema::hasColumn($this->VENTA_TABLE, $this->VENTA_FREG)) {
            return $this->VENTA_FREG;
        }
        return $this->VENTA_FECHA;
    }

    public function index()
    {
        return view('dashboard.dashboard');
    }

    public function diario(Request $request)
    {
        $fecha = ($request->date('fecha')?->toDateString()) ?? now()->toDateString();
        $empresaId = $request->integer('empresa_id') ?: (auth()->user()->id_empresa ?? null);
        if (!$empresaId) return response()->json(['ok'=>false,'msg'=>'empresa_id requerido'], 422);

        $almacenId = $request->integer('almacen_id');
        $usuarioId = $request->integer('usuario_id');

        // Ventas del día (resumen)
        $ventasQ = DB::table($this->VENTA_TABLE)
            ->whereDate($this->VENTA_FECHA, $fecha)
            ->where($this->VENTA_EMP, $empresaId);

        if ($almacenId) $ventasQ->where($this->VENTA_ALM, $almacenId);
        if ($usuarioId) $ventasQ->where($this->VENTA_USER, $usuarioId);
        $this->applyEstado($ventasQ);

        $ventas = $ventasQ->get();

        $ventasBrutas = (float) $ventas->sum($this->VENTA_TOTAL);
        $descuentos   = 0; // si tienes campo descuento, súmalo aquí
        $ventasNetas  = $ventasBrutas - $descuentos;

        // COGS (si tus tablas existen)
        $cogs = 0.0;
        if (Schema::hasTable('detalle_venta_lote')) {
            $cogsQ = DB::table('detalle_venta_lote as dvl')
                ->join('detalle_venta as dv', 'dv.id', '=', 'dvl.detalle_venta_id')
                ->join($this->VENTA_TABLE.' as v', 'v.'.$this->VENTA_ID, '=', 'dv.venta_id')
                ->whereDate('v.'.$this->VENTA_FECHA, $fecha)
                ->where('v.'.$this->VENTA_EMP, $empresaId);

            if ($almacenId) $cogsQ->where('v.'.$this->VENTA_ALM, $almacenId);
            if ($usuarioId) $cogsQ->where('v.'.$this->VENTA_USER, $usuarioId);
            $this->applyEstado($cogsQ, 'v');

            $cogs = (float) $cogsQ->sum('dvl.costo_total');
        }

        $utilidadBruta  = $ventasNetas - $cogs;
        $tickets        = $ventas->count();
        $ticketPromedio = $tickets ? $ventasNetas / $tickets : 0;

        // ✅ SERIE POR HORA (para tu gananciasChart que usa horas)
        // usa FECHA_REGISTRO para agrupar
        $fechaHoraCol = $this->fechaHoraColumn();
        $horaQ = DB::table($this->VENTA_TABLE)
            ->selectRaw('HOUR('.$fechaHoraCol.') as h, SUM('.$this->VENTA_TOTAL.') as total, COUNT(*) as cantidad')
            ->whereDate($this->VENTA_FECHA, $fecha)
            ->where($this->VENTA_EMP, $empresaId)
            ->when($almacenId, fn($q)=>$q->where($this->VENTA_ALM, $almacenId))
            ->when($usuarioId, fn($q)=>$q->where($this->VENTA_USER, $usuarioId))
            ->groupBy('h')
            ->orderBy('h');
        $this->applyEstado($horaQ);
        $horaRows = $horaQ->get()->keyBy('h');

        $hourLabels = [];
        $hourSeries = [];
        // si quieres: 6,9,12,15,18,21,24 como tu mock
        foreach ([6,9,12,15,18,21,23] as $h) {
            $hourLabels[] = sprintf('%02d:00', $h);
            $row = $horaRows->get($h);
            $hourSeries[] = (float) ($row->total ?? 0);
        }

        // Top productos (ya lo tenías)
        $topProductosQ = DB::table('detalle_venta as dv')
            ->join($this->VENTA_TABLE.' as v', 'v.'.$this->VENTA_ID, '=', 'dv.venta_id')
            ->join('producto as p', 'p.id', '=', 'dv.producto_id')
            ->whereDate('v.'.$this->VENTA_FECHA, $fecha)
            ->where('v.'.$this->VENTA_EMP, $empresaId)
            ->when($almacenId, fn($q)=>$q->where('v.'.$this->VENTA_ALM, $almacenId))
            ->when($usuarioId, fn($q)=>$q->where('v.'.$this->VENTA_USER, $usuarioId))
            ->groupBy('p.id','p.nombre')
            ->selectRaw('p.id, p.nombre, SUM(dv.cantidad) as cantidad, SUM(dv.subtotal) as ventas')
            ->orderByDesc('ventas')
            ->limit(10);
        $this->applyEstado($topProductosQ, 'v');
        $topProductos = $topProductosQ->get();

        return response()->json([
            'ok' => true,
            'fecha' => $fecha,
            'resumen' => [
                'ventas_brutas'   => round($ventasBrutas, 2),
                'descuentos'      => round($descuentos, 2),
                'ventas_netas'    => round($ventasNetas, 2),
                'cogs'            => round($cogs, 2),
                'utilidad_bruta'  => round($utilidadBruta, 2),
                'tickets'         => $tickets,
                'ticket_promedio' => round($ticketPromedio, 2),
            ],
            'serie_horas' => [
                'labels' => $hourLabels,
                'data'   => $hourSeries,
            ],
            'top_productos' => $topProductos,
        ]);
    }

    public function mensual(Request $request)
    {
        $empresaId = $request->integer('empresa_id') ?: (auth()->user()->id_empresa ?? null);
        if (!$empresaId) return response()->json(['ok'=>false,'msg'=>'empresa_id requerido'], 422);

        $ym = $request->input('mes', now()->format('Y-m'));
        if (!preg_match('/^\d{4}\-\d{2}$/', $ym)) {
            return response()->json(['ok'=>false,'msg'=>'Parámetro mes inválido (YYYY-MM)'], 422);
        }

        [$year, $month] = explode('-', $ym);
        $start = sprintf('%04d-%02d-01', (int)$year, (int)$month);
        $end   = date('Y-m-t', strtotime($start));

        $almacenId = $request->integer('almacen_id');
        $usuarioId = $request->integer('usuario_id');

        $ventasQ = DB::table($this->VENTA_TABLE)
            ->whereBetween($this->VENTA_FECHA, [$start, $end])
            ->where($this->VENTA_EMP, $empresaId);

        if ($almacenId) $ventasQ->where($this->VENTA_ALM, $almacenId);
        if ($usuarioId) $ventasQ->where($this->VENTA_USER, $usuarioId);
        $this->applyEstado($ventasQ);

        $ventas = $ventasQ->get();

        $ventasBrutas = (float) $ventas->sum($this->VENTA_TOTAL);
        $descuentos   = 0;
        $ventasNetas  = $ventasBrutas - $descuentos;

        $cogs = 0.0;
        if (Schema::hasTable('detalle_venta_lote')) {
            $cogsQ = DB::table('detalle_venta_lote as dvl')
                ->join('detalle_venta as dv', 'dv.id', '=', 'dvl.detalle_venta_id')
                ->join($this->VENTA_TABLE.' as v', 'v.'.$this->VENTA_ID, '=', 'dv.venta_id')
                ->whereBetween('v.'.$this->VENTA_FECHA, [$start, $end])
                ->where('v.'.$this->VENTA_EMP, $empresaId);

            if ($almacenId) $cogsQ->where('v.'.$this->VENTA_ALM, $almacenId);
            if ($usuarioId) $cogsQ->where('v.'.$this->VENTA_USER, $usuarioId);
            $this->applyEstado($cogsQ, 'v');

            $cogs = (float) $cogsQ->sum('dvl.costo_total');
        }

        $utilidadBruta  = $ventasNetas - $cogs;
        $tickets        = $ventas->count();
        $ticketPromedio = $tickets ? ($ventasNetas / $tickets) : 0;

        // Serie por día
        $serieQ = DB::table($this->VENTA_TABLE.' as v')
            ->leftJoin('detalle_venta as dv', 'dv.venta_id', '=', 'v.'.$this->VENTA_ID)
            ->leftJoin('detalle_venta_lote as dvl', 'dvl.detalle_venta_id', '=', 'dv.id')
            ->whereBetween('v.'.$this->VENTA_FECHA, [$start, $end])
            ->where('v.'.$this->VENTA_EMP, $empresaId)
            ->when($almacenId, fn($q)=>$q->where('v.'.$this->VENTA_ALM, $almacenId))
            ->when($usuarioId, fn($q)=>$q->where('v.'.$this->VENTA_USER, $usuarioId))
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->selectRaw('DATE(v.'.$this->VENTA_FECHA.') as fecha, SUM(v.'.$this->VENTA_TOTAL.') as ventas, COALESCE(SUM(dvl.costo_total),0) as cogs');
        $this->applyEstado($serieQ, 'v');
        $serie = $serieQ->get()
            ->map(function($r){
                $r->ventas   = (float)$r->ventas;
                $r->cogs     = (float)$r->cogs;
                $r->utilidad = $r->ventas - $r->cogs;
                return $r;
            });

        return response()->json([
            'ok' => true,
            'periodo' => ['mes'=>$ym,'inicio'=>$start,'fin'=>$end],
            'resumen' => [
                'ventas_brutas'   => round($ventasBrutas, 2),
                'descuentos'      => round($descuentos, 2),
                'ventas_netas'    => round($ventasNetas, 2),
                'cogs'            => round($cogs, 2),
                'utilidad_bruta'  => round($utilidadBruta, 2),
                'tickets'         => $tickets,
                'ticket_promedio' => round($ticketPromedio, 2),
            ],
            'serie_dias' => $serie,
        ]);
    }

    public function categoriasMensual(Request $request)
    {
        $empresaId = $request->integer('empresa_id') ?: (auth()->user()->id_empresa ?? null);
        if (!$empresaId) return response()->json(['ok'=>false,'msg'=>'empresa_id requerido'], 422);

        $ym = $request->input('mes', now()->format('Y-m'));
        [$year, $month] = explode('-', $ym);
        $start = sprintf('%04d-%02d-01', (int)$year, (int)$month);
        $end   = date('Y-m-t', strtotime($start));

        $rowsQ = DB::table('detalle_venta as dv')
            ->join($this->VENTA_TABLE.' as v', 'v.'.$this->VENTA_ID, '=', 'dv.venta_id')
            ->join('producto as p', 'p.id', '=', 'dv.producto_id')
            ->leftJoin('categoria as c', 'c.id', '=', 'p.categoria_id')
            ->whereBetween('v.'.$this->VENTA_FECHA, [$start, $end])
            ->where('v.'.$this->VENTA_EMP, $empresaId)
            ->groupBy('c.id','c.nombre')
            ->selectRaw('COALESCE(c.nombre, "Sin categoría") as categoria, SUM(dv.subtotal) as total')
            ->orderByDesc('total')
            ->limit(8);
        $this->applyEstado($rowsQ, 'v');
        $rows = $rowsQ->get();

        $labels = $rows->pluck('categoria')->toArray();
        $data   = $rows->pluck('total')->map(fn($x)=>(float)$x)->toArray();

        if (!$labels) { $labels = ['Sin datos']; $data = [1]; }

        return response()->json(['ok'=>true,'labels'=>$labels,'data'=>$data]);
    }

    public function historico12Meses(Request $request)
    {
        $empresaId = $request->integer('empresa_id') ?: (auth()->user()->id_empresa ?? null);
        if (!$empresaId) return response()->json(['ok'=>false,'msg'=>'empresa_id requerido'], 422);

        $to = now()->startOfMonth();
        $from = $to->copy()->subMonths(11);

        $rowsQ = DB::table($this->VENTA_TABLE)
            ->selectRaw('DATE_FORMAT('.$this->VENTA_FECHA.', "%Y-%m") as ym, SUM('.$this->VENTA_TOTAL.') as total')
            ->whereBetween($this->VENTA_FECHA, [$from->toDateString(), $to->copy()->endOfMonth()->toDateString()])
            ->where($this->VENTA_EMP, $empresaId)
            ->groupBy('ym')
            ;
        $this->applyEstado($rowsQ);
        $rows = $rowsQ->pluck('total', 'ym');

        $labels = [];
        $data = [];

        for ($i=11; $i>=0; $i--) {
            $m = now()->copy()->subMonths($i)->startOfMonth();
            $key = $m->format('Y-m');
            $labels[] = $m->format('M');
            $data[] = (float) ($rows[$key] ?? 0);
        }

        return response()->json(['ok'=>true,'labels'=>$labels,'data'=>$data]);
    }

    public function topVendedoresMensual(Request $request)
    {
        $empresaId = $request->integer('empresa_id') ?: (auth()->user()->id_empresa ?? null);
        if (!$empresaId) return response()->json(['ok'=>false,'msg'=>'empresa_id requerido'], 422);

        $ym = $request->input('mes', now()->format('Y-m'));
        [$year, $month] = explode('-', $ym);
        $start = sprintf('%04d-%02d-01', (int)$year, (int)$month);
        $end   = date('Y-m-t', strtotime($start));

        // Ajusta tabla/fields de usuarios a tu sistema (users / usuario / etc.)
        // Si no tienes tabla usuarios, igual sirve devolviendo solo ID.
        $rowsQ = DB::table($this->VENTA_TABLE.' as v')
            ->leftJoin('users as u', 'u.id', '=', 'v.'.$this->VENTA_USER) // cambia si tu tabla es otra
            ->whereBetween('v.'.$this->VENTA_FECHA, [$start, $end])
            ->where('v.'.$this->VENTA_EMP, $empresaId)
            ->groupBy('v.'.$this->VENTA_USER, 'u.name')
            ->selectRaw('v.'.$this->VENTA_USER.' as id, COALESCE(u.name, CONCAT("Vendedor #", v.'.$this->VENTA_USER.')) as nombre, SUM(v.'.$this->VENTA_TOTAL.') as ventas, COUNT(*) as tickets')
            ->orderByDesc('ventas')
            ->limit(5);
        $this->applyEstado($rowsQ, 'v');
        $rows = $rowsQ->get()
            ->map(function($r){
                $r->ventas = (float)$r->ventas;
                return $r;
            });

        // meta ejemplo: promedio del top o fijo
        $meta = $request->float('meta') ?: 100000;

        return response()->json(['ok'=>true,'meta'=>$meta,'data'=>$rows]);
    }

    public function ventasUltimos5Dias(Request $request)
    {
        $empresaId = $request->integer('empresa_id') ?: (auth()->user()->id_empresa ?? null);
        if (!$empresaId) return response()->json(['ok'=>false,'msg'=>'empresa_id requerido'], 422);

        $labels = [];
        $data = [];

        for ($i = 4; $i >= 0; $i--) {
            $fecha = now()->subDays($i)->toDateString();
            $q = DB::table($this->VENTA_TABLE)
                ->whereDate($this->VENTA_FECHA, $fecha)
                ->where($this->VENTA_EMP, $empresaId);
            $this->applyEstado($q);

            $labels[] = now()->subDays($i)->format('d/m');
            $data[] = round((float) $q->sum($this->VENTA_TOTAL), 2);
        }

        return response()->json(['ok'=>true, 'labels'=>$labels, 'data'=>$data]);
    }
}
