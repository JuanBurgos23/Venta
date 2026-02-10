<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppPantalla extends Model
{
    protected $table = 'app_pantallas';
    protected $fillable = ['modulo_id', 'nombre', 'route_name', 'uri', 'orden', 'estado'];

    public function modulo()
    {
        return $this->belongsTo(AppModulo::class, 'modulo_id');
    }
}
