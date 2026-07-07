<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MvGuiaTransporte extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'mvguiatr';
    protected $primaryKey = 'ID';

    protected $fillable = [
        'ID',
        'TIPODCTO',
        'NRODCTO',
        'COP',
        'TDCTO',
        'DCTO',
        'NIT',
        'NOMCLIENTE',
        'DIRCLIENTE',
        'CODIGO',
        'NOMBRE',
        'CANTIDAD',
        'CANTEMPAQ',
        'CODLOTE',
        'FECPROD',
        'FECVENCE',
        'NOTA',
        'PLACA',
        'FECHASAL',
        'CONDUC',
        'NOMCOND',
        'NITTRASP',
        'NOMEMPRESA',
        'DESTINO',
        'FECHAENT',
        'CIUDAD',
        'OBSERVAC',
        'DPTO',
    ];
}
