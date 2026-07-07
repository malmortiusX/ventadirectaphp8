<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblProducto extends Model
{
    public $timestamps = false;
    protected $table = 'tbl_producto';
    protected $primaryKey = 'id_producto';

    protected $fillable = [
        'id_producto', 'nombre', 'nombre_corto', 'codigo', 'abreviatura', 'id_linea', 'fecha_ingreso', 'fecha_modificacion', 'id_tipo_producto', 'peso_unidad', 'undmed', 'codlinea', 'desclinea', 'tipoinv', 'activo', 'sondear', 'porciva'
    ];

    /**
     * Relaciones de eloquent
     */

    // Listas de Descuento en las que se encuentra
    public function listasDescuento() {
        return $this->belongsToMany('App\Models\TblListaDescuento', 'tbl_rel_lista_descuento_vol', 'codigo_producto', 'codigo_lista', 'codigo', 'codigo')->distinct('codigo_producto');
    }

    // Buscar rangos de la lista de descuento
    public function rangos() {
        return $this->belongsToMany('App\Models\TblListaDescuento', 'tbl_rel_lista_descuento_vol', 'codigo_producto', 'codigo_lista', 'codigo', 'codigo')
            ->withPivot('rango', 'cantidad_kg', 'cantidad_un', 'porcentaje')
            ->where('tbl_lista_descuento.estado', 1)
            ->orderBy('rango', 'asc');
    }
}
