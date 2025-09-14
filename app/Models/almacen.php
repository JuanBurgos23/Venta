<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class almacen extends Model
{
    protected $table = 'almacen';
    protected $fillable = [
        'sucursal_id','nombre','estado'
    ];

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }

    public function empresa()
    {
        // acceso conveniente
        return $this->hasOneThrough(Empresa::class, Sucursal::class, 'id', 'id', 'sucursal_id', 'empresa_id');
    }
}
