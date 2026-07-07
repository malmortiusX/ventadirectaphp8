<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblLinea extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'string';
    protected $table = 'tbl_linea';
    protected $primaryKey = 'id_linea';

    protected $fillable = [
        'id_linea',
        'categoria',
        'nombre_cat',
        'codigo',
        'descripcion',
        'fecha_ingreso',
        'fecha_modificacion',
    ];
}
