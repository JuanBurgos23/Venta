<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardControoler extends Controller
{
    public function index(){
        $user = auth()->user();
        $empresaId = $user->id_empresa ?? null;
        $dashboardData = [];

        if ($empresaId) {
            $now = now();

            $startDay = $now->copy()->subDays(6)->startOfDay();
            $endDay = $now->copy()->endOfDay();

            $dailyRows = DB::table('venta')
                ->selectRaw('DATE(fecha) as day, COUNT(*) as cantidad, SUM(total) as total')
                ->where('empresa_id', $empresaId)
                ->whereBetween('fecha', [$startDay, $endDay])
                ->groupBy('day')
                ->get()
                ->keyBy('day');

            $dayLabels = [];
            $orderSeries = [];
            $revenueSeries = [];

            foreach (range(6, 0) as $i) {
                $day = $now->copy()->subDays($i);
                $key = $day->format('Y-m-d');
                $row = $dailyRows->get($key);
                $orderSeries[] = (int) ($row->cantidad ?? 0);
                $revenueSeries[] = (float) ($row->total ?? 0);
                $dayLabels[] = $day->format('D');
            }

            $startMonth = $now->copy()->subMonths(6)->startOfMonth();
            $endMonth = $now->copy()->endOfMonth();

            $ventasMonthly = DB::table('venta')
                ->selectRaw('DATE_FORMAT(fecha, "%Y-%m") as ym, SUM(total) as total')
                ->where('empresa_id', $empresaId)
                ->whereBetween('fecha', [$startMonth, $endMonth])
                ->groupBy('ym')
                ->pluck('total', 'ym');

            $comprasMonthly = DB::table('compra')
                ->selectRaw('DATE_FORMAT(fecha_ingreso, "%Y-%m") as ym, SUM(total) as total')
                ->where('id_empresa', $empresaId)
                ->whereBetween('fecha_ingreso', [$startMonth, $endMonth])
                ->groupBy('ym')
                ->pluck('total', 'ym');

            $monthLabels = [];
            $ventasSeries = [];
            $comprasSeries = [];

            foreach (range(6, 0) as $i) {
                $month = $now->copy()->subMonths($i)->startOfMonth();
                $key = $month->format('Y-m');
                $monthLabels[] = $month->format('M');
                $ventasSeries[] = (float) ($ventasMonthly[$key] ?? 0);
                $comprasSeries[] = (float) ($comprasMonthly[$key] ?? 0);
            }

            $monthStart = $now->copy()->startOfMonth();
            $monthEnd = $now->copy()->endOfMonth();

            $currentMonthTotal = (float) DB::table('venta')
                ->where('empresa_id', $empresaId)
                ->whereBetween('fecha', [$monthStart, $monthEnd])
                ->sum('total');

            $prevMonthStart = $now->copy()->subMonth()->startOfMonth();
            $prevMonthEnd = $now->copy()->subMonth()->endOfMonth();
            $prevMonthTotal = (float) DB::table('venta')
                ->where('empresa_id', $empresaId)
                ->whereBetween('fecha', [$prevMonthStart, $prevMonthEnd])
                ->sum('total');

            $growthPercent = $prevMonthTotal > 0
                ? round(($currentMonthTotal / $prevMonthTotal) * 100)
                : ($currentMonthTotal > 0 ? 100 : 0);
            $growthPercent = max(0, min(100, $growthPercent));

            $profileSeries = [];
            foreach (range(5, 0) as $i) {
                $month = $now->copy()->subMonths($i)->startOfMonth();
                $key = $month->format('Y-m');
                $profileSeries[] = (float) ($ventasMonthly[$key] ?? 0);
            }

            $topCategories = DB::table('detalle_venta as dv')
                ->join('venta as v', 'v.id', '=', 'dv.venta_id')
                ->join('producto as p', 'p.id', '=', 'dv.producto_id')
                ->leftJoin('categoria as c', 'c.id', '=', 'p.categoria_id')
                ->where('v.empresa_id', $empresaId)
                ->whereBetween('v.fecha', [$monthStart, $monthEnd])
                ->groupBy('c.id', 'c.nombre')
                ->selectRaw('COALESCE(c.nombre, "Sin categoria") as nombre, SUM(dv.subtotal) as total')
                ->orderByDesc('total')
                ->limit(4)
                ->get();

            $categoryLabels = $topCategories->pluck('nombre')->map(function ($name) {
                return $name ?: 'Sin categoria';
            })->all();
            $categorySeries = $topCategories->pluck('total')->map(function ($total) {
                return (float) $total;
            })->all();

            if (empty($categoryLabels)) {
                $categoryLabels = ['Sin datos'];
                $categorySeries = [1];
            }

            $comprasWeekTotal = (float) DB::table('compra')
                ->where('id_empresa', $empresaId)
                ->whereBetween('fecha_ingreso', [$startDay, $endDay])
                ->sum('total');

            $dashboardData = [
                'orderChart' => [
                    'series' => [
                        ['data' => $orderSeries],
                    ],
                ],
                'totalRevenueChart' => [
                    'series' => [
                        ['name' => 'Ventas', 'data' => $ventasSeries],
                        ['name' => 'Compras', 'data' => $comprasSeries],
                    ],
                    'categories' => $monthLabels,
                ],
                'growthChart' => [
                    'series' => [$growthPercent],
                ],
                'revenueChart' => [
                    'series' => [
                        ['data' => $revenueSeries],
                    ],
                    'categories' => $dayLabels,
                ],
                'profileReportChart' => [
                    'series' => [
                        ['data' => $profileSeries],
                    ],
                ],
                'orderStatisticsChart' => [
                    'labels' => $categoryLabels,
                    'series' => $categorySeries,
                ],
                'incomeChart' => [
                    'series' => [
                        ['data' => $revenueSeries],
                    ],
                    'categories' => $dayLabels,
                ],
                'expensesOfWeek' => [
                    'series' => [$comprasWeekTotal],
                ],
            ];
        }

        return view('dashboard.dashboard', [
            'dashboardData' => $dashboardData,
        ]);
    }
}
