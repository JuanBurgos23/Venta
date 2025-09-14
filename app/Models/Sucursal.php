<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    protected $table = 'sucursal';
    protected $fillable = [
        'empresa_id','nombre','telefono','correo',
        'direccion','ciudad','departamento','lat','lng',
        'estado'
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function almacen()
    {
        return $this->hasMany(Almacen::class);
    }
}
