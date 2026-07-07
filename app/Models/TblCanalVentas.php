<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblCanalVentas extends Model
{
    public $timestamps = false;
    protected $table = 'tbl_canales_ventas';

    protected $fillable = [
        'id', 'nombre'
    ];
}
