<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    protected $table = 'detalle_venta';
    protected $fillable = [
        'venta_id',
        'producto_id',
        'unidad_medida_id',
        'cantidad',
        'precio_unitario',
        'subtotal',
    ];
    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
    public function unidadMedida()
    {
        return $this->belongsTo(Unidad_medida::class);
    }
}
