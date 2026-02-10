<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormaPago extends Model
{
    protected $table = 'forma_pago';

    protected $fillable = ['nombre'];

    public function detallesCaja()
    {
        return $this->hasMany(DetalleCaja::class, 'id_forma_pago');
    }
}
