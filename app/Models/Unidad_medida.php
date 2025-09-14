<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unidad_medida extends Model
{
    protected $table = 'unidad_medida';
    protected $fillable = [
        'id_empresa','nombre','estado'
    ];
}
