<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblCentDist extends Model
{
    public $timestamps = false;
    protected $table = 'tbl_centdist';
    protected $primaryKey = 'cop';

    protected $fillable = [
        'cop',
        'nombre',
        'localizacion',
        'codcc',
        'hora_inicial',
        'hora_final',
        'planta',
        'nit',
        'razon_social',
        'direccion',
        'ciudad',
        'departamento',
        'telefono',
        'codinvima',
        'marca',
        'direccion_establecimiento',
        'especie',
        'dictamen',
        'temperatura',
        'nombre_veterinario',
        'firma_veterinario',
        'nombre_despachos',
        'firma_despachos',
        'controla_tope'
    ];

    protected $casts = [
        'cop' => 'string'
    ];
}
