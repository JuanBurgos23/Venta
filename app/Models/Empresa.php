<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = 'empresa';
    protected $fillable = [
        'nombre',
        'logo',
        'telefono',
        'correo',
        'direccion',
        'nit',
        'qr'

    ];
    public function users()
    {
        return $this->hasMany(User::class, 'id_empresa');
    }

    public function sucursal()
    {
        return $this->hasMany(Sucursal::class);
    }

    public function suscripciones()
    {
        return $this->belongsToMany(Suscripcion::class, 'empresa_suscripcion')
            ->withPivot(['fecha_inicio', 'fecha_fin'])
            ->withTimestamps();
    }

    public function empresaSuscripciones()
    {
        return $this->hasMany(EmpresaSuscripcion::class);
    }
}
