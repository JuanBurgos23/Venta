<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\Producto_compra;
use App\Models\Producto_almacen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CompraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('compra.compra');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Aceptamos proveedor_id o id_proveedor
        $proveedorId = $request->input('proveedor_id') ?? $request->input('id_proveedor');

        $validated = $request->validate([
            'almacen_id'        => ['required','exists:almacen,id'],
            'sucursal_id'       => ['nullable','exists:sucursal,id'],

            'proveedor_id'      => ['nullable','exists:proveedor,id'],
            'id_proveedor'      => ['nullable','exists:proveedor,id'],

            'fecha_esperada'    => ['nullable','date'],
            'observacion'       => ['nullable','string','max:500'],

            'items'                         => ['required','array','min:1'],
            'items.*.producto_id'           => ['required','exists:producto,id'],
            'items.*.cantidad'              => ['required','numeric','min:0.0001'],
            'items.*.costo_unitario'        => ['required','numeric','min:0'],
            'items.*.lote'                  => ['nullable','string','max:255'],
            'items.*.id_lote'               => ['nullable','string','max:50'],
            'items.*.fecha_vencimiento'     => ['nullable','date'],
        ]);

        if (!$proveedorId) {
            return response()->json(['status'=>'error','message'=>'El proveedor es requerido'], 422);
        }

        $empresaId = Auth::user()->id_empresa ?? null;
        $usuarioId = Auth::id();
        if (!$empresaId) {
            return response()->json(['status'=>'error','message'=>'No se pudo determinar la empresa del usuario'], 422);
        }

        // Totales
        $subtotal = 0;
        foreach ($validated['items'] as $it) {
            $subtotal += (float)$it['cantidad'] * (float)$it['costo_unitario'];
        }
        $descuento = 0;
        $total     = $subtotal - $descuento;

        // Ejecuta TODO dentro de la transacción y DEVUELVE el modelo $compra
        $compra = DB::transaction(function() use ($validated, $empresaId, $usuarioId, $proveedorId, $subtotal, $descuento, $total) {

            // 1) Compra (cabecera)
            $compra = Compra::create([
                'id_empresa'    => $empresaId,
                'sucursal_id'   => $validated['sucursal_id'] ?? null,
                'almacen_id'    => $validated['almacen_id'],
                'proveedor_id'  => $proveedorId,
                'fecha_ingreso' => now(),
                'tipo'          => 'OC',
                'subtotal'      => $subtotal,
                'descuento'     => $descuento,
                'total'         => $total,
                'estado'        => 1,
                'observacion'   => $validated['observacion'] ?? null,
                'recepcion'     => $validated['fecha_esperada'] ?? null,
                'usuario_id'    => $usuarioId,
            ]);

            // 2) Detalle + Ingreso a inventario POR LOTE (SIEMPRE INSERT)
            foreach ($validated['items'] as $it) {
                $cant      = (float)$it['cantidad'];
                $costoUnit = (float)$it['costo_unitario'];

                $det = Producto_compra::create([
                    'producto_id'       => $it['producto_id'],
                    'compra_id'         => $compra->id,
                    'empresa_id'        => $empresaId,
                    // ¡OJO!: ya quitaste proveedor_id de producto_compra
                    'lote'              => $it['lote'] ?? null,
                    'fecha_vencimiento' => $it['fecha_vencimiento'] ?? null,
                    'cantidad'          => $cant,
                    'costo_unitario'    => $costoUnit,
                    'costo_total'       => $cant * $costoUnit,
                ]);

                // Inserta SIEMPRE una fila por lote en producto_almacen
                Producto_almacen::create([
                    'producto_id'        => $it['producto_id'],
                    'almacen_id'         => $validated['almacen_id'],
                    'empresa_id'         => $empresaId,

                    // nuevo control de lote en esta tabla
                    'id_lote'            => $it['id_lote'] ?? null, // alfanumérico del cliente
                    'lote'               => $it['lote'] ?? null,    // texto mostrado

                    // referencia al detalle (útil para trazabilidad/egresos FIFO)
                    'producto_compra_id' => $det->id,

                    'stock'              => $cant,
                    'estado'             => 1,
                ]);
            }

            return $compra; // <- ¡muy importante!
        });

        // Fuera de la transacción ya tienes $compra válido
        return response()->json([
            'status'  => 'success',
            'message' => 'Compra registrada correctamente',
            'compra'  => [
                'id'        => $compra->id,
                'subtotal'  => $subtotal,
                'descuento' => $descuento,
                'total'     => $total,
            ]
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Compra $compra)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Compra $compra)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Compra $compra)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Compra $compra)
    {
        //
    }
}
