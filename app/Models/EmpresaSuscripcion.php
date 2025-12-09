<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmpresaSuscripcion extends Model
{
    protected $table = 'empresa_suscripcion';

    protected $fillable = [
        'empresa_id',
        'suscripcion_id',
        'fecha_inicio',
        'fecha_fin',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function suscripcion()
    {
        return $this->belongsTo(Suscripcion::class);
    }
}
