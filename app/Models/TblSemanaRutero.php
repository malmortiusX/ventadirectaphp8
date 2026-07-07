<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblSemanaRutero extends Model
{
    public $timestamps = false;
    protected $table = 'tbl_semanas_rutero';
    protected $primaryKey = 'fecha';

    protected $fillable = [
        'fecha', 'semana', 'mes'
    ];
}
