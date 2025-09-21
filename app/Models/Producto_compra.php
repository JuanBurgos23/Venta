<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto_compra extends Model
{
    protected $table = 'producto_compra'; // <- corrige el nombre

    protected $fillable = [
        'producto_id',
        'compra_id',
        'empresa_id',
        'lote',
        'fecha_vencimiento',
        'cantidad',
        'costo_unitario',
        'costo_total',
    ];

    public function compra()
    {
        return $this->belongsTo(Compra::class, 'compra_id');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}