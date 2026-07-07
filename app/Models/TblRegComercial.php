<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblRegComercial extends Model
{
    public $timestamps = false;
    protected $table = 'tbl_reg_comercial';
    protected $primaryKey = 'id_reg_comercial';

    protected $fillable = [
        'id_reg_comercial',
        'id_comercial',
        'id_producto',
        'unidades',
        'peso',
        'valor_un',
        'valor_kg',
        'modificado',
        'rango_1',
        'rango_2',
        'un_despachado',
        'kg_despachado',
        'un_diferencia',
        'kg_diferencia',
        'refrigeracion',
        'venta_por',
        'descuento',
        'totald',
        'porcentaje_iva',
        'valor_iva',
        'total',
        'obsequio',
        'tiquetear',
        'porcentaje_d'
    ];
}
