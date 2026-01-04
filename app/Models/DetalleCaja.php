<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleCaja extends Model
{
    protected $table = 'detalle_caja';

    protected $fillable = [
        'caja_id',
        'id_tipo_movimiento',
        'movimiento',
        'id_movimiento',
        'fecha_movimiento',
        'monto',
        'estado',
    ];

    protected $casts = [
        'fecha_movimiento' => 'datetime',
        'monto' => 'decimal:2',
    ];

    public function tipoMovimiento()
    {
        return $this->belongsTo(TipoMovimiento::class, 'id_tipo_movimiento');
    }

    public function caja()
    {
        // si ya tienes el modelo Caja:
        return $this->belongsTo(Caja::class, 'caja_id');
    }
}
