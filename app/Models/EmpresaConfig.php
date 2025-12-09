<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmpresaConfig extends Model
{
    protected $table = 'empresa_config';
    protected $fillable = ['id_empresa', 'configuraciones'];
    protected $casts = [
        'configuraciones' => 'array'
    ];

    public function empresa() {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }
}
