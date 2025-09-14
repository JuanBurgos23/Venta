<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tipo_precio extends Model
{
    protected $table = 'tipo_precio';
    protected $fillable = [
        'id_empresa','nombre','descripcion','estado'
    ];
}
