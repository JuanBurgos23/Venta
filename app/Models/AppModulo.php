<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppModulo extends Model
{
    protected $table = 'app_modulos';
    protected $fillable = ['nombre', 'icono', 'orden', 'estado'];

    public function pantallas()
    {
        return $this->hasMany(AppPantalla::class, 'modulo_id');
    }
}
