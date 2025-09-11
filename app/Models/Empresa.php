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

    ];
    public function users()
    {
        return $this->hasMany(User::class, 'id_empresa');
    }
}
