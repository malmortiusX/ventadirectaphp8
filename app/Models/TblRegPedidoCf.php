<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblRegPedidoCf extends Model
{
    public $timestamps = false;
    protected $table = 'tbl_reg_pedidos_cf';
    protected $primaryKey = 'id_reg_pedidos';

    protected $fillable = [
        'id_reg_pedidos', 'id_pedido', 'codigo', 'nombre', 'klu', 'ulu', 'kma', 'uma', 'kmi', 'umi', 'kju', 'uju', 'kvi', 'uvi', 'ksa', 'usa', 'kdo', 'udo', 'peso_unidad', 'undmed', 'peso'
    ];
}
