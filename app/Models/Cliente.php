<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'cliente';
    protected $fillable = [
        'nombres',
        'telefono',
        'correo',
        'ci',
        'id_empresa',
        'estado'
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }
    public function getNombreCompletoAttribute()
    {
        return "{$this->nombre} {$this->paterno} {$this->materno}";
    }
}
