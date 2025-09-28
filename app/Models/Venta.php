<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'venta';
    protected $fillable = [
        'codigo',
        'fecha',
        'cliente_id',
        'usuario_id',
        'empresa_id',
        'almacen_id',
        'descuento',
        'total',
        'forma_pago',
        'estado',
        'observaciones',
    ];
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
    public function almacen()
    {
        return $this->belongsTo(Almacen::class);    
    }
    public function detalles()
    {
        return $this->hasMany(DetalleVenta::class);
    }
}
 