<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'producto';

    protected $fillable = [
        'id_empresa',
        'unidad_medida_id',
        'tipo_producto_id',
        'categoria_id',
        'subcategoria_id',
        'tipo_precio_id',
        'codigo',
        'nombre',
        'foto',
        'descripcion',
        'marca',
        'modelo',
        'origen',
        'estado',
        'proveedor_id',
        'inventariable',
    ];

    // --------------- BelongsTo ---------------
    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }

    public function unidadMedida()
    {
        return $this->belongsTo(Unidad_medida::class, 'unidad_medida_id');
    }

    public function tipoProducto()
    {
        return $this->belongsTo(Tipo_producto::class, 'tipo_producto_id');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function subcategoria()
    {
        return $this->belongsTo(Subcategoria::class, 'subcategoria_id');
    }

    public function tipoPrecio()
    {
        return $this->belongsTo(Tipo_precio::class, 'tipo_precio_id');
    }

    // --------------- Scopes útiles ---------------
    // Filtrar por empresa
    public function scopeDeEmpresa($q, $empresaId)
    {
        return $q->where('id_empresa', $empresaId);
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }

    // Búsqueda rápida
    public function scopeBuscar($q, $term)
    {
        if (!$term) return $q;
        return $q->where(function($w) use ($term) {
            $w->where('codigo', 'like', "%{$term}%")
              ->orWhere('nombre', 'like', "%{$term}%")
              ->orWhere('marca', 'like', "%{$term}%")
              ->orWhere('modelo', 'like', "%{$term}%");
        });
    }
}
