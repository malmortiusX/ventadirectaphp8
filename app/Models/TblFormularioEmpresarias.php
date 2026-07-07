<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblFormularioEmpresarias extends Model
{
    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_modificacion';
    protected $table = 'tbl_formulario_empresarias';

    protected $fillable = [
        'nombres_empresaria',
        'apellidos_empresaria',
        'fecha_nacimiento_empresaria',
        'cedula_empresaria',
        'ciudad_expedicion_empresaria',
        'direccion_empresaria',
        'ciudad_empresaria',
        'barrio_empresaria',
        'telefono_empresaria',
        'correo_empresaria',
        'nombres_referenciador',
        'apellidos_referenciador',
        'telefono_referenciador',
        'direccion_referenciador',
        'ciudad_referenciador',
        'codigo_cedula_referenciador',
        'nombres_referencia_familiar_1',
        'apellidos_referencia_familiar_1',
        'parentesco_referencia_familiar_1',
        'direccion_referencia_familiar_1',
        'telefono_referencia_familiar_1',
        'nombres_referencia_familiar_2',
        'apellidos_referencia_familiar_2',
        'parentesco_referencia_familiar_2',
        'direccion_referencia_familiar_2',
        'telefono_referencia_familiar_2',
        'nombre_referencia_comercial_1',
        'direccion_referencia_comercial_1',
        'telefono_referencia_comercial_1',
        'nombre_referencia_comercial_2',
        'direccion_referencia_comercial_2',
        'ciudad_cliente_vd',
        'telefono_referencia_comercial_2',
        'cedula_empresaria_cara_1',
        'cedula_empresaria_cara_2',
        'firma_empresaria',
        'fecha_creacion',
        'fecha_modificacion'
    ];
}
