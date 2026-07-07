<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblMarca extends Model
{
    public $timestamps = false;
    protected $table = 'tbl_marcas';

    protected $fillable = [
        'id', 'nombre'
    ];
}
