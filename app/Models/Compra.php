<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $table = 'compra';

    protected $fillable = [
        'id_empresa',
        'sucursal_id',
        'almacen_id',
        'proveedor_id',   // <- usa proveedor_id en fillable (coincide con la columna)
        'fecha_ingreso',
        'tipo',
        'subtotal',
        'descuento',
        'total',
        'estado',
        'observacion',
        'recepcion',
        'usuario_id'
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id'); // <- corrige FK
    }

    public function items()
    {
        return $this->hasMany(Producto_compra::class, 'compra_id');
    }
}
