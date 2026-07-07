<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblAbono extends Model
{
    public $timestamps = false;
    protected $table = 'tbl_abonos';


    protected $fillable = [
        'id',
        'cedula',
        'abono',
        'fecha_abono',
        'fecha_creacion'
    ];
}
