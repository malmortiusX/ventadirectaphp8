<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblTipoCliente extends Model
{
    public $timestamps = false;
    protected $table = 'tbl_tipo_cliente';
    protected $primaryKey = 'id_tipo_cliente';

    protected $fillable = [
        'id_tipo_cliente', 'nombre_tipo_cliente', 'sigla', 'id_canal', 'clase'
    ];
}