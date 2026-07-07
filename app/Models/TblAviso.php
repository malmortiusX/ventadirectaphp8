<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblAviso extends Model
{
    public $timestamps = false;
    protected $table = 'tbl_aviso';


    protected $fillable = [
        'id',
        'aviso',
        'nivel',
        'fecha_inicial',
        'fecha_final',
        'fecha_creacion'
    ];
}
