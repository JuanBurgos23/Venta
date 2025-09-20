<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto_almacen extends Model
{
    protected $table = 'producto_almacen';
    protected $fillable = [
        'producto_id',
        'almacen_id',
        'empresa_id',
        'producto_compra_id', // opcional
        'lote',               // visible
        'id_lote',            // interno
        'stock',
        'estado',
    ];
    
    public function productoCompra() { 
        return $this->belongsTo(Producto_compra::class, 'producto_compra_id'); 
    }

    public function producto()        { return $this->belongsTo(Producto::class); }
    public function almacen()         { return $this->belongsTo(Almacen::class); }
    public function empresa()         { return $this->belongsTo(Empresa::class, 'empresa_id'); }
}
