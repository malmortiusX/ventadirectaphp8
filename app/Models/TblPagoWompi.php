<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblPagoWompi extends Model
{
    public $timestamps = false;
    protected $table = 'tbl_pagos_wompi';


    protected $fillable = [
        'id',
        'valor',
        'id_usuario',
        'id_pedido',
        'fecha_creacion',
        'id_wompi'
    ];
}
