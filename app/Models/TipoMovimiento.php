<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoMovimiento extends Model
{
    protected $table = 'tipo_movimiento';

    protected $fillable = [
        'nombre',
        'descripcion',
        'estado',
    ];

    public function detallesCaja()
    {
        return $this->hasMany(DetalleCaja::class, 'id_tipo_movimiento');
    }
}
