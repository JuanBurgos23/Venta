<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedor';

    protected $fillable = [
        'nombre',
        'paterno',
        'materno',
        'telefono',
        'correo',     // <--- agréguelo
        'ci',
        'id_empresa',
        'estado'
    ];

    protected $casts = [
        'estado' => 'integer',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }

    public function compras()
    {
        return $this->hasMany(Compra::class, 'id_proveedor');
    }

    public function productos()
    {
        return $this->hasMany(Producto::class, 'proveedor_id');
    }
}

