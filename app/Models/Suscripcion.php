<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suscripcion extends Model
{
    protected $table = 'suscripcion';

    protected $fillable = [
        'nombre',
        'descripcion',
        'estado',
    ];

    protected $casts = [
        'estado' => 'boolean',
    ];

    public function empresas()
    {
        return $this->belongsToMany(Empresa::class, 'empresa_suscripcion')
            ->withPivot(['fecha_inicio', 'fecha_fin'])
            ->withTimestamps();
    }

    public function empresaSuscripciones()
    {
        return $this->hasMany(EmpresaSuscripcion::class, 'suscripcion_id');
    }
}
