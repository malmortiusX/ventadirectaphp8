<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblEmpresa extends Model
{
    public $timestamps = false;
    public $incrementing = false;
    protected $table = 'tbl_empresa';
    protected $primaryKey = 'nit';
    protected $keyType = 'string';

    protected $fillable = [
        'nit', 'nombre', 'logo', 'login', 'color', 'color_rgb', 'color2', 'color2_rgb', 'decimales', 'modusoperandi', 'pqrs'
    ];
}
