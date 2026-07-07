<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblNoCompra extends Model
{
    public $timestamps = false;
    protected $table = 'tbl_no_compra';
    protected $primaryKey = 'id_no_compra';

    protected $fillable = [
		'id_no_compra', 'id_cliente', 'fecha_no_compra', 'id_usuario', 'codigo_lista', 'creado_por', 'motivo', 'nombre_cli', 'direccion_cli', 'tipo_cli', 'longitud_cli', 'latitud_cli', 'precision_cli'
	];
}