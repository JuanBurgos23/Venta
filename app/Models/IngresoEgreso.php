<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IngresoEgreso extends Model
{
    protected $table = 'ingreso_egreso';
    protected $fillable = ['usuario_id', 'descripcion', 'fecha', 'motivo', 'id_forma_pago', 'tipo_ingreso_egreso_id', 'monto'];

    public function tipoIngresoEgreso()
    {
        return $this->belongsTo(TipoIngresoEgreso::class, 'tipo_ingreso_egreso_id');
    }
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
