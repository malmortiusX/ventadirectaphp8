<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblFacturaAnulada extends Model
{
    public $timestamps = false;
    protected $table = 'tbl_factura_anulada';
    protected $primaryKey = 'id_factura_anulada';

    protected $fillable = [
        'nit',
        'nombre_cliente',
        'direccion_cliente',
        'telefono_cliente',
        'centro_operacion',
        'tipo_documento',
        'numero_documento',
        'fecha',
        'valor',
        'tipo_devolucion',
        'observacion',
        'id_usuario_registro',
    ];

    public function usuarioRegistro()
    {
        return $this->belongsTo(TblUsuario::class, 'id_usuario_registro', 'id_usuario');
    }
}