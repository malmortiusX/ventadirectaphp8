<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblClienteVd extends Model
{
    public $timestamps = false;
    protected $table = 'tbl_clientes_vd';
    protected $primaryKey = 'id_cliente_vd';

    protected $fillable = [
        'id_usuario', 'nombres', 'apellidos', 'cedula', 'telefono', 'direccion', 'barrio', 'id_ciudad'
    ];

    // Ciudad
    public function ciudad() {
        return $this->belongsTo('App\Models\Ciudad', 'id_ciudad', 'id_ciudad');
    }
}
