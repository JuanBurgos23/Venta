<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class detalle_venta_lote extends Model
{
    protected $table = 'detalle_venta_lote';
    protected $fillable = [
        'detalle_venta_id','producto_id','producto_compra_id',
        'producto_almacen_id','cantidad','costo_unitario','costo_total'
    ];

    public function detalleVenta(){ return $this->belongsTo(DetalleVenta::class); }
    public function producto(){ return $this->belongsTo(Producto::class); }
    public function productoCompra(){ return $this->belongsTo(Producto_compra::class, 'producto_compra_id'); }
    public function productoAlmacen(){ return $this->belongsTo(Producto_almacen::class, 'producto_almacen_id'); }
}