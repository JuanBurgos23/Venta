<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoIngresoEgreso extends Model
{
    protected $table = 'tipo_ingreso_egreso';
    protected $fillable = ['nombre','descripcion','tipo', 'estado', 'empresa_id'];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
}
