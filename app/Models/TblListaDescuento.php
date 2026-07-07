<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblListaDescuento extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'string';
    protected $table = 'tbl_lista_descuento';
    protected $primaryKey = 'codigo';

    protected $fillable = [
        'codigo',
        'nombre',
        'fecha_activacion',
        'fecha_creado',
        'fecha_modificado',
        'estado',
        'porcentaje',
    ];

    /**
     * Relaciones de eloquent
     */

    // Productos de la lista
    public function productos() {
        return $this->belongsToMany('App\Models\TblProducto', 'tbl_rel_lista_descuento_vol', 'codigo_lista', 'codigo_producto', 'codigo', 'codigo')->distinct('codigo_producto');
    }

    // Buscar Productos de la lista
    public function rangos($producto) {
        return $this->belongsToMany('App\Models\TblProducto', 'tbl_rel_lista_descuento_vol', 'codigo_lista', 'codigo_producto', 'codigo', 'codigo')
            ->withPivot('rango', 'cantidad_kg', 'cantidad_un', 'porcentaje')
            ->where('codigo_producto', $producto)
            ->orderBy('rango', 'asc')
            ->get();
    }
}
